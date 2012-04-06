<?php
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
		
		$id = mt_rand(111111,99999999);
		
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
		
		foreach($items as $k=>$v) {
			
			$c = $v['ChildCanteenOrderItem'];
			
			$v['sub_total'] = $v['quantity'] = 0;
			
			foreach($c as $key=>$val) {
				
				$_ops = array(
					"canteen_product_id" =>$val['canteen_product_id']
				);
				
				if(isset($val['parent_canteen_product_id']) && !empty($val['parent_canteen_product_id'])) $_ops['parent_canteen_product_id'] = $val['parent_canteen_product_id'];
				
				if(isset($CanteenOrder['CanteenOrder']['currency_id']) && !empty($CanteenOrder['CanteenOrder']['currency_id'])) $_ops['currency_id'] = $CanteenOrder['CanteenOrder']['currency_id'];
				
				$v['ChildCanteenOrderItem'][$key] =  array_merge($v['ChildCanteenOrderItem'][$key],$this->CanteenOrderItem->CanteenProduct->returnCartItem($_ops));
				
				$v['sub_total'] += $v['ChildCanteenOrderItem'][$key]['ParentCanteenProduct']['CanteenProductPrice'][0]['price'];
				
				$v['quantity'] += $v['ChildCanteenOrderItem'][$key]['quantity'];
				
			}
			
			$CanteenOrder['CanteenOrder']['sub_total'] += $v['sub_total'];
			
			$items[$k] = $v;
			
			$CanteenOrder['CanteenOrder']['grand_total'] += $items[$k]['sub_total'];
			
		}
		
		$CanteenOrder['CanteenOrderItem'] = $items;

		//die(print_r($CanteenOrder));
		return $CanteenOrder;
		
		
	}
	
	public function saveOnlineOrder($CanteenOrder = array(),$attempt_charge = false) {
		
		$this->create();
		
		$CanteenOrder = $this->calculateCartTotal($CanteenOrder);
		
		if(!$this->save($CanteenOrder)) return false;
		
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
		
		//save addresses
		
		//save the shipping address
		if(isset($CanteenOrder['UserAddress']['Shipping'])) {
			
			$this->UserAddress->create();
			
			$CanteenOrder['UserAddress']['Shipping']['foreign_key'] = $order_id;
			
			$CanteenOrder['UserAddress']['Shipping']['model'] = "CanteenOrder";
			
			$CanteenOrder['UserAddress']['Shipping']['address_type'] = "shipping";
			
			$this->UserAddress->save($CanteenOrder['UserAddress']['Shipping']);
			
		}
		
		if($attempt_charge) {
			
			$order = $this->returnAdminOrder($order_id);
			$trans_data = GatewayTransactionVO::formatCanteenOrder(array_merge($CanteenOrder,$order));
			
			die(print_r($trans_data));
			
		}
		
		return $order_id;
		
	}
	
	public function returnAdminOrder($canteen_order_id = false) {
		
		$order = $this->find("first",array(
			"conditions"=>array(),
			"contain"=>array(
				"UserAddress",
				"CanteenOrderItem"=>array(
					"ChildCanteenOrderItem"=>array(
						"CanteenProduct"=>array("ParentCanteenProduct"),
						"CanteenInventoryRecord"=>array("Warehouse")
					)
				),
				"CanteenOrderNote",
				"CanteenShippingRecord",
				"GatewayTransaction"=>array(
					"GatewayAccount"
				)
			)
		));
		
		return $order;
	}
	
	
	
	
}
