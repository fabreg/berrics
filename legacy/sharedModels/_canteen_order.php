<?php

App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));

class CanteenOrder extends AppModel {
	
	
	public $hasMany = array(
	
		"CanteenOrderItem",
		"GatewayTransaction"=>array(
			"className"=>"GatewayTransaction",
			"foreignKey"=>"foreign_key",
			"conditions"=>array("GatewayTransaction.model"=>"CanteenOrder")
		),
		"EmailMessage",
		"CanteenOrderNote"=>array(
			"order"=>array("CanteenOrderNote.id"=>"DESC")
		)	
	
	);
	public $belongsTo = array(
		"Currency",
		"User"
	);
	
	public $hasOne = array("CanteenPromoCode");
	
	
	public function returnOrder($cond) {
		
		if(!is_array($cond)) {
			
			$cond = array(
				"CanteenOrder.id"=>$cond
			);
			
		}
		
		$order = $this->find("first",array(
		
			"conditions"=>$cond,
			"contain"=>array(
				"CanteenOrderItem"=>array(
					"CanteenProduct"=>array("CanteenProductPrice","CanteenProductImage"),
					"CanteenProductOption"
				),
				"Currency",
				"User"
			)	
		
		));
		
		return $order;
		
		
	}
	
	

	
	public function returnAdminOrder($id = false) {
		
		/*
		 * DEFAULT SETTINGS
		 * 
		 */
		
		$_contain = array(
				"Currency",
				"CanteenOrderItem"=>array(
					"CanteenProduct"=>array(
						"CanteenProductPrice",
						"CanteenProductImage"
					),
					"CanteenProductOption"
				),
				"GatewayTransaction"=>array(
					"GatewayAccount"
				),
				"User",
				"EmailMessage",
				"CanteenOrderNote"=>array(
					"User"
				)
		);
		
		$args = func_get_args();
		
		//let's see if we have an array of override options
		if(isset($args[1]) && is_array($args[1])) {
			
			if(isset($args[1]['contain'])) $_contain = $args[1]['contain'];
			
		}
		
		
		
		
		
		$order = $this->find("first",array(
			"conditions"=>array(
				"CanteenOrder.id"=>$id	
			),
			"contain"=>$_contain
		));
		
		return $order;
	}
	
