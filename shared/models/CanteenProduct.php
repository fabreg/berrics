<?php 

App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));

class CanteenProduct extends AppModel {
	
	
	public $hasMany = array(
	
		"ChildCanteenProduct"=>array(
			"className"=>"CanteenProduct",
			"foreignKey"=>"parent_canteen_product_id",
			"order"=>array("ChildCanteenProduct.display_weight"=>"ASC")
		),
		
		"CanteenProductPrice",
		"CanteenProductImage",
		"CanteenProductInventory",
	
	);
	
	public $belongsTo = array(
		"CanteenCategory",
		"Brand",
		"ParentCanteenProduct"=>array(
			"className"=>"CanteenProduct",
			"foreignKey"=>"parent_canteen_product_id"
		),
	);
	
	public $hasAndBelongsToMany = array(
	
		"Meta"=>array(
			"order"=>array("Meta.key"=>"ASC")
		),
		"Tag"	
	
	);
	
	public function returnChildProduct($id) {
		
		$product = $this->find("first",array(
					"conditions"=>array(
						"CanteenProduct.id"=>$id		
					),
					"contain"=>array(
						"ParentCanteenProduct"=>array(
							"Brand"		
						),
						"CanteenProductInventory"=>array(
							"CanteenInventoryRecord"=>array(
								"Warehouse"		
							)		
						)	
					)
				));
		return $product;
	}
	
	public function returnAdminProduct($id) {
		
		$p = $this->find("first",array(
			
			"conditions"=>array(
				"CanteenProduct.id"=>$id
			),
			"contain"=>array(
				"Tag",
				"CanteenProductPrice"=>array(
					"Currency"
				),
				"ChildCanteenProduct"=>array(
				
					"conditions"=>array(
						"ChildCanteenProduct.active"=>1,
						"ChildCanteenProduct.deleted"=>0
					),
					"CanteenProductInventory"=>array(
						"CanteenInventoryRecord"=>array(
							"Warehouse"
						)
					)
				),
				"CanteenProductImage"=>array(
					
					"order"=>array(
						"CanteenProductImage.front_image"=>"DESC",
						"CanteenProductImage.display_weight"=>"ASC"
					)
				 
				),
				"CanteenProductInventory"=>array(
					"CanteenInventoryRecord"
				),
				"Meta",
				"Brand"
			)
		
		));
		
		$p['CanteenProduct']['pub_date'] = date("Y-m-d",strtotime($p['CanteenProduct']['publish_date']));
		
		$p['CanteenProduct']['pub_time'] = date("H:i",strtotime($p['CanteenProduct']['publish_date']));
		
		//get the related style codes
		$r = $this->find("all",array(
			"conditions"=>array(
				"CanteenProduct.style_code"=>$p['CanteenProduct']['style_code'],
				"CanteenProduct.id !="=>$p['CanteenProduct']['id']
			),
			"contain"=>array()
		));
		
		$p['RelatedStyles'] = $r;
		
		unset($r);
		
		return $p;
		
	}
	
	public function returnProduct($cond = array(),$isAdmin = false,$inner_call = false,$extra = array()) {
		
		
		$token = "return_product_".md5(serialize($cond).$isAdmin.$inner_call.serialize($extra));
		
		if(($prod = Cache::read($token,"1min")) === false) {
			
				
				$_contain = array(
						"ChildCanteenProduct"=>array(
							"conditions"=>array(
								"ChildCanteenProduct.deleted"=>0,
								"ChildCanteenProduct.active"=>1
							),
							"CanteenProductInventory"=>array(
								"CanteenInventoryRecord"
							)
						),
						"CanteenProductPrice"=>array(
							"Currency"
						),
						"CanteenCategory",
						"Brand",
						"CanteenProductImage"=>array(	
							"order"=>array(
								"CanteenProductImage.front_image"=>"DESC",
								"CanteenProductImage.display_weight"=>"ASC"
							)
						),
						"Meta"=>array("order"=>array("Meta.key"=>"ASC"))

				);
	
				
				$_cond = array();
			
				if(!$isAdmin) {
					
					$_cond[] = 'CanteenProduct.publish_date < NOW()';
					$_cond['CanteenProduct.active'] = 1;
					
				}
				
				//let's merge the defaults with the incoming
				if(array_key_exists("contain",$cond) && is_array($cond['contain'])) {
					
					$_contain = array_merge($_contain,$cond['contain']);
					
				}
				
				if(array_key_exists("conditions",$cond) && is_array($cond['conditions'])) {
						
					$_cond = array_merge($_cond,$cond['conditions']);
					
				}
				
				$verb = "first";
				
				if($inner_call) {
					
					$verb = "all";
					
				}
				
				$prod = $this->find($verb,array(
				
					"conditions"=>$_cond,
					"contain"=>$_contain
				
				));
				
				if(!$inner_call && empty($prod['CanteenProduct']['id'])) {
					
					
					return false;
					
				}
				
				if(!$inner_call && !isset($extra['no_related']) && !empty($prod['CanteenProduct']['style_code'])) {
					
					$related_styles = array();
					
					$styles = $this->returnProduct(
						array("conditions"=>array(
							"CanteenProduct.style_code"=>$prod['CanteenProduct']['style_code'],
							"NOT"=>array(
								"CanteenProduct.id"=>array($prod['CanteenProduct']['id'])
							),
							"CanteenProduct.active"=>1	
						
						)),
						$isAdmin,
						true
					);
					
					$prod['RelatedStyles'] = $styles;
					
				}
				
				Cache::write($token,$prod,"1min");
			
		}
		
		
		return $prod;
		
	}
	
