<?php

App::import("Controller","CanteenApp");

class CanteenController extends CanteenAppController {
	
	public $uses = array();
	
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function index() {
		
		$this->loadModel("CanteenProduct");
		
		$products = $this->CanteenProduct->find("all",array(
		
			"contain"=>array(
				"CanteenProductImage",
				"CanteenProductPrice"=>array(
					"Currency"
				)
			),
			"conditions"=>array(
				
					"CanteenProduct.parent_canteen_product_id"=>NULL
				
			)
		
		));
		
		$this->set(compact("products"));
		
	}

	public function category() {
		
		$this->loadModel("CanteenCategory");
		
		$uri = $this->params['uri'];
		
		$category = $this->CanteenCategory->find("first",array(
		
			"conditions"=>array("CanteenCategory.uri"=>$uri,"CanteenCategory.active"=>1)
		
		));
		
		$this->set(compact("category"));
		
		
	}
	
	public function order($id = false) {
		
		if($id) {
			
			$this->loadModel("CanteenOrder");
			
			$order = $this->CanteenOrder->returnAdminOrder($id);
			
			if(isset($order['CanteenOrder']['id'])) {
				
				$this->set(compact("order"));
				
			}
			
		}
		
	}
	
	
	public function clear_session() {
		
		$this->Session->delete("CanteenOrder");
		$this->Session->delete("CanteenAdminAddItem");
		
		return $this->redirect("/canteen");
		
	}
	
	
	

}