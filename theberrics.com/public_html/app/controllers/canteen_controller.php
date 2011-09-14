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
		$this->loadModel("CanteenProduct");
		
		$uri = $this->params['uri'];
		
		$cat_token = "canteen_cat_".md5($uri);
		
		if(($category = Cache::read($cat_token,"1min")) === false) {

			$category = $this->CanteenCategory->find("first",array(
			
				"conditions"=>array("CanteenCategory.uri"=>$uri,"CanteenCategory.active"=>1),
				"contain"=>array()
			
			));

			Cache::write($cat_token,$category,"1min");
			
		}

		$this->set(compact("category"));
		
		$prod_ids = $this->CanteenProduct->find("all",array(
			"fields"=>array("CanteenProduct.id"),
			"conditions"=>array(
				"CanteenProduct.canteen_category_id"=>$category['CanteenCategory']['id']
			),
			"contain"=>array()
		));
		
		$prod_ids = Set::extract("/CanteenProduct/id",$prod_ids);
		
		//die(print_r($prod_ids));
		
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