	public function returnCartItem($opts = array()) {
		
		$def = array(
			"parent_canteen_product_id"=>NULL,
			"currency_id"=>"USD"
		);
		
		$opts = array_merge($def,$opts);
		
		$parent_product = $this->find("first",array(
			"contain"=>array(
				"ParentCanteenProduct"=>array(
					"CanteenProductImage",
					"CanteenProductPrice"=>array(
						"conditions"=>array(
							"CanteenProductPrice.currency_id"=>$opts['currency_id']
						)
					)
				)
			),
			"conditions"=>array(
				"ParentCanteenProduct.id"=>$opts['parent_canteen_product_id']
			)
		));
		
		//$parent_product['ParentCanteenProduct'] = $parent_product['CanteenProduct'];
		
		
		$product = $this->find("first",array(
			"conditions"=>array("CanteenProduct.id"=>$opts['canteen_product_id']),
			"contain"=>array(
					"ParentCanteenProduct"=>array(
						"CanteenProductImage",
						"CanteenProductPrice"=>array(
							"conditions"=>array(
								"CanteenProductPrice.currency_id"=>$opts['currency_id']
							)
						),
						"Brand"
					)
			)
		));
		
		return array_merge($product);
		
	}

	public function addNewOption($data = array()) {
		
		$id = $data['CanteenProduct']['id'];
		
		$this->create();
		
		$this->save(array(
			"parent_canteen_product_id"=>$id,
			"active"=>1,
			"deleted"=>0
		));
		
	}
	
	public function addCommonShirtOptions($data = array()) {
		
		$id = $data['CanteenProduct']['id'];
		
		//sizes
		$s = array("S","M","L","XL","XXL");
		
		foreach($s as $k=>$v) {
			
			$this->create();
			$this->save(array(
				"parent_canteen_product_id"=>$id,
				"active"=>1,
				"delete"=>0,
				"opt_label"=>"Size",
				"opt_value"=>$v,
				"display_weight"=>($k+1)
			));
			
		}
		
		
	}
	
	public function addCommonPantsOptions($data = array()) {
		
		$id = $data['CanteenProduct']['id'];
		
		//sizes
		$s = array(26,28,30,32,34,36,38,40);
		
		foreach($s as $k=>$v) {
			
			$this->create();
			$this->save(array(
				"parent_canteen_product_id"=>$id,
				"active"=>1,
				"delete"=>0,
				"opt_label"=>"Size",
				"opt_value"=>$v,
				"display_weight"=>($k+1)
			));
			
		}
		
	}
	
	public function addCommonHatOptions($data = array()) {
		
		$id = $data['CanteenProduct']['id'];
		
		//sizes
		$s = array("XS","XS/S","S/M","M/L","L/XL","XL");
		
		foreach($s as $k=>$v) {
			
			$this->create();
			$this->save(array(
				"parent_canteen_product_id"=>$id,
				"active"=>1,
				"delete"=>0,
				"opt_label"=>"Size",
				"opt_value"=>$v,
				"display_weight"=>($k+1)
			));
			
		}
		
	}
	
	public static function merchTemplates() {
		
		$a = array(
		
			"standard"=>"Standard",
			"widescreen"=>"Wide Screen"
		
		);
		
		return $a;
	}
	
	public function returnNewProducts($limit = 9,$categories = false) {
		
		$ids = $this->find("all",array(
			"fields"=>array(
				"CanteenProduct.id"
			),
			"conditions"=>array(
				"CanteenProduct.parent_canteen_product_id"=>NULL,
				"CanteenProduct.active"=>1,
				"CanteenProduct.featured"=>1,
				"CanteenProduct.brand_id"=>3,
				"CanteenProduct.publish_date < NOW()"
			),
			"contain"=>array(),
			"order"=>array("CanteenProduct.publish_date"=>"DESC"),
			"limit"=>$limit
		));
		
		$products = array();
		
		foreach($ids as $v) $products[] = $this->returnProduct(array("conditions"=>array("CanteenProduct.id"=>$v['CanteenProduct']['id'])));
		
		return $products;
		
	}
	
