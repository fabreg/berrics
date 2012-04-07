<?php

App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));

class CanteenOrder extends AppModel {
	var $name = 'CanteenOrder';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Currency' => array(
			'className' => 'Currency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'CanteenOrderItem' => array(
			'className' => 'CanteenOrderItem',
			'foreignKey' => 'canteen_order_id',
			'dependent' => false,
			
		),
		'CanteenOrderNote' => array(
			'className' => 'CanteenOrderNote',
			'foreignKey' => 'canteen_order_id',
			'dependent' => false,
			
		),
		'CanteenShippingRecord' => array(
			'className' => 'CanteenShippingRecord',
			'foreignKey' => 'canteen_order_id',
			'dependent' => false,
			
		),
		"UserAddress"=>array(
			"conditions"=>array("UserAddress.model"=>"CanteenOrder"),
			"foreignKey"=>"foreign_key"
		),
		"GatewayTransaction"=>array(
			"conditions"=>array("GatewayTransaction.model"=>"CanteenOrder"),
			"foreignKey"=>"foreign_key"
		),
		"EmailMessage"=>array(
			"conditions"=>array("EmailMessage.model"=>"CanteenOrder"),
			"foreignKey"=>"foreign_key"
		)
	);


	var $hasAndBelongsToMany = array(
		'CanteenBatch' => array(
			'className' => 'CanteenBatch',
			'joinTable' => 'canteen_batches_canteen_orders',
			'foreignKey' => 'canteen_order_id',
			'associationForeignKey' => 'canteen_batch_id',
			
		)
	);
	
	/**
	 * Taxable Country plus province codes
	 * @var unknown_type
	 */
	public $taxZones = array(
		"US"=>array(
			"CA"=>9.75
		)
	);
	
	/*
	 * 
	 * OVERLOAD
	 * 
	 */
	public function save($data = array()) {
		
		if(empty($this->id)) {
			
			if($data['CanteenOrder']) {
				
				$data['CanteenOrder']['id'] = $this->genId();
				
			} else {
				
				$data['id'] = $this->genId();
				
			}
			
			
		}
		
		return parent::save($data);
		
	}
	
	private function genId() {
		
		$id = mt_rand(10000000,99999999);
		
		$chk = $this->find("count",array("conditions"=>array("CanteenOrder.id"=>$id)));
		
		if($chk>0) {
			
			return $this->genId();
			
		}
		
		return $id;
		
	}
	/***************/
	
	public function calculateCartTotal($CanteenOrder = array()) {
		
		$items = $CanteenOrder['CanteenOrderItem'];
		
		$CanteenOrder['CanteenOrder']['sub_total'] = 0;
		$CanteenOrder['CanteenOrder']['grand_total'] = 0;
		$CanteenOrder['CanteenOrder']['shipping_total'] = 0;
		$CanteenOrder['CanteenOrder']['tax_total'] = 0;
		
		//format shipping and billing addresses if needed
		
		if(!isset($CanteenOrder['CanteenOrder']['id'])) {
			
			if(isset($CanteenOrder['CanteenOrder']['same_as_shipping_checkbox']) && 
				$CanteenOrder['CanteenOrder']['same_as_shipping_checkbox']==1
			) {
				
				$CanteenOrder['UserAddress']['Billing'] = $CanteenOrder['UserAddress']['Shipping'];
				
			}
			
			$CanteenOrder['UserAddress'][] = array_merge($CanteenOrder['UserAddress']['Shipping'],array("address_type"=>"shipping"));
			$CanteenOrder['UserAddress'][] = array_merge($CanteenOrder['UserAddress']['Billing'],array("address_type"=>"billing"));
			
			unset($CanteenOrder['UserAddress']['Shipping'],$CanteenOrder['UserAddress']['Billing']);
			
		}
		
		$CanteenOrder = $this->CanteenOrderItem->calculateCartItems($CanteenOrder);
		
		//calculate the order totals
		#subtotal
		foreach($CanteenOrder['CanteenOrderItem'] as $k=>$v) $CanteenOrder['CanteenOrder']['sub_total'] += $v['sub_total'];
		
		#tax total
		foreach($CanteenOrder['CanteenOrderItem'] as $k=>$v) $CanteenOrder['CanteenOrder']['tax_total'] += $v['tax_total'];
		
		#shipping_total
		
		
		#grand_total
		$CanteenOrder['CanteenOrder']['grand_total'] =  $CanteenOrder['CanteenOrder']['sub_total'] + 
														$CanteenOrder['CanteenOrder']['shipping_total'] + 
														$CanteenOrder['CanteenOrder']['tax_total'];
		

		return $CanteenOrder;
		
	}
	
	public function saveOnlineOrder($CanteenOrder = array(),$attempt_charge = false) {
		
		$this->create();
		
		$CanteenOrder = $this->calculateCartTotal($CanteenOrder);
		
		
		$CanteenOrder['CanteenOrder']['order_status'] = "pending";
		$CanteenOrder['CanteenOrder']['shipping_status'] = "pending";
		$CanteenOrder['CanteenOrder']['fulfillment_status'] = "pending";
	
		if(!$this->save($CanteenOrder['CanteenOrder'])) throw new Exception("Unable to save order!");
		
		$order_id = $this->id;
		
		//save cart items
		
		foreach($CanteenOrder['CanteenOrderItem'] as $item) {
			
			$item['canteen_order_id'] = $order_id;
			
			$this->CanteenOrderItem->create();
			
			$this->CanteenOrderItem->save(array("CanteenOrderItem"=>$item));
			
			$parent_id = $this->CanteenOrderItem->id;

			foreach($item['ChildCanteenOrderItem'] as $child) {
					
				$child['parent_id'] = $parent_id;
				
				$this->CanteenOrderItem->create();
				
				$this->CanteenOrderItem->save($child);
				
			}
			
		}
		
		//save the shipping address
		foreach($CanteenOrder['UserAddress'] as $a) {
			
			$a['model'] = "CanteenOrder";
			$a['foreign_key'] = $order_id;
			$this->UserAddress->create();
			$this->UserAddress->save($a);
			
		}
		
		return $order_id;
		
	}
	
	/**
	 * 
	 * @param CanteenOrder $CanteenOrder
	 * @param String $method charge | auth 
	 * @return void
	 */
	public function chargeOnlineOrder($CanteenOrder,$method = "charge") {
		
		$gateway_id = CanteenConfig::get("gateway_account_id");
		
		
		$trans = GatewayTransactionVO::formatCanteenOrder($CanteenOrder);
		
		$res = $this->GatewayTransaction->GatewayAccount->run($method,$gateway_id,$trans);
		
		//verb to update order status
		$verb = "declined";
		
		//if the charge succeeded
		if($res) {
			
			switch(strtoupper($method)) {
				
				case "CHARGE":
					$verb = "approved";		
					break;
				case "AUTH":
					$verb = "authorized";
					break;
			}
			
			unset($CanteenOrder['CardData']);
			
		}
		
		
		$this->create();
		
		$this->id = $CanteenOrder['CanteenOrder']['id'];
		
		$this->save(array(
			"order_status"=>$verb
		));
		
		return $res;
		
	}
	
	public function returnAdminOrder($canteen_order_id = false) {

		$order = $this->find("first",array(
			"conditions"=>array(
				"CanteenOrder.id"=>$canteen_order_id
			),
			"contain"=>array(
				"UserAddress",
				"CanteenOrderItem"=>array(
					"ChildCanteenOrderItem"=>array(
						"CanteenProduct"=>array(
							"ParentCanteenProduct"=>array(
								"CanteenProductImage"
							)
						),
						"CanteenInventoryRecord"=>array("Warehouse")
					)
				),
				"CanteenOrderNote",
				"CanteenShippingRecord",
				"GatewayTransaction"=>array(
					"GatewayAccount"
				),
				"Currency"
			)
		));
		
		return $order;
	}
	
	public function extractAddresses($CanteenOrder) {
		
		$shipping = array();
		
		$billing = array();

		
	}
	
	
	
	
}
