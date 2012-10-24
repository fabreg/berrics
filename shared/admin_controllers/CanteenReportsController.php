<?php
App::import("Controller","LocalApp");

class CanteenReportsController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		
		
	}
	
	public function products() {
		
		
		
	}
	
	public function canteen_order_items() {
		
		$this->loadModel("CanteenProduct");
		$this->loadModel("CanteenOrderItem");
		
		if(count($this->request->data)) {
			
			$cond = array();
			$joins = array();
			
			$joins[] = "INNER JOIN canteen_products AS `CanteenProduct` ON (CanteenOrderItem.canteen_product_id=CanteenProduct.id)";
			$joins[] = "INNER JOIN canteen_products AS `CanteenProductOption` ON (CanteenOrderItem.canteen_product_option_id=CanteenProductOption.id)";
			
			if(isset($this->request->data['CanteenOrderItem']['CanteenCategory']) && !empty($this->request->data['CanteenOrderItem']['CanteenCategory'])) {
				
				$cond['CanteenProduct.canteen_category_id'] = $this->request->data['CanteenOrderItem']['CanteenCategory'];
				
			}
			
			//die(print_r($this->request->data));
			
			$data = $this->CanteenOrderItem->find("all",array(
			
				"fields"=>array(
					"SUM(CanteenOrderItem.quantity) AS `total`",
					"CanteenProduct.*",
					"CanteenProductOption.*"
				),
				"conditions"=>$cond,
				"joins"=>$joins,
				"contain"=>array(),
				"group"=>array(
					"CanteenOrderItem.canteen_product_id",
					"CanteenOrderItem.canteen_product_option_id"
				),
				"order"=>array("total"=>"DESC")
			
			));
			
			$this->set(compact("data"));
			
			return $this->render("/elements/canteen_reports/canteen_order_items");
			
		} else {
			
			$brands = $this->CanteenProduct->Brand->find("list",array("order"=>array("Brand.name"=>"ASC")));
			$canteenCategories = $this->CanteenProduct->CanteenCategory->treeList();
			
			$this->set(compact("brands","canteenCategories"));
			
		}
		
		
	}
	
	public function inventory() {
		
		
		
	}
	
	
}