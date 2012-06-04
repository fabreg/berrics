<?php

App::import("Controller","CanteenApp");

class CanteenController extends CanteenAppController {
	
	public $uses = array();
	
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function dump_server() {
		
		die(print_r($_SERVER));
		
	}
	
	public function index() {
		
		$this->loadModel("CanteenCategory");
		$this->loadModel("CanteenProduct");
		$this->loadModel("CanteenDoormat");
		$this->loadModel("Brand");
		
		$doormats = $this->CanteenDoormat->find("all",array(
			"conditions"=>array(
				"CanteenDoormat.active"=>1
			),
			"contain"=>array("MediaFile"),
			"order"=>array("CanteenDoormat.display_weight"=>"ASC")
		));
		
		//get the latest products
		$new_products = $this->CanteenProduct->returnNewProducts();
		
		//get the featured brands
		
		$brands = $this->Brand->find("all",array(
			"conditions"=>array(
				"Brand.featured"=>1,
				"Brand.active"=>1
			),
			"contain"=>array()
		));
		
		$this->set(compact("doormats","new_products","brands"));
		
	}
	
	public function category() {
		
		
		$this->loadModel("CanteenCategory");
		$this->loadModel("CanteenProduct");
		
		$category = $this->CanteenCategory->getSubcat(array(
				"CanteenCategory.uri"=>$this->params['uri']
		));
		
		$filters = $this->CanteenCategory->getProductFilters($category['CanteenCategory']['id']);
		
		$pcond = array(
		
					"CanteenProduct.active"=>1,
					"DATE(CanteenProduct.publish_date)<NOW()",
					"CanteenProduct.canteen_category_id"=>$category['CanteenCategory']['id']
		);
		
		$meta_filters = array();
		$brand_filters = array();
		$run_filters = false;
		
		if(isset($_GET['data'])) $this->data = $_GET['data'];
		
		if(count($this->data)>0) {
			
			if(isset($this->data['Brand'])) foreach($this->data['Brand'] as $b) if($b==1) $run_filters = true;
			
			if(isset($this->data['Meta'])) foreach($this->data['Meta'] as $b) if($b==1) $run_filters = true;
			
		}
		
		if($run_filters) {
			
			foreach($this->data['Brand'] as $k=>$v) if($v==1) $brand_filters[] = $k;
			
			foreach($this->data['Meta'] as $k=>$v) if($v==1) $meta_filters[] = $k;
			
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
					"CanteenProduct.display_weight"=>"ASC"
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
		
		$this->set(compact("category","filters","products"));
			
	}
	
	
	public function category_SHIT() {
		
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
		
		if(count($this->data)>0) $this->order_note(base64_encode($this->here));
		
		if($id) {
			
			$this->loadModel("CanteenOrder");
			
			$o = $this->CanteenOrder->find("first",array("contain"=>array(),"conditions"=>array("CanteenOrder.hash"=>$id)));
			
			$order = $this->CanteenOrder->returnAdminOrder(Set::classicExtract($o,"CanteenOrder.id"),array("with_shipping_items"));
			
			if(isset($order['CanteenOrder']['id'])) {
				
				$this->set(compact("order"));
				
			} else {
				
				return $this->cakeError("error404");
				
			}
			
		} else {
			
			return $this->cakeError("error404");
			
		}
		
	}
	
	public function printable($type,$hash = false) {
		
		$this->layout = "canteen_printer";
		
		
		if($hash) {
			
			$this->loadModel("CanteenOrder");
			
			$o = $this->CanteenOrder->find("first",array("contain"=>array(),"conditions"=>array("CanteenOrder.hash"=>$hash)));
			
			$order = $this->CanteenOrder->returnAdminOrder(Set::classicExtract($o,"CanteenOrder.id"));
			
			if(isset($order['CanteenOrder']['id'])) {
				
				$this->set(compact("order"));
				
			} else {
				
				return $this->cakeError("error404");
				
			}
			
		} else {
			
			return $this->cakeError("error404");
			
		}
		
		switch($type) {
			
			case "receipt":
			default:
				$ele = "order-receipt";
			break;
			
		}
		
		$this->render("/elements/canteen_printing/{$ele}");
		
	}
	
	public function order_note($callback = false) {
		
		if(count($this->data)>0) {
			$this->loadModel("CanteenOrderNote");
			
			$this->CanteenOrderNote->setCustomerNoteValidation();
			
			$this->CanteenOrderNote->set($this->data);
			
			$validation = $this->CanteenOrderNote->validates();
			
			$cb = base64_decode($callback);
			
			if($validation) {
				
				$this->CanteenOrderNote->addCustomerNote($this->data);
				
				$redir = $this->here;
				
				return $this->redirect($cb);
				
			} else {
				
				if($callback) {
					
					$this->Session->setFlash("There were errors in your note, please correct them");
					
					return $this->redirect($cb);
					
				} else {
		
					
					return $this->cakeError("error404");	
				
					
				}
				
			}
			
		} else {
			
			return $this->cakeError("error404");
			
		}
		
		
		
	}
	
	public function brands() {
		
		$this->loadModel("Brand");
		
		$brands = $this->Brand->find("all",array(
			"conditions"=>array(
				"Brand.active"=>1,
				"Brand.featured"=>1
			),
			"contain"=>array()
		));
		
		$this->set(compact("brands"));
		
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