	public function setOrderValidation() {
		
		$this->validate = array(
		
		
			"first_name"=>array(
				"rule"=>array("notEmpty"),
				"message"=>"You Fucked Up"
			),
			"last_name"=>array(
				"rule"=>array("notEmpty"),
				"message"=>"You Fucked Up"
			),
			"street_address"=>array(
				"rule"=>array("notEmpty"),
				"message"=>"You Fucked Up"
			),
			"apt_num"=>array(
				"rule"=>array("notEmpty"),
				"message"=>"You Fucked Up"
			),
			"city"=>array(
				"rule"=>array("notEmpty"),
				"message"=>"You Fucked Up"
			),
			"email"=>array(
				"rule"=>array("email"),
				"message"=>"You Fucked up"
			)
		
		
		);
		
	}
	
	
	
	
	public function getOrderLineItems($CanteenOrder) {
		
		$order_items = $CanteenOrder['CanteenOrderItem'];
		
		if(count($order_items)<=0) {
			
			return false;
			
		}
		
			
		$tax_rate = 0;
		
		$tax_regions = CanteenConfig::get("tax_regions");
		
		if(array_key_exists($CanteenOrder['CanteenOrder']['country']."-".$CanteenOrder['CanteenOrder']['state'],$tax_regions)) {
			
			$tax_rate = $tax_regions[$CanteenOrder['CanteenOrder']['country']."-".$CanteenOrder['CanteenOrder']['bill_country']];
			
		}
		
		if(array_key_exists($CanteenOrder['CanteenOrder']['bill_country']."-".$CanteenOrder['CanteenOrder']['bill_state'],$tax_regions)) {
			
			$tax_rate = $tax_regions[$CanteenOrder['CanteenOrder']['bill_country']."-".$CanteenOrder['CanteenOrder']['bill_bill_country']];
			
		}
		
		$items = array();
		
		foreach($order_items as $k=>$item) {
			
			$_contain = array(
							"CanteenProductOption"=>array(
								"conditions"=>array(
									"CanteenProductOption.active"=>1,
									"CanteenProductOption.deleted"=>0,
									"CanteenProductOption.id"=>$item['canteen_product_option_id']
								)
							),
							"CanteenProductPrice"=>Array(
								"conditions"=>array(
									"CanteenProductPrice.currency_id"=>$CanteenOrder['CanteenOrder']['currency_id']
								)
							)
							
						);
						
			
			$p = $this->CanteenOrderItem->CanteenProduct->returnProduct(
					array(
						"conditions"=>array(
							"CanteenProduct.id"=>$item['canteen_product_id']
						),
						"contain"=>$_contain
				),
				false,
				false,
				array("no_related"=>true)
			);
			
			
			$order_items[$k] = array_merge($order_items[$k],$p);
			
			$order_items[$k]['price'] = $p['CanteenProductPrice'][0]['price']*$item['quantity'];
			$order_items[$k]['sales_tax'] = ($order_items[$k]['price']*$tax_rate);
			$order_items[$k]['shipping_weight'] = $order_items[$k]['CanteenProduct']['shipping_weight'];
				
		}
		
		return $order_items;
		
	}
	
	
	public function calculateCartTotal($order = array()) {
		
		App::import("Vendor","UpsApi",array("file"=>"UpsApi.php"));
		
		//get the cart items
		
		$order['CanteenOrderItem'] = $this->getOrderLineItems($order);
		
		//let's get the sub total
		
		$sub_total = 0;
		$shipping_weight = 0;
		
		foreach($order['CanteenOrderItem'] as $item) {
			
			$sub_total += $item['CanteenProductPrice'][0]['price'];
			$shipping_weight += $item['shipping_weight'];
			
		}
		
		$order['CanteenOrder']['sub_total'] = $sub_total;
		
		$shipping = "N/A";
				
		//calc shipping
		$shipping_info = $this->extractShippingInfo($order);
		
		if((!empty($shipping_info['Shipping']['postal']) || !empty($shipping_info['Shipping']['city'])) && !empty($shipping_info['Shipping']['country'])) {
			
			$ups = new UpsApi();
			
			$shipping_price = $ups->estimateShipping($shipping_info);
			
			die(print_r($shipping_price));
			
		}
		
		$order['CanteenOrder']['shipping'] = $order['CanteenOrder']['shipping_total'] = $shipping;
		
		$total = $sub_total + $shipping;
		
		$order['CanteenOrder']['shipping_weight'] = $shipping_weight;
		
		$order['CanteenOrder']['total'] = $order['CanteenOrder']['grand_total'] = $total;
		
		return $order;
		
	}
	
	public function updateOrderStatus($status = false) {
		
		
		
	}
	
	/**
	 * Will Check An Order And Score It's Fraud Likelyhood
	 * 0 = Pass
	 * 1 = Iffy, AUTH Order
	 * 2 = Possible FRAUD, DECLINE
	 * @param $CanteenOrder
	 * @return int
	 */
	private function screenOnlineOrder($CanteenOrder) {
		
		$ship_check = false;
		$geo_check = false;
		
		if(strtoupper($CanteenOrder['CanteenOrder']['bill_country']) != strtoupper($CanteenOrder['CanteenOrder']['geoip_country_code'])) {
			
			$this->CanteenOrderNote->create();
			$this->CanteenOrderNote->save(array(
				"action"=>"CanteenOrder::ScreenOnlineOrder",
				"note"=>"GEOIP COUNTRY MIS-MATCH: BillCountry:".strtoupper($CanteenOrder['CanteenOrder']['bill_country'])." GEOIPCountry:".strtoupper($CanteenOrder['CanteenOrder']['geoip_country_code']),
				"canteen_order_id"=>$CanteenOrder['CanteenOrder']['id']
			));
			
			return 1;
			
		}
		
		return 0;
		
	}
	
