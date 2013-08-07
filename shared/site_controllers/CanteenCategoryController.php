<?php

App::import("Controller","CanteenApp");

class CanteenCategoryController extends CanteenAppController {
	
	public $uses = array("CanteenCategory","CanteenProduct");
	
	public $category = false;
	
	public $helpers = array("Form");	

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow();
		
		$this->initPermissions();
		//die(pr($this->RequestHandler));
		$this->checkCategory();
		
	}
	
	private function checkCategory() {
		
		$uri = $this->request->params['uri'];
		
		$category = $this->CanteenCategory->find("first",array(
						"conditions"=>array(
							"CanteenCategory.uri"=>$uri,
							"CanteenCategory.active"=>1		
						),
						"contain"=>array()
					));
		
		if(!isset($category['CanteenCategory']['id'])) throw new NotFoundException();
		
		$this->category = $category;
		
		
		
		if(!empty($this->category['CanteenCategory']['parent_id'])) {
			
			$this->category = $this->CanteenCategory->getSubcat(array(
						"CanteenCategory.id"=>$this->category['CanteenCategory']['id']
					));
			$this->request->params['action'] = "category";
			
		} else {
			
			$this->request->action = "index";
			
		}
		
	//	die(pr($this->params));
		
	}
	
	public function index() {
		
		//get all the products from the sub categories
		
		
		$this->set("category",$this->category);
		
	}
	
	public function category() {
		
		$this->loadModel("CanteenCategory");
		$this->loadModel("CanteenProduct");

		$filters = $this->CanteenCategory->getProductFilters($this->category['CanteenCategory']['id']);
	
		$pcond = array(
	
				"CanteenProduct.active"=>1,
				"DATE(CanteenProduct.publish_date)<'".AppModel::awsNow()."'",
				"CanteenProduct.canteen_category_id"=>$this->category['CanteenCategory']['id']
		);
	
		$meta_filters = array();
		$brand_filters = array();
		$run_filters = false;
	
		if(isset($_GET['data'])) $this->request->data = $_GET['data'];
	
		if(count($this->request->data)>0) {
				
			if(isset($this->request->data['Brand'])) foreach($this->request->data['Brand'] as $b) if($b==1) $run_filters = true;
				
			if(isset($this->request->data['Meta'])) foreach($this->request->data['Meta'] as $b) if($b==1) $run_filters = true;
				
		}
	
		if($run_filters) {
				
			foreach($this->request->data['Brand'] as $k=>$v) if($v==1) $brand_filters[] = $k;
				
			foreach($this->request->data['Meta'] as $k=>$v) if($v==1) $meta_filters[] = $k;
				
		} else {
				
			$pcond['CanteenProduct.featured'] = 1;
				
		}
	
		$cache_token = "canteen_cat_product_ids_".md5(serialize($pcond));
	
		if(($product_id = Cache::read($cache_token,"1min")) === false) {
				
			$product_id = $this->CanteenProduct->find("all",array(
					"fields"=>array(
							"CanteenProduct.id"
					),
					"conditions"=>$pcond,
					"contain"=>array(),
					"order"=>array(
							"CanteenProduct.display_weight"=>"ASC",
							"CanteenProduct.publish_date"=>"DESC"
					)
			));
				
			Cache::write($cache_token,$product_id,"1min");
				
		}
	
		$products = array();
	
		foreach($product_id as $id) {
				
			//pr($id);
				
			$_p = $this->CanteenProduct->returnProduct(array(
					"conditions"=>array("CanteenProduct.id"=>$id['CanteenProduct']['id'])
			),$this->isAdmin());
				
			if(!$_p) continue;
				
			//filter brands
			if(count($brand_filters)>0 && !in_array($_p['Brand']['id'],$brand_filters)) continue;
				
			//filter meta
			if(count($meta_filters)>0) {
	
				$mstr = "";
				foreach($meta_filters as $m) $mstr .= $m."|";
				$mstr = rtrim($mstr,"|");
	
	
				$m_check = Set::extract("/Meta[id=/{$mstr}/]",$_p);
	
				if(count($m_check)<=0) continue;
	
			}
				
			//die(print_r($m_check));
				
			if($_p) $products[] = $_p;
				
		}
	
		
		$category = $this->category;
		
		$this->set(compact("category","filters","products"));
			
		$this->view = "category";
		
	}
	
	
	public function category_SHIT() {
	
		$this->loadModel("CanteenCategory");
		$this->loadModel("CanteenProduct");
	
		$uri = $this->request->params['uri'];
	
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
		if(count($this->request->data)>0) {
				
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
	
	
	
}