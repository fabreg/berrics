<?php

App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));
ClassRegistry::init("CanteenShippingRecord");

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
		),
		"CanteenPromoCode",
		"UserAccountCanteenPromoCode"=>array(
			"className"=>"CanteenPromoCode",
			"foreignKey"=>"user_account_canteen_promo_code_id"
		),
		"PromotionCanteenPromoCode"=>array(
			"className"=>"CanteenPromoCode",
			"foreignKey"=>"promotion_canteen_promo_code_id"
		),
		"ShippingCanteenPromoCode"=>array(
			"className"=>"CanteenPromoCode",
			"foreignKey"=>"shipping_canteen_promo_code_id"
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
		),
		'CanteenShippingRecord' => array(
			'className' => 'CanteenShippingRecord',
			'foreignKey' => 'canteen_order_id',
			'dependent' => false,
			
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
	public $hasOne = array(
		"ShippingAddress"=>array(
			"className"=>"UserAddress",
			"conditions"=>array("ShippingAddress.address_type"=>"shipping","ShippingAddress.model"=>"CanteenOrder"),
			"foreignKey"=>"foreign_key"
		),
		"BillingAddress"=>array(
			"className"=>"UserAddress",
			"conditions"=>array("BillingAddress.address_type"=>"billing","BillingAddress.model"=>"CanteenOrder"),
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
	
	public function setCardValidation() {
		
		$this->validate = array(
			"cc_num"=>"cc"
		);
		
	}
	
	/**
	 * Taxable Country plus province codes
	 * @var unknown_type
	 */
	public $taxZones = array(
		"US"=>array(
			"CA"=>10.00
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
				$data['CanteenOrder']['hash'] = sha1($data['CanteenOrder']['id']);
			} else {
				
				$data['id'] = $this->genId();
				$data['hash'] = sha1($data['id']);
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
	
	/**
	 * Calculate the cart and format it to be inserted into
	 * the database
	 * 
	 * @param $CanteenOrder
	 * @return $CanteenOrder
	 */
	public function calculateCartTotal($CanteenOrder = array()) {
		
		$same_as_shipping = (isset($CanteenOrder['CanteenOrder']['same_as_shipping_checkbox'])) ? $CanteenOrder['CanteenOrder']['same_as_shipping_checkbox']:1;

		//die(pr($CanteenOrder));

		$items = $CanteenOrder['CanteenOrderItem'];
		
		#zero it out
		$CanteenOrder['CanteenOrder']['sub_total'] 		= 0;
		$CanteenOrder['CanteenOrder']['grand_total'] 	= 0;
		$CanteenOrder['CanteenOrder']['shipping_total'] = 0;
		$CanteenOrder['CanteenOrder']['tax_total'] 		= 0;
		$CanteenOrder['CanteenOrder']['discount_total'] = 0;
		$CanteenOrder['CanteenOrder']['taxable_total']	= 0;
		
		//die(print_r($CanteenOrder));
		#the method says it all
		$CanteenOrder = $this->CanteenOrderItem->calculateCartItems($CanteenOrder);
		
		//calculate the order totals
		#subtotal
		foreach($CanteenOrder['CanteenOrderItem'] as $k=>$v) $CanteenOrder['CanteenOrder']['sub_total'] += $v['sub_total'];

		#shipping_total
		$weights = Set::extract("/CanteenOrderItem/ChildCanteenOrderItem/weight",$CanteenOrder);
		
		$weight = array_sum($weights);
		
		$shp_total = CanteenShippingRecord::returnShippingRate($weight,$CanteenOrder['ShippingAddress']['country_code'],"standard");
		
		$CanteenOrder['CanteenOrder']['shipping_total'] = $this->Currency->convertCurrency("USD",$CanteenOrder['CanteenOrder']['currency_id'],$shp_total);
		
		#calculate promo codes
		$CanteenOrder = $this->CanteenPromoCode->applyPromoCode($CanteenOrder);
		
		#calculate tax off of taxable total
		$CanteenOrder['CanteenOrder']['tax_rate'] = 0.00;
		
		$address = $CanteenOrder['ShippingAddress'];
		
		if(
			array_key_exists($address['country_code'],$this->taxZones) && 
			array_key_exists($address['state'],$this->taxZones[$address['country_code']])
		) {
			
			$CanteenOrder['CanteenOrder']['tax_rate'] = $this->taxZones[$address['country_code']][$address['state']];
			
		}
		
		$CanteenOrder['CanteenOrder']['tax_total'] = ($CanteenOrder['CanteenOrder']['tax_rate']/100)*$CanteenOrder['CanteenOrder']['taxable_total'];
		
		#grand_total
		$CanteenOrder['CanteenOrder']['grand_total'] =  $CanteenOrder['CanteenOrder']['sub_total'] + 
														$CanteenOrder['CanteenOrder']['shipping_total'] + 
														$CanteenOrder['CanteenOrder']['tax_total'];
		

		$CanteenOrder['CanteenOrder']['same_as_shipping_checkbox'] = $same_as_shipping;

		return $CanteenOrder;
		
	}
	
	/**
	 * 
	 * 
	 * @param $CanteenOrder
	 * @param $attempt_charge Boolean
	 * @return $CanteenOrderId Int
	 */
	public function saveOnlineOrder($CanteenOrder = array(),$attempt_charge = false) {
		
		$this->create();
		
		$CanteenOrder['CanteenOrder']['order_status'] = "pending";
		$CanteenOrder['CanteenOrder']['shipping_status'] = "pending";
		$CanteenOrder['CanteenOrder']['fulfillment_status'] = "pending";

		//format addresses 
		$CanteenOrder = $this->formatOnlineOrderAddresses($CanteenOrder);
		
		if(isset($CanteenOrder['CanteenOrder']['id'])) {
			
			$this->id = $CanteenOrder['CanteenOrder']['id'];
			
		}

		$CanteenOrder = $this->calculateCartTotal($CanteenOrder);
		
		if(!$this->save($CanteenOrder['CanteenOrder'])) throw new Exception("Unable to save order!");
		
		$order_id = $this->id;
		
		//save the shipping address
		$this->ShippingAddress->create();
		if(isset($CanteenOrder['ShippingAddress']['id'])) $this->ShippingAddress->id = $CanteenOrder['ShippingAddress']['id'];
		$CanteenOrder['ShippingAddress']['foreign_key'] = $order_id;
		$CanteenOrder['ShippingAddress']['address_type'] = "shipping";
		$this->ShippingAddress->save($CanteenOrder['ShippingAddress']);
		
		//die(print_r($this->ShippingAddress->findById(49)));
		
		$this->BillingAddress->create();
		if(isset($CanteenOrder['BillingAddress']['id'])) $this->BillingAddress->id = $CanteenOrder['BillingAddress']['id'];
		$CanteenOrder['BillingAddress']['foreign_key'] = $order_id;
		$CanteenOrder['BillingAddress']['address_type'] = "billing";
		$this->BillingAddress->save($CanteenOrder['BillingAddress']);
		

		//save cart items
		foreach($CanteenOrder['CanteenOrderItem'] as $item) {
			
			$item['canteen_order_id'] = $order_id;
			
			$this->CanteenOrderItem->create();
			
			if(isset($item['id'])) $this->CanteenOrderItem->id = $item['id'];
			
			$this->CanteenOrderItem->save(array("CanteenOrderItem"=>$item));
			
			$parent_id = $this->CanteenOrderItem->id;

			foreach($item['ChildCanteenOrderItem'] as $child) {
					
				$child['parent_id'] = $parent_id;
				
				$child['canteen_inventory_record_id'] = $child['CanteenProduct']['CanteenInventoryRecord']['id'];

				$this->CanteenOrderItem->create();
				
				if(isset($child['id'])) $this->CanteenOrderItem->id = $child['id'];
				
				$this->CanteenOrderItem->save($child);
				
			}
			
		}

		return $order_id;
		
	}
	
	public function formatOnlineOrderAddresses($CanteenOrder) {
		
	//format shipping and billing addresses if needed
		if(isset($CanteenOrder['CanteenOrder']['same_as_shipping_checkbox']) && 
			$CanteenOrder['CanteenOrder']['same_as_shipping_checkbox']==1
		) {
			$ba = $CanteenOrder['ShippingAddress'];
			unset($ba['id']);
			$CanteenOrder['BillingAddress'] = $ba;
			$CanteenOrder['BillingAddress']['address_type'] = "billing";
		}
		
		$CanteenOrder['BillingAddress']['model'] = 
		$CanteenOrder['ShippingAddress']['model'] = "CanteenOrder";
		
		return $CanteenOrder;
		
	}

	
	/**
	 * 
	 * @param CanteenOrder $CanteenOrder
	 * @param String $method charge | auth 
	 * @return void
	 */
	public function chargeOnlineOrder($CanteenOrder,$method = "charge") {
		
		$gateway_id = CanteenConfig::get("gateway_account_id");
		
		$possible_fraud = false;
		
		$trans = GatewayTransactionVO::formatCanteenOrder($CanteenOrder);
		//check geo country
		
		if($_SERVER['GEOIP_COUNTRY_CODE']!=$CanteenOrder['BillingAddress']['country_code']) {
			
			$method = "auth";
			
			$possible_fraud = true;

		}
		
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
		
		if($res) {
			
			//allocate inventory
			$_SERVER['FORCEMASTER'] = true;
			$this->processOrderInventory($CanteenOrder['CanteenOrder']['id']);
			$this->CanteenShippingRecord->createShipment($CanteenOrder['CanteenOrder']['id']);
			unset($_SERVER['FORCEMASTER']);
			
			//queue order email
			$this->EmailMessage->canteenOrderConfirmation($CanteenOrder);
			
			if($possible_fraud) {
				
				$this->CanteenOrderNote->addHiddenNote(array(
					"canteen_order_id"=>$CanteenOrder['CanteenOrder']['id'],
					"message"=>"Possible Fraud. Confirm Order With Customer"
				));
				
			}
			
		}
		
		return $res;
		
	}
	
	public function processOrderInventory($canteen_order_id) {
		
		$order = $this->returnAdminOrder($canteen_order_id);
		
		//check all the sub items and allocate the invventory record and debit qty as allocated
		foreach($order['CanteenOrderItem'] as $item) {
			
			foreach($item['ChildCanteenOrderItem'] as $child) {
				
				if($inv_id = $child['CanteenProduct']['CanteenProductInventory'][0]['CanteenInventoryRecord']['id']) {
				
					$qty = $child['quantity'];
					
					$this->CanteenOrderItem->create();
					
					$this->CanteenOrderItem->id = $child['id'];
					
					if(
						$this->CanteenOrderItem->CanteenProduct->CanteenProductInventory->CanteenInventoryRecord->allocateInventory($inv_id,$child['quantity'])
					) {
						
						$this->CanteenOrderItem->save(array(
							"canteen_inventory_record_id"=>$inv_id
						));
							
					}

				}
			}
			
		}
		
	}
	
	public function returnAdminOrder($canteen_order_id = false,$options = array()) {

		$_contain = array(
				"CanteenOrderNote"=>array(
					"User",
					"order"=>array("CanteenOrderNote.id"=>"DESC")
				),
				"CanteenShippingRecord"=>array("Warehouse"),
				"Currency",
				"CanteenPromoCode",	
				"ShippingCanteenPromoCode",
				"PromotionCanteenPromoCode",
				"UserAccountCanteenPromoCode",
				"BillingAddress",
				"ShippingAddress",
				"CanteenOrderItem"=>array(
					"ChildCanteenOrderItem"=>array(
						"CanteenInventoryRecord"=>array("Warehouse"),
						"CanteenProduct"=>array(
							"CanteenProductInventory"=>array(
								"order"=>array("CanteenProductInventory.priority"=>"DESC"),
								"CanteenInventoryRecord"=>array("Warehouse")
							),
							"ParentCanteenProduct"=>array(
								"CanteenProductImage"
							)
						),
						"CanteenShippingRecord"=>array("Warehouse")
					),
					
				),
				
				"GatewayTransaction"=>array(
					"order"=>array("GatewayTransaction.created"=>"DESC"),
					"GatewayAccount"
				),
				"EmailMessage"
			);
		
		if(isset($options['with_shipping_items'])) {
			
			$_contain['CanteenShippingRecord'] = array(
				"Warehouse",
				"CanteenOrderItem"
			);
			
		}
			
		$order = $this->find("first",array(
			"conditions"=>array(
				"CanteenOrder.id"=>$canteen_order_id
			),
			"contain"=>$_contain
		));
		
		return $order;
	}
	
	public function extractAddresses($CanteenOrder) {
		
		$shipping = array();
		
		$billing = array();

		
	}
	
	public function validateOrderBalance($CanteenOrder) {
		
		$result = array(
			"transaction_test"=>false,
			"line_item_test"=>false,
			"tax_test"=>true
		);
		
		$transTotals = array("in"=>0,"out"=>0);
		
		foreach($CanteenOrder['GatewayTransaction'] as $t) {
			
			if($t['approved']) {
				
				switch(strtoupper($t['method'])) {
					
					case "CHARGE":
					case "CAPTURE":
						$transTotals['in'] += $this->Currency->convertCurrency($t['GatewayAccount']['currency_id'],$CanteenOrder['CanteenOrder']['currency_id'],$t['amount']);
	
						break;
					default:
						$transTotals['out'] += $this->Currency->convertCurrency($t['GatewayAccount']['currency_id'],$CanteenOrder['CanteenOrder']['currency_id'],$t['amount']);
						break;
					
				}
			}
			
		}
		
		$lineTotals = array("sub_total"=>0,"tax_total"=>0);
		
		foreach($CanteenOrder['CanteenOrderItem'] as $l) {
			
			$lineTotals['sub_total'] += $l['sub_total'];
			
			
		}
		//if($CanteenOrder['CanteenOrder']['currency_id']=="EUR") die($transTotals['in']-$transTotals['out']);
		//check total money coming in VS the orders grand total
		if(($transTotals['in']-$transTotals['out'])==$CanteenOrder['CanteenOrder']['grand_total']) {
			
			$result['transaction_test'] = true;
			
		} else {
			
			$result['transaction_msg'] = "Transaction Total Difference: ".(($transTotals['in']-$transTotals['out'])-$CanteenOrder['CanteenOrder']['grand_total']);
			
		}
		
		//check the line items totals VS the orders grand totals
		if(($lineTotals['sub_total']+$CanteenOrder['CanteenOrder']['discount_total'])==($CanteenOrder['CanteenOrder']['sub_total'])) {
			
			$result['line_item_test'] = true;
			
		}
		
		//check the line items tax totals vs the orders tax total
		if($lineTotals['tax_total']==$CanteenOrder['CanteenOrder']['tax_total']) {
			
			$result['tax_test'] = true;
			
		}
		
		return array_merge($result,array("Transactions"=>$transTotals,"LineItems"=>$lineTotals));
		
	}
	
	public function updateOrderStatus($canteen_order_id=false,$status="") {
		
		$this->create();
		
		$this->id = $canteen_order_id;
		
		$this->save(array(
			"order_status"=>$status
		));
		
	}
	
	public static function orderStatusDrop() {
		
		$a=array(
			"declined",
			"approved",
			"authorized",
			"fraud",
			"canceled"
		);
		
		$r = array();
		
		foreach($a as $v) $r[$v] = strtoupper($v);
		
		return $r;
		
	}
	
	public function locate_orders($email,$postal_code) {
		
		$UserAddress = ClassRegistry::init("UserAddress");
		
		$addresses = $UserAddress->find("all",array(
			"fields"=>array("UserAddress.foreign_key"),
			"conditions"=>array(
				"UserAddress.email"=>$email,
				"UserAddress.postal_code"=>$postal_code,
				"UserAddress.model"=>"CanteenOrder"
			),
			"contain"=>array()
		));
		
		if(count($addresses)<=0) {
			
			return array();
			
		}
		
		$order_ids = Set::extract("/UserAddress/foreign_key",$addresses);
		
		$orders = $this->find("all",array(
			"fields"=>array(
				"CanteenOrder.id",
				"CanteenOrder.created",
				"CanteenOrder.order_status",
				"CanteenOrder.hash"
			),
			"conditions"=>array(
				"CanteenOrder.id"=>$order_ids
			),
			"contain"=>array(),
			"limit"=>5,
			"order"=>array("CanteenOrder.created"=>"DESC")
		));
		
		return $orders;
		
	}
	
	
	
	
}