	public function chargeOrder($CanteenOrder,$method = "charge",$screen_order = true) {
		
		$gid = CanteenConfig::get("gateway_account_id");
		
		$verb = "declined"; //default
		
		$screen_result = true; //default
		
		//let's determine which method we want to use.... basically out fraud checking will go down right here
		if($screen_order) {
			
			$screen = $this->screenOnlineOrder($CanteenOrder);
			
			switch($screen) {

				case 1:
					$method = "auth";
				case 0:
				break;
				case 2:
					$screen_result = false;
					$verb = "fraud";
				break;
				
			}
			
			
		}
		
		if($screen_result) {
			
			if(($gw = $this->GatewayTransaction->GatewayAccount->run($method,$gid,$this->formatTransaction($CanteenOrder)))) {
				
				switch($method) {
					
					case "charge":
						$verb = "approved";
						unset($CanteenOrder['CardData']);
						$this->debitInventory($CanteenOrder);
						
					break;
					case "auth":
						$verb = "authorized";
						unset($CanteenOrder['CardData']);
						$this->debitInventory($CanteenOrder);
						
					break;
					default:
						$verb = "pending";
					break;
					
				}
				
			}
			
		} else {
			
			$gw = false;
			
		}

		$this->create();
		
		$this->id = $CanteenOrder['CanteenOrder']['id'];

		$this->save(array(
				"order_status"=>$verb
		));
		
		if($gw) {
			
			$CanteenOrder['CanteenOrder']['order_status'] = $verb;
			$this->EmailMessage->queueCanteenEmail("canteen_order_conf",$CanteenOrder);
			
		}
		
		return $gw;
		
	}
	
