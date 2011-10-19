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
			"contain"=>array(),
			"order"=>array("CanteenProduct.display_weight"=>"ASC")
		));
		
		$prod_ids = Set::extract("/CanteenProduct/id",$prod_ids);
		
		$products = array();
		$brands = array();
		$metas = array();
		foreach($prod_ids as $id) {
			
			//$products[] = $this->CanteenProduct->returnProduct(array("conditions"=>array("CanteenProduct.id"=>$id)),$this->isAdmin(),false,array("no_related"=>true));
			
			$token = "cat_product_".$id;
			
			if(($p = Cache::read($token,"1min")) === false) {
				
				$p = $this->CanteenProduct->find("first",array(
						"conditions"=>array(
							"CanteenProduct.id"=>$id,
							"CanteenProduct.active"=>1,
							"CanteenProduct.featured"=>1,
							
						),
						"contain"=>array(
							"CanteenProductImage"=>array(),
							"CanteenProductPrice",
							"Brand",
							"Meta"
						)
					));
			
				Cache::write($token,$p,"1min");
				
			}
			
			$products[] = $p;
			$brands[$p['Brand']['id']] = $p['Brand'];
			foreach($p['Meta'] as $m)  $metas[$m['key']][$m['id']] = $m['val'];
		}
		
		//filter the products
		if(count($this->data)>0) {
			
			$brand_filters = $this->extractBrandFilters();
			
			$meta_filters = $this->extractMetaFilters();
			
			$filter_ids = array();
			
			if(strlen($meta_filters)>0) {
				
				$meta_products = Set::extract("/Meta[id=/{$meta_filters}/i]",$products);
				
				$_tmp = Set::extract("/Meta/CanteenProductsMeta/canteen_product_id",$meta_products);
				
				$filter_ids = array_merge($filter_ids,$_tmp);
				
			}
			
			//check for brand filters
			if(strlen($brand_filters)>0) {
				
				$brand_products = Set::extract("/Brand[id=/{$brand_filters}/i]",$products);
				
				
				
			}
			
			
			$ids = array_flip($filter_ids);
			
			$ids_str = rtrim(implode("|",array_keys($ids)),"|");
			
			$products = Set::extract("/CanteenProduct[id=/{$ids_str}/i]",$products);
			
			die(print_r($products));
			
		}
		
		$this->set(compact("products","brands","metas"));
		
	}
	
	public function order($id = false) {
		
		if($id) {
			
			$this->loadModel("CanteenOrder");
			
			$order = $this->CanteenOrder->returnAdminOrder($id);
			
			if(isset($order['CanteenOrder']['id'])) {
				
				$this->set(compact("order"));
				
			}
			
		} else {
			
			return $this->cakeError("error404");
			
		}
		
	}
	
	
	public function clear_session() {
		
		$this->Session->delete("CanteenOrder");
		
		$this->Session->delete("CanteenAdminAddItem");
		
		return $this->redirect("/canteen");
		
	}
	
	
	//filtering helpers
	private function extractBrandFilters() {
		
		$filters = array();
		
		foreach($this->data['Brand'] as $k=>$v) if($v==1) $filters[]=$k;

		$str = implode("|",$filters);
		
		$str = rtrim($str,"|");
		
		return $str;
		
	}
	
	private function extractMetaFilters() {
		
		$filters = array();
		
		foreach($this->data['Meta'] as $k=>$v) if($v==1) $filters[]=$k;
		
		$str = implode("|",$filters);
		
		$str = rtrim($str,"|");
		
		return $str;
		
	}
	

}