	private function checkDupeUrl($CanteenProduct) {
		
		$chk = $this->find("count",array(
			"conditions"=>array(
				"CanteenProduct.id !="=>$CanteenProduct['CanteenProduct']['id'],
				"CanteenProduct.uri"=>$CanteenProduct['CanteenProduct']['uri']
			),
			"contain"
		));
		
		return $chk;
		
	}
	
	public function validateProduct($CanteenProduct) {
		
		$mgs = array();
		
		//check if there are any images
		if(count($CanteenProduct['CanteenProductImage'])<=0) {
			
			$msg[] = "There are no images";
			
		}
		
		//check to see if there are any zero prices
		foreach($CanteenProduct['CanteenProductPrice'] as $p) {
			
			if($p['price']<=0) $msg[] = "{$p['currency_id']} Missing Price";
			
		}
		
		//check for at least one meta tag
		if(count($CanteenProduct['Meta'])<=0) $msg[] = "Missing Meta Tags";
		
		//check for a style/swatch image
		if(empty($CanteenProduct['CanteenProduct']['style_code_image'])) $msg[] = "Missing Style Code Image";
		
		//check for style code
		if(empty($CanteenProduct['CanteenProduct']['style_code'])) $msg[] = "Missing Style Code";
		
		//check for tags
		if(count($CanteenProduct['Tag'])<=0) $msg[] = "Missing Tags";
		
		//check for duplicate URL
		
		//check for description
		if(empty($CanteenProduct['CanteenProduct']['description'])) $msg[] = "Missing Description";
		
		foreach($CanteenProduct['ChildCanteenProduct'] as $c) {
			
			if(isset($c['CanteenInventoryRecord'][0]['id'])) {
				
				if(empty($c['CanteenInventoryRecord'][0]['foreign_key'])) {
					
					$msg[] = "Linked inventory is missing foreign key!";
					
				}
				
			}
			
		}
		
		return $msg;
	}
	
	public function superProductDropdown() {
		
		$parents = $this->find("all",array(
					"conditions"=>array(
						"CanteenProduct.parent_canteen_product_id"=>null			
					),
					"contain"=>array(
						"CanteenCategory"
					),
					"order"=>array(
						"CanteenCategory.name"=>"ASC",
						"CanteenProduct.name"=>"ASC"		
					)
				));
		
		$drop = array();
		
		foreach($parents as $p) {
			
			$key = "".$p['CanteenCategory']['name']." ".$p['CanteenProduct']['name']." - ".$p['CanteenProduct']['sub_title'];
			
			
			$c = $this->find("all",array(
						"conditions"=>array(
							"CanteenProduct.parent_canteen_product_id"=>$p['CanteenProduct']['id']		
						),
						"contain"=>array()
					));
			
			foreach($c as $k=>$v) {
				
				$drop[$key][$v['CanteenProduct']['id']] = $p['CanteenProduct']['name']." - ".$p['CanteenProduct']['sub_title']." [".$v['CanteenProduct']['opt_label']." = ".$v['CanteenProduct']['opt_value']."]";
				
			}
			
			
			
		}
		
		return $drop;
		
	}
	
	public function returnRandomProduct() {
		
		$token = "random_canteen_product";
		
		if(($product = Cache::read($token,"1min")) === false) {
			$pid = $this->find("first",array(
					"fields"=>array(
							"CanteenProduct.id"
					),
					"conditions"=>array(
							"CanteenProduct.publish_date<NOW()",
							"CanteenProduct.active"=>1,
							"CanteenProduct.parent_canteen_product_id"=>null
					),
					"contain"=>array(),
					"order"=>"rand()"
			));
				
			$product = $this->returnProduct(array(
					"conditions"=>array("CanteenProduct.id"=>$pid['CanteenProduct']['id'])
			));
			
			
			
			Cache::write($token,$product,"1min");
			
		}
		
		//die(print_r($product));
		
		return $product;
		
	}

	public function productViewSimilarProducts($category_id,$limit = 4,$exclude_ids = array()) {
		
		$token = "prodview-similar-{$category_id}-{$limit}-".serialize($exclude_ids);

		if(($products = Cache::read($token,"5min")) === false) {

			$pids = $this->find('all',array(
						"fields"=>array(
							"CanteenProduct.id"
						),
						"conditions"=>array(
							"CanteenProduct.canteen_category_id"=>$category_id,
							"CanteenProduct.active"=>1,
							"CanteenProduct.publish_date < NOW()",
							"NOT"=>array(
								"CanteenProduct.id"=>$exclude_ids
							)
						),
						"contain"=>array(),
						"order"=>array("RAND()"),
						"limit"=>$limit
					));

			$products = array();

			foreach($pids as $id) {

				$products[] = $this->returnProduct(array(
									"conditions"=>array("CanteenProduct.id"=>$id['CanteenProduct']['id'])
								));

			}

			//Cache::write($token,$products,"5min");

		}

		return $products;

	}

	
}