	public function creditOrder_($CanteenOrder,$method = "credit",$credit_inv = true) {
		
		$gid = CanteenConfig::get("gateway_account_id");
		
		foreach($CanteenOrder['GatewayTransaction'] as $t) {
			
			if($t['method'] == "charge") {
				
				$gw = $this->GatewayTransaction->GatewayAccount->refund($gid,$t['id']);
				
			}
			
		}
		
		if($credit_inv) {
			
			$this->creditInventory($CanteenOrder);
			
		}
		
	}
	/**
	 * Extract all required information from a CanteenOrder to send to the GatewayAccount Processor
	 * @param CanteenOrder $CanteenOrder
	 * @return Array:
	 */
	private function formatTransaction($CanteenOrder) {
		
		$t = array();
		
		#TRANSACTION
		$t['Transaction']['currency_id'] = 	Set::classicExtract($CanteenOrder,"CanteenOrder.currency_id");
		$t['Transaction']['amount'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.total");
		$t['Transaction']['foreign_key'] = 	Set::classicExtract($CanteenOrder,"CanteenOrder.id");
		$t['Transaction']['model'] = 		"CanteenOrder";
		
		#CUSTOMER
		$t['Customer']['first_name'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_first_name");
		$t['Customer']['last_name'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_last_name");
		$t['Customer']['address'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_address");
		$t['Customer']['postal'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.bill_postal");
		$t['Customer']['country'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_country");
		$t['Customer']['email'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.email");
		$t['Customer']['city'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.bill_city");
		$t['Customer']['state'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.bill_state");
		$t['Customer']['phone'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.phone");
		$t['Customer']['user_id'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.user_id");
		
		#CARD DATA
		$t['CardData']['number'] = 			Set::classicExtract($CanteenOrder,"CardData.number");
		$t['CardData']['exp_year'] =		Set::classicExtract($CanteenOrder,"CardData.exp_year");
		$t['CardData']['exp_month'] = 		Set::classicExtract($CanteenOrder,"CardData.exp_month");
		$t['CardData']['code'] = 			Set::classicExtract($CanteenOrder,"CardData.code");

		return $t;
		
	}
	
	/**
	 * Debit Invetory From The Line Items Of A CanteenOrder
	 * @param CanteenOrder $CanteenOrder
	 * @return void
	 */
	public function debitInventory($CanteenOrder) {
		
		$items = $CanteenOrder['CanteenOrderItem'];
		
		foreach($items as $i) {
			
			$pick_id = (!empty($i['canteen_product_option_id'])) ? $i['canteen_product_option_id']:$i['canteen_product_id'];
			
			if($i['process_inventory'] == 1) continue;
			
			$prod = $this->CanteenOrderItem->CanteenProduct->find("first",array(
				"conditions"=>array(
					"CanteenProduct.id"=>$pick_id
				),
				"contain"=>array()
			));
			
			$update_qty = $prod['CanteenProduct']['quantity'] - $i['quantity'];
			
			$this->CanteenOrderItem->CanteenProduct->create();
			$this->CanteenOrderItem->CanteenProduct->id = $prod['CanteenProduct']['id'];
			
			$this->CanteenOrderItem->CanteenProduct->save(array(
				"quantity"=>$update_qty
			));
			
			$this->CanteenOrderItem->create();
			$this->CanteenOrderItem->id = $i['id'];
			$this->CanteenOrderItem->save(array(
				"process_inventory"=>1
			));
		}
		
	}
	
	public function creditInventory($CanteenOrder) {
		
		
	}
	

	/**
	 * Credits a canteen order
	 * @param CanteenOrder $CanteenOrder
	 * @return Decimal
	 */
	public function creditOrder($CanteenOrder) {
		
		//let's get a fresh order form the db
		$order = $this->returnAdminOrder($CanteenOrder['CanteenOrder']['id']);
		
		//let's get the values
		$tax_c = $CanteenOrder['CanteenOrder']['tax_total_credit'];
		$ship_c = $CanteenOrder['CanteenOrder']['shipping_total_credit'];
		$sub_c = $CanteenOrder['CanteenOrder']['sub_total_credit'];

		$total_c = $tax_c + $ship_c + $sub_c;
		
		//find the transactions that we want to use to credit
		$trans = false;
		
		$trans = Set::extract("/GatewayTransaction[method=/capture|charge/i][approved=1]",$order);
		
		$trans = $trans[0];
		$refund = false;
		
		
		
		if($trans) {
			
			$refund = $this->GatewayTransaction->refundTransaction($trans['GatewayTransaction'],$total_c);
			
		
			
			if($refund) { //let's update the order with the new total
				
				$new_tax = $order['CanteenOrder']['tax_total'] - $tax_c;
				$new_ship = $order['CanteenOrder']['shipping_total'] - $ship_c;
				$new_sub = $order['CanteenOrder']['sub_total'] - $sub_c;
				$new_total = $new_tax + $new_ship + $new_sub;
				
				
				$this->create();
				$this->id = $order['CanteenOrder']['id'];
				
				$this->save(array(
				
					"sub_total"=>$new_sub,
					"tax_total"=>$new_tax,
					"shipping_total"=>$new_ship,
					"total"=>$new_total	
				
				));
				
				
			}
			
			return $total_c;
			
		}
		
		return false;
		
	}
	/**
	 * Debit and order using the orders customer billing profile
	 * @param CanteenOrder $CanteenOrder
	 * @return Decimal
	 */
	public function debitOrder($CanteenOrder) {
		
		$profile = $this->User->UserBillingProfile->find("first",array(
			"conditions"=>Array("UserBillingProfile.id"=>$CanteenOrder['CanteenOrder']['user_billing_profile_ref_id']),
			"contain"=>array()
		));
		
		$order = $this->returnAdminOrder($CanteenOrder['CanteenOrder']['id']);
		
		if(!$profile) {
			
			return false;
			
		}
		
		$tax_d = $CanteenOrder['CanteenOrder']['tax_total_debit'];
		$ship_d = $CanteenOrder['CanteenOrder']['shipping_total_debit'];
		$sub_d = $CanteenOrder['CanteenOrder']['sub_total_debit'];
		
		$total_d = $tax_d + $ship_d + $sub_d;
		
		//let's build the request to send to the gateway
		
		$data = array(
			"Transaction"=>array(
				"model"=>"CanteenOrder",
				"foreign_key"=>$CanteenOrder['CanteenOrder']['id'],
				"amount"=>$total_d,
				"currency_id"=>$order['CanteenOrder']['currency_id']
			),
			"UserBillingProfile"=>$profile['UserBillingProfile']
			
		);
		
		$res = $this->GatewayTransaction->GatewayAccount->chargeUserBillingProfile($data);
		
		if($res) {
			
			$tax_new = $order['CanteenOrder']['tax_total'] + $tax_d;
			$ship_new = $order['CanteenOrder']['shipping_total']  + $ship_d;
			$sub_new = $order['CanteenOrder']['sub_total'] + $sub_d;
			
			$total_new = $sub_new + $tax_new + $ship_new;
			
			$this->create();
			$this->id = $order['CanteenOrder']['id'];
			$this->save(array(
			
				"sub_total"=>$sub_new,
				"shipping_total"=>$ship_new,
				"tax_total"=>$tax_new,
				"total"=>$total_new
			
			));
			
			return $total_d;
			
		}
		
		return false;
	}
	
	/**
	 * Complete Cancel A CanteenOrder including all the charges and return all the inventory
	 * @param CanteenOrder.id $id
	 * @return void
	 */
	public function cancelOrder($id = false) {
		
	
		$order = $this->returnAdminOrder($id);
		
		//return all the items to inventory
		foreach($order['CanteenOrderItem'] as $i) {
			
			$qty = $i['quantity'];
			
			$this->CanteenOrderItem->returnToStock($i['id'],$qty);
			
		}
		
		//let's credit all the transactions
		foreach($order['GatewayTransaction'] as $t) {
			
			if(in_array(strtolower($t['method']),array("charge","capture","auth")) && $t['approved'] = 1) {

				//attempt to void the transactions. if the fails, then try a credit for 100%
				$void = $this->GatewayTransaction->voidTransaction($t);
				
				if(!$void) {

					$this->GatewayTransaction->refundTransaction($t);
										
				}
				
			}
				
		}
		
		//now let's update the order details
		$data = array();
		$data['order_status'] = $data['shipping_status'] = $data['wh_status'] = "canceled";
		$data['shipping_total'] = $data['tax_total'] = $data['total'] = $data['sub_total'] = 0.00;
		$this->create();
		$this->id = $order['CanteenOrder']['id'];
		$this->save($data);
		
	}
	
	
	private function extractShippingInfo($CanteenOrder) {
		
		$a = array();
		
		$a['Shipping'] = array();
		
		if(isset($CanteenOrder['CanteenOrder']['postal'])) 			$a['Shipping']['postal'] = $CanteenOrder['CanteenOrder']['postal'];
		if(isset($CanteenOrder['CanteenOrder']['country'])) 		$a['Shipping']['country'] = $CanteenOrder['CanteenOrder']['country'];
		if(isset($CanteenOrder['CanteenOrder']['street_address']))  $a['Shipping']['street_address'] = $CanteenOrder['CanteenOrder']['street_address'];
		if(isset($CanteenOrder['CanteenOrder']['apt'])) 			$a['Shipping']['apt'] = $CanteenOrder['CanteenOrder']['apt'];
		if(isset($CanteenOrder['CanteenOrder']['city'])) 			$a['Shipping']['city'] = $CanteenOrder['CanteenOrder']['city'];
		if(isset($CanteenOrder['CanteenOrder']['province'])) 		$a['Shipping']['province'] = $CanteenOrder['CanteenOrder']['province'];
		if(isset($CanteenOrder['CanteenOrder']['phone'])) 			$a['Shipping']['phone'] = $CanteenOrder['CanteenOrder']['phone'];
		if(isset($CanteenOrder['CanteenOrder']['first_name']))      $a['Shipping']['first_name'] = $CanteenOrder['CanteenOrder']['first_name'];
		if(isset($CanteenOrder['CanteenOrder']['last_name']))       $a['Shipping']['last_name'] = $CanteenOrder['CanteenOrder']['last_name'];
		
		$a['Currency'] = $CanteenOrder['CanteenOrder']['currency_id'];
		
		
		
		return $a;
		
		
		
	}
	
	/**
	 * 
	 * @param String $column Column that we wish to group and aggregate
	 * @param Date $date_start Date Start (MySQL Date Format)
	 * @param Date $date_end Date End (MySql Date Format)
	 * @return Array
	 */
	public function groupedStatusCount($column,$date_start,$date_end) {
		
		$status = $this->find("all",array(
			"fields"=>array(
				"COUNT(*) AS `total`",
				"CanteenOrder.{$column}"
			),
			"conditions"=>array(
				"DATE(CanteenOrder.created) BETWEEN '{$date_start}' AND '{$date_end}'"
			),
			"contain"=>array(),
			"group"=>array(),
			"order"=>array("total"=>"DESC")
		));
		
		return $status;
		
	} 
	
	

	
	
	
}