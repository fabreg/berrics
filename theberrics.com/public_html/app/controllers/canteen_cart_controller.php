<?php 
App::import("Controller","CanteenApp");
class CanteenCartController extends CanteenAppController {
	
	
	public $uses = array("CanteenOrder","UserAddress");
	
	public function beforeFilter() {
		
		if(in_array($this->params['action'],array("index","debugger"))) {
			
			$this->enforce_ssl = true;
			
		}
		
		parent::beforeFilter();

		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function debugger() {
		
		die(print_r($_SERVER));
		
	}
	
	public function index() {
			
		if(count($this->data)>0) {
			
			if($this->Session->check("Auth.User.id")) {
				
				$this->data['CanteenOrder']['user_id'] = $this->Session->read("Auth.User.id");
				
			}
			
			
			$order_id = $this->Session->read("CanteenOrder.CanteenOrder.id");
			
			$this->CanteenOrder->ShippingAddress->setOrderAddressValidation();
			$this->CanteenOrder->ShippingAddress->set($this->data['ShippingAddress']);
			$this->loadModel("CardData");
			$this->CardData->setCardValidation();
			$this->CardData->set($this->data['CardData']);
			
			if($this->CanteenOrder->ShippingAddress->validates() && $this->CardData->validates()) {
				
				//merge the form data with existing session data
				foreach($this->data as $k=>$v) {
					
					if($this->Session->check("CanteenOrder.{$k}")) {
						
						$this->data[$k] = array_merge($this->Session->read("CanteenOrder.{$k}"),$this->data[$k]);
						
					}
					
				}
				
				$this->data['CanteenOrderItem'] = $this->Session->read("CanteenOrder.CanteenOrderItem");
				
				//save the order and proceeed
				
				if(($order_id = $this->CanteenOrder->saveOnlineOrder($this->data,true))) {
					
					$this->Session->write("CanteenOrder",$this->CanteenOrder->returnAdminOrder($order_id));
					
					return $this->process($this->data);
					
				}
				
			} else {
				
				$this->Session->setFlash("Please correct all fields marked in red");
				
			}
			
			
		} 
		
		if($this->Session->check("Auth.User.id")) {
				
			$this->Session->write("CanteenOrder.CanteenOrder.user_account_canteen_promo_code_id",1);
			
		} else {
			
			$this->Session->write("CanteenOrder.CanteenOrder.user_account_canteen_promo_code_id",null);
			
		}
		
		$order = $this->Session->read("CanteenOrder");
		
		if(count($this->data)>0) {
			
			$order['ShippingAddress'] = $this->data['ShippingAddress'];
			
			$order['BillingAddress'] = $this->data['BillingAddress'];
			
		}
		
		$order['CanteenOrder']['currency_id'] = $this->getUserCurrency();
		$geo_c = env("GEOIP_COUNTRY_CODE");
		$order['ShippingAddress']['country_code'] = (strlen($geo_c)<=0) ? "US":$geo_c;
		
		
		$this->data = $this->CanteenOrder->calculateCartTotal($order);
		$this->data['CanteenOrder']['same_as_shipping_checkbox']=1;
		
			
		if(isset($_GET['x']) && $this->isAdmin()) {
			
			$this->data['ShippingAddress']['first_name'] = "John";
			$this->data['ShippingAddress']['last_name'] = "Testing";
			$this->data['ShippingAddress']['street'] = "11201 Otsego St";
			$this->data['ShippingAddress']['apt'] = "#107";
			$this->data['ShippingAddress']['city'] = "North Hollywood";
			$this->data['ShippingAddress']['state'] = "CA";
			$this->data['ShippingAddress']['country_code'] = "US";
			$this->data['ShippingAddress']['email'] = "john.hardy@me.com";
			$this->data['ShippingAddress']['phone'] = "888-888-8888";
			$this->data['ShippingAddress']['postal_code'] = "91601";
			
			$this->data['CardData']['number'] = "4111111111111111";
			$this->data['CardData']['exp_month'] = 2;
			$this->data['CardData']['exp_year'] = 13;
			$this->data['CardData']['code'] = 123;
			
		}
		
		
		
	}
	
	public function _index() {
		
		//let's get all the cart items
		
		$this->loadModel("CanteenOrder");
		
		if(count($this->data)>0) {
			
		
			$this->CanteenOrder->setOrderValidation();

			$this->data = $this->CanteenOrder->calculateCartTotal($this->data);
				
			$this->CanteenOrder->set($this->data);
			
			$errors = $this->CanteenOrder->invalidFields(); 
			
			if(count($errors)>0) {
				
				$this->set("errors",$errors);
				
			} else {
				
				if(!$this->Session->check("CanteenOrder.CanteenOrder.id")) {
					
					//did we check "same as shipping"?
					if($this->data['CanteenOrder']['same_as_shipping_checkbox']==1) {
						
						$this->data['CanteenOrder']['bill_first_name'] = $this->data['CanteenOrder']['first_name'];
						$this->data['CanteenOrder']['bill_last_name'] = $this->data['CanteenOrder']['last_name'];
						$this->data['CanteenOrder']['bill_address'] = $this->data['CanteenOrder']['street_address']." ".$this->data['CanteenOrder']['apt'];
						$this->data['CanteenOrder']['bill_city']= $this->data['CanteenOrder']['city'];
						$this->data['CanteenOrder']['bill_state']= $this->data['CanteenOrder']['state'];
						$this->data['CanteenOrder']['bill_postal']= $this->data['CanteenOrder']['postal'];
						$this->data['CanteenOrder']['bill_country']= $this->data['CanteenOrder']['country'];
						
					}
					
					//insert initial status as pending
					$this->data['CanteenOrder']['order_status'] = 
					$this->data['CanteenOrder']['shipping_status'] = 
					$this->data['CanteenOrder']['wh_status'] = 
					"pending";
					
					//set the IP address of the client
					$this->data['CanteenOrder']['ip_address'] = (empty($_SERVER["GEOIP_ADDR"])) ? $_SERVER["REMOTE_ADDR"]:$_SERVER["GEOIP_ADDR"];
					
					if(empty($this->data['CanteenOrder']['geoip_country_code'])) $this->data['CanteenOrder']['geoip_country_code'] = 'US';
					
					$this->CanteenOrder->saveAll($this->data);
				
					$order = $this->CanteenOrder->returnAdminOrder($this->CanteenOrder->id);

					$this->updateOrderSession($order);
					
					return $this->process(array("CardData"=>$this->data['CardData']));
					
				}
				
				return $this->redirect("/canteen/cart/process");
				
			}
			
		} else {
			
			$order = $this->Session->read("CanteenOrder");
			
			$order['CanteenOrder']['currency_id'] = $this->getUserCurrency();

			if(count($this->data)>0) $order['ShippingAddress'] = $this->data['ShippingAddress'];
			
			
			$this->data['CanteenOrder']['same_as_shipping_checkbox']=1;
			$geo_c = env("GEOIP_COUNTRY_CODE");
			$this->data['UserAddress'][0]['country_code'] = (strlen($geo_c)<=0) ? "US":$geo_c;
			
		}
		
		$this->data = $this->CanteenOrder->calculateCartTotal($t);
		
		$user_locale = (isset($_GET['locale'])) ? $_GET['locale']:"en_us";

		$this->set(compact("items","user_locale"));

		if(isset($_GET['x']) && $this->isAdmin()) {
			
			$this->data['CanteenOrder']['first_name'] = "John";
			$this->data['CanteenOrder']['last_name'] = "Testing";
			$this->data['CanteenOrder']['street_address'] = "123 Ghetto Ave";
			$this->data['CanteenOrder']['apt'] = "#327";
			$this->data['CanteenOrder']['city'] = "Compton";
			$this->data['CanteenOrder']['state'] = "CA";
			$this->data['CanteenOrder']['country_code'] = "US";
			$this->data['CanteenOrder']['email'] = "john.hardy@me.com";
			$this->data['CanteenOrder']['phone'] = "888-888-8888";
			$this->data['CanteenOrder']['postal_code'] = "90210";
			
			$this->data['CardData']['number'] = "4111111111111111";
			$this->data['CardData']['exp_month'] = 2;
			$this->data['CardData']['exp_year'] = 13;
			$this->data['CardData']['code'] = 123;
			
		}
		
		
	}

	public function add() {
		
		if(count($this->data)>0) {
			
			$cart = $this->Session->read("CanteenOrder");
			
			if(!isset($cart['CateenOrder'])) {
				
				$cart['CanteenOrder'] = array();
				
			}
	
			//create a top level line item
			$line_item = array();
			
			foreach($this->data['CanteenOrderItem'] as $k=>$v) {
				
				$line_item['ChildCanteenOrderItem'][] = array(
					"canteen_product_id"=>$v['canteen_product_id'],
					"quantity"=>$v['quantity'],
					"parent_canteen_product_id"=>$v['parent_canteen_product_id']
				);
				
	
			}
			
			$line_item['hash'] = sha1(time().mt_rand(999,9999));
	
			$cart['CanteenOrderItem'][] = $line_item;
	
			$this->Session->write("CanteenOrder",$cart);
			
		}
		
		
		return $this->redirect("/canteen/cart");
		
	}
	
	public function clear_cart() {
		
		$this->Session->delete("CanteenOrder");
		
		return $this->redirect("/canteen/");
		
	}
	
	private function _updateOrderSession($order = array()) {
		
		$this->Session->write("CanteenOrder",$order);
		
	}
	
	public function dump_session() {
		
		die(print_r($this->Session->read()));
		
	}
	
	public function process($payload = array()) {
		
		
		//get the order from the session
		$order = $this->Session->read("CanteenOrder");
		
		if(strlen($order['CanteenOrder']['id'])<=0) {
			
			return $this->cakeError("error404");
			
		}
		
		switch(strtoupper($order['CanteenOrder']['order_status'])) {
			
			case "PENDING":
				$this->CanteenOrder->chargeOnlineOrder(array_merge(array("CardData"=>$payload['CardData']),$order),"charge");
				$this->updateOrderSession();
				return $this->process();
			break;
			case "DECLINED":
				$this->Session->setFlash("Order Has Been Declined");
				return $this->redirect("/canteen/cart");
			break;
			case "APPROVED":
			case "AUTHORIZED":
				
				return $this->redirect("/canteen/cart/invoice/".$order['CanteenOrder']['id']);
				
			break;
			
		}
		

	}
	
	public function calc_cart() {
		
		$this->layout = "ajax";
		
		$this->loadModel("CanteenOrder");
		
		$Currency = $this->data['CanteenOrder']['currency_id'];
		
		foreach($this->data as $k=>$v) {
				
			if($this->Session->check("CanteenOrder.{$k}")) {
				
				$this->data[$k] = array_merge($this->Session->read("CanteenOrder.{$k}"),$this->data[$k]);
				
			}
				
		}
		
		$this->data['CanteenOrderItem'] = $this->Session->read("CanteenOrder.CanteenOrderItem");
		
		$CanteenOrder = $this->CanteenOrder->formatOnlineOrderAddresses($this->data);
		
		$CanteenOrder['CanteenOrder']['currency_id'] = $Currency;
		
		$order = $this->CanteenOrder->calculateCartTotal($CanteenOrder);
		
		$this->set(compact("order"));
		
	}
	
	public function remove($id) {
		
		//get the cart
		
		$cart = $this->Session->read("CanteenOrder");
		
		foreach($cart['CanteenOrderItem'] as $k=>$item) {
			
			if($id == $item['hash']) {
				
				unset($cart['CanteenOrderItem'][$k]);
				
				$this->Session->write("CanteenOrder",$cart);
				
				return $this->redirect("/canteen/cart");
				
			}
			
		}
		
		return $this->redirect("/canteen/cart");
		
	}
	
	
	public function invoice($id = false) {
		
		if(!$id) {
			
			return $this->cakeError("error404");
			
		}
		
		//get the order
		
		$order = $this->CanteenOrder->returnAdminOrder($id);
		
		$this->Session->delete("CanteenOrder");
		
		$this->set(compact("order"));
		
		
	}
	
	private function updateOrderSession() {
		
		$oid = $this->Session->read("CanteenOrder.CanteenOrder.id");
		
		$this->Session->write("CanteenOrder",$this->CanteenOrder->returnAdminOrder($oid));
		
	}
	
	public function _print_invoice($id= false) {
		
		if(!$id) {
			
			return $this->cakeError("error404");
			
		}
		
		$order = $this->CanteenOrder->returnOrder($id);
		
		$this->set(compact("order"));
		
		$this->layout = "empty";
		
		$this->render("/elements/canteen_orders/printable_invoice");
		
	}
	
	
}