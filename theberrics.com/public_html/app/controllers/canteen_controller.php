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
		
		$this->loadModel("CanteenCategory");
		
		$cats = $this->CanteenCategory->find("all",array(
			"order"=>array("CanteenCategory.lft"=>"ASC")
		));
		
		$this->set(compact("cats"));
		
	}

	public function category() {
		
		$this->loadModel("CanteenCategory"); 
		$this->loadModel("CanteenProduct");
		
		$uri = $this->params['uri'];
		
		$category = $this->CanteenCategory->grabSubcat(array(
			"CanteenCategory.uri"=>$uri
		));

		$this->set(compact("category"));
		
		$prod_ids = $this->CanteenProduct->find("all",array(
			"fields"=>array("CanteenProduct.id"),
			"conditions"=>array(
				"CanteenProduct.canteen_category_id"=>$category['CanteenCategory']['id'],
				"CanteenProduct.parent_canteen_product_id"=>NULL,
				"CanteenProduct.active"=>1,
				"CanteenProduct.featured"=>1
			),
			"contain"=>array()
		));
		
		$prod_ids = Set::extract("/CanteenProduct/id",$prod_ids);
		
		$products = array();
		
		//die(print_r($prod_ids));
		
		foreach($prod_ids as $id) {
			
			$products[] = $this->CanteenProduct->returnProduct(array("conditions"=>array("CanteenProduct.id"=>$id)),$this->isAdmin(),false,array("no_related"=>true));
			
		}
		
		$this->set(compact("products"));
		
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