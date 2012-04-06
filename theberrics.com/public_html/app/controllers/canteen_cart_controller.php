<?php 
App::import("Controller","CanteenApp");
class CanteenCartController extends CanteenAppController {
	
	
	public $uses = array("CanteenOrder");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function index() {
			
		if(count($this->data)>0) {
			
			$this->data = array_merge($this->Session->read("CanteenOrder"),$this->data);
			
			//die(print_r($this->data));
			
			$this->CanteenOrder->saveOnlineOrder($this->data,true);
			
		} else {
			
			
		}
		
		$order = $this->Session->read("CanteenOrder");
		
		$order['CanteenOrder']['currency_id'] = $this->getUserCurrency();

		$this->data = $this->CanteenOrder->calculateCartTotal($order);
		$this->data['CanteenOrder']['same_as_shipping_checkbox']=1;
		$geo_c = env("GEOIP_COUNTRY_CODE");
		$this->data['UserAddress']['Shipping']['country'] = (strlen($geo_c)<=0) ? "US":$geo_c;
			
		if(isset($_GET['x']) && $this->isAdmin()) {
			
			$this->data['UserAddress']['Shipping']['first_name'] = "John";
			$this->data['UserAddress']['Shipping']['last_name'] = "Testing";
			$this->data['UserAddress']['Shipping']['street_address'] = "123 Ghetto Ave";
			$this->data['UserAddress']['Shipping']['apt'] = "#327";
			$this->data['UserAddress']['Shipping']['city'] = "Compton";
			$this->data['UserAddress']['Shipping']['state'] = "CA";
			$this->data['UserAddress']['Shipping']['country'] = "US";
			$this->data['UserAddress']['Shipping']['email'] = "john.hardy@me.com";
			$this->data['UserAddress']['Shipping']['phone'] = "888-888-8888";
			$this->data['UserAddress']['Shipping']['postal'] = "90210";
			
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

			$this->data = $this->CanteenOrder->calculateCartTotal($order);
			$this->data['CanteenOrder']['same_as_shipping_checkbox']=1;
			$geo_c = env("GEOIP_COUNTRY_CODE");
			$this->data['CanteenOrder']['country'] = (strlen($geo_c)<=0) ? "US":$geo_c;
			
		}
		
		$user_locale = (isset($_GET['locale'])) ? $_GET['locale']:"en_us";

		$this->set(compact("items","user_locale"));

		if(isset($_GET['x']) && $this->isAdmin()) {
			
			$this->data['CanteenOrder']['first_name'] = "John";
			$this->data['CanteenOrder']['last_name'] = "Testing";
			$this->data['CanteenOrder']['street_address'] = "123 Ghetto Ave";
			$this->data['CanteenOrder']['apt'] = "#327";
			$this->data['CanteenOrder']['city'] = "Compton";
			$this->data['CanteenOrder']['state'] = "CA";
			$this->data['CanteenOrder']['country'] = "US";
			$this->data['CanteenOrder']['email'] = "john.hardy@me.com";
			$this->data['CanteenOrder']['phone'] = "888-888-8888";
			$this->data['CanteenOrder']['postal'] = "90210";
			
			$this->data['CardData']['number'] = "4111111111111111";
			$this->data['CardData']['exp_month'] = 2;
			$this->data['CardData']['exp_year'] = 13;
			$this->data['CardData']['code'] = 123;
			
		}
		
		
	}

	public function add() {
		

		//$this->Session->
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
		
		$item['hash'] = md5(time().mt_rand(999,9999));
		
		$cart['CanteenOrderItem'][] = $line_item;

		$this->Session->write("CanteenOrder",$cart);
		
		return $this->redirect("/canteen/cart/");
		
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
	
	public function _process($payload = array()) {
		
		
		//get the order from the session
		$order_id = $this->Session->read("CanteenOrder.CanteenOrder.id");
		
		if(strlen($order_id)<=0) {
			
			return $this->cakeError("error404");
			
		}
		
		$order = $this->CanteenOrder->returnAdminOrder($order_id);
		
		if($order) {
			
			$this->Session->write("CanteenOrder",$order);
			
		}
		
		switch(strtoupper($order['CanteenOrder']['order_status'])) {
			
			case "PENDING":
				$this->CanteenOrder->chargeOrder(array_merge($payload,$order),"charge");
				//return $this->render();
				return $this->process();
			break;
			case "DECLINED":
				die("Order Has Been Declined");
			break;
			case "APPROVED":
			case "AUTHORIZED":
				
				return $this->redirect("/canteen/cart/invoice/".$order['CanteenOrder']['id']);
				
			break;
			
		}
		

	}
	
	public function _calc_cart() {
		
		$this->loadModel("CanteenOrder");
		
		$order = $this->CanteenOrder->calculateCartTotal($this->data);
		
		die(json_encode($order));
		
	}
	
	public function _remove($id) {
		
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
	
	
	public function _invoice($id = false) {
		
		if(!$id) {
			
			return $this->cakeError("error404");
			
		}
		
		//get the order
		
		$order = $this->CanteenOrder->returnAdminOrder($id);
		
		$this->Session->delete("CanteenOrder");
		
		$this->set(compact("order"));
		
		
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