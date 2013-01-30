<?php

App::import("Controller","LocalApp");

class CanteenProductsController extends LocalAppController {
	
	private $updateHash = "";
	
	private $ljg_products_schema = array(

				'Company Number',
				'UPC Code',
				'Product Code',
				'Description',
				'Division Code',
				'Division Desc',
				'Color Code',
				'Color Desc',
				'Size Type',
				'Size',
				'Price',
				'Weight',
				"New?",
				"new2?",
				'Long Desc',
				'Technical Desc'
		
	);
	
	public function beforeFilter() {
		
		App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}	
	

	public function filter() {
		
		if(count($this->request->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"s"=>true
				);
				
				
				foreach($this->request->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						if(empty($vv)) continue;

						$url[$k.".".$kk]=$vv;
						
					}
					
				}
				
				return $this->redirect($url);
				
		}
		
		
	}
	
	
	public function index() {
		
		$this->Paginator->settings = array();

		$this->Paginator->settings['CanteenProduct'] = array(
		
			"contain"=>array(
				"CanteenCategory",
				"CanteenProductImage"=>array(
					"order"=>array(
						"CanteenProductImage.front_image"=>"DESC",
						"CanteenProductImage.display_weight"=>"ASC"
					),
					"limit"=>1
				),
				"Brand",
				"CanteenProductPrice"=>array(
					"conditions"=>array(
						"CanteenProductPrice.currency_id"=>"USD"
					)
				)
			),
			"conditions"=>array(
				
					"CanteenProduct.parent_canteen_product_id"=>NULL
				
			),
			"order"=>array("CanteenProduct.created"=>"DESC")
		
		);
		
		if(isset($this->request->params['named']['s'])) {

			if(isset($this->request->params['named']['CanteenProduct.canteen_category_id'])) {
				
				$this->Paginator->settings['CanteenProduct']['conditions']['CanteenProduct.canteen_category_id'] = 
				$this->request->data['CanteenProduct']['canteen_category_id'] = 
				$this->request->params['named']['CanteenProduct.canteen_category_id'];
				
			}
			if(isset($this->request->params['named']['CanteenProduct.brand_id'])) {
				
				$this->Paginator->settings['CanteenProduct']['conditions']['CanteenProduct.brand_id'] = 
				$this->request->data['CanteenProduct']['brand_id'] = 
				$this->request->params['named']['CanteenProduct.brand_id'];
				
			}
			
			if(isset($this->request->params['named']['CanteenProduct.name'])) {
				
				$this->Paginator->settings['CanteenProduct']['conditions']['CanteenProduct.name LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['CanteenProduct.name'])."%";
				$this->request->data['CanteenProduct']['name'] = $this->request->params['named']['CanteenProduct.name'];
				
			}
			if(isset($this->request->params['named']['CanteenProduct.sub_title'])) {
				
				$this->Paginator->settings['CanteenProduct']['conditions']['CanteenProduct.sub_title LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['CanteenProduct.sub_title'])."%";
				$this->request->data['CanteenProduct']['sub_title'] = $this->request->params['named']['CanteenProduct.sub_title'];
				
			}
			if(isset($this->request->params['named']['CanteenProduct.active'])) {
				
				$this->Paginator->settings['CanteenProduct']['conditions']['CanteenProduct.active'] = 
				$this->request->data['CanteenProduct']['active'] = 
				$this->request->params['named']['CanteenProduct.active'];
				
			}
			if(isset($this->request->params['named']['CanteenProduct.featured'])) {
				
				$this->Paginator->settings['CanteenProduct']['conditions']['CanteenProduct.featured'] = 
				$this->request->data['CanteenProduct']['featured'] = 
				$this->request->params['named']['CanteenProduct.featured'];
				
			}
			
			if(isset($this->request->params['named']['CanteenProductPrice.currency_id'])) {
				
				$this->Paginator->settings['CanteenProduct']['contain']['CanteenProductPrice']['conditions']['CanteenProductPrice.currency_id'] = $this->request->params['named']['CanteenProductPrice.currency_id'];
				
				$this->request->data['CanteenProductPrice']['currency_id'] = $this->request->params['named']['CanteenProductPrice.currency_id'];
				
				
			}
			
		} else {
			
			$this->request->data['CanteenProduct']['active'] = $this->request->data['CanteenProduct']['featured'] = 1;
			
		}

		//set some menus
		
		$canteenCategories = $this->CanteenProduct->CanteenCategory->treeList();
		
		$brands = $this->CanteenProduct->Brand->find("list");
	
		$products = $this->Paginate("CanteenProduct");
		
		$this->set(compact("products","canteenCategories","brands"));
		
		
	}
	
	public function toggle_featured($product_id = false) {
		
		//get the product
		$p = $this->CanteenProduct->find("first",array(
			"conditions"=>array(
				"CanteenProduct.id"=>$product_id
			),
			"contain"=>array()
		));
		
		$seed = 0;
		
		if($p['CanteenProduct']['featured'] != 1) {
			
			$seed = 1;
			
		}
		
		$this->CanteenProduct->create();
		$this->CanteenProduct->id = $product_id;
		$this->CanteenProduct->save(array(
			"featured"=>$seed
		));
		
		$url = base64_decode($this->request->params['named']['callback']);
		
		return $this->redirect($url);
		
	}
	
	public function toggle_active($product_id = false) {
		
		//get the product
		$p = $this->CanteenProduct->find("first",array(
			"conditions"=>array(
				"CanteenProduct.id"=>$product_id
			),
			"contain"=>array()
		));
		
		$seed = 0;
		
		if($p['CanteenProduct']['active'] != 1) {
			
			$seed = 1;
			
		}
		
		$this->CanteenProduct->create();
		$this->CanteenProduct->id = $product_id;
		$this->CanteenProduct->save(array(
			"active"=>$seed
		));
		
		$url = base64_decode($this->request->params['named']['callback']);
		
		return $this->redirect($url);
		
	}
	
	
	public function add() {
		
		if(count($this->request->data)>0) {
			
			$this->fixPublishDate();
			
			$this->request->data['Tag'] = $this->CanteenProduct->Tag->parseTags($this->request->data['CanteenProduct']['tags']);
			
			if(empty($this->request->data['CanteenProduct']['uri'])) {
				
				$brand = $this->CanteenProduct->Brand->find("first",array(
					"conditions"=>array("Brand.id"=>$this->request->data['CanteenProduct']['brand_id']),
					"contain"=>array()
				));
				
				$ustr = $brand['Brand']['name']." ".$this->request->data['CanteenProduct']['name']." ".$this->request->data['CanteenProduct']['sub_title'];
				
				$this->request->data['CanteenProduct']['uri'] = Tools::safeUrl($ustr).".html";
				
			}
			
			$this->request->data['CanteenProduct']['display_weight'] = 99;			
			$this->CanteenProduct->save($this->request->data);
			
			$new_id = $this->CanteenProduct->id;
			
			//add in all the product prices in the default config
			
			$curr = CanteenConfig::get("currencies");
			
			foreach($curr as $c) {
				
				$this->CanteenProduct->CanteenProductPrice->create();
				
				$this->CanteenProduct->CanteenProductPrice->save(array(
				
					"canteen_product_id"=>$new_id,
					"currency_id"=>$c	
				
				));
				
			}
			
			
			
			
			
			return $this->flash("Product Added Successfully","/canteen_products/edit/".$new_id);
			
			
		} else {
			
			$this->request->data['CanteenProduct']['pub_date'] = date("Y-m-d",strtotime("+30 Day"));
			$this->request->data['CanteenProduct']['pub_time'] = "00:00";			
			
		}
		
		$this->canteenProductSelects();
		
		
	}
	
	public function edit($id = false) {
		
		if(count($this->request->data)>0) {
			
			$this->fixPublishDate();
			
			if(isset($this->request->data['AddNewOption'])) {
				
				$this->CanteenProduct->addNewOption($this->request->data);
				
				$this->updateHash = "#Options %26 Inventory";
				
			}
			
			if(isset($this->request->data['AddCommonShirtOptions'])) {
				
				$this->CanteenProduct->addCommonShirtOptions($this->request->data);
				
				$this->updateHash = "#Options %26 Inventory";
				
			}
			
			if(isset($this->request->data['AddCommonPantsOptions'])) {
				
				$this->CanteenProduct->addCommonPantsOptions($this->request->data);
				
				$this->updateHash = "#Options %26 Inventory";
				
			}
			if(isset($this->request->data['AddCommonHatOptions'])) {
				
				$this->CanteenProduct->addCommonHatOptions($this->request->data);
				
				$this->updateHash = "#Options %26 Inventory";
				
			}
			
			
			if(isset($this->request->data['AddNewImage'])) {
				
				$this->uploadImage();
				
				$this->updateHash = "#Images";
				
			}
			
			if(isset($this->request->data['AddMeta'])) {
				
				$this->insertMeta();
				
				$this->updateHash = "#Meta Data";
				
			}
			
			if(isset($this->request->data['RemoveMeta'])) {
				
				$this->removeMeta();
				
				$this->updateHash = "#Meta Data";
				
			}
			
			$this->request->data['Tag'] = $this->CanteenProduct->Tag->parseTags($this->request->data['CanteenProduct']['tags']);
			
			if(!is_uploaded_file($this->request->data['CanteenProduct']['style_code_image']['tmp_name'])) unset($this->request->data['CanteenProduct']['style_code_image']);
			
			if(isset($this->request->data['UploadStyleCodeImage'])) {
				
				$this->uploadStyleCodeImage();
				
			}
			
			//check if auto currency is checked
			
			if($this->request->data['CanteenProduct']['auto_calc_currencies'] == 1) {
				
				//get the USD price
				$usd_price = Set::extract("/CanteenProductPrice[currency_id=USD]/price",$this->request->data);
				
				if(is_numeric($usd_price[0])) {
					
					foreach($this->request->data['CanteenProductPrice'] as $k=>$p) {
						
						if($p['currency_id'] == "USD") continue;
						
						
						
						$converted = $this->CanteenProduct->CanteenProductPrice->Currency->convertCurrency("USD",$p['currency_id'],$usd_price[0]);
						
						//round up!
						$converted = ceil($converted);
						
						$converted -= .05;
						
						$this->request->data['CanteenProductPrice'][$k]['price'] = $converted;
						
					}
					
				}
				
			}
			
			$this->CanteenProduct->saveAll($this->request->data);
			
			
			//stuff for after the save has occured.
			if(isset($this->request->data['PromoteFrontImage'])) {
				
				$this->promoteFrontImage();
				
				$this->updateHash = "#Images";
			}
			
			if(isset($this->request->data['PromoteThumbImage'])) {
				
				$this->promoteThumbImage();
				
				$this->updateHash = "#Images";
			}
			
			if(isset($this->request->data['RemoveImage'])) {
				
				$this->removeImage();
				
				$this->updateHash = "#Images";
			}
			
			if(isset($this->request->data['RemoveOption'])) {
				
				$this->removeOption();
				$this->updateHash = "#Options %26 Inventory";
			}
			
			if(isset($this->request->data['UpdateOptions'])) {
				
				
				$this->updateHash = "#Options %26 Inventory";
			}
	
			return $this->flash("Product Updated Successfully","/canteen_products/edit/".$this->request->data['CanteenProduct']['id']."/c:".time().$this->updateHash);
			
		} else {
			
			$product = $this->CanteenProduct->returnAdminProduct($id);
			$this->request->data = $product;
		}
		
		$this->request->data['ValidateMessage'] = $this->CanteenProduct->validateProduct($this->request->data);
		
		$this->canteenProductSelects();
		
		
		
	}
	
	
	private function canteenProductSelects() {
		
		//$this->set("canteenCategories",$this->CanteenProduct->CanteenCategory->find("list"));
		$this->set("canteenCategories",$this->CanteenProduct->CanteenCategory->treeList());
		$this->set("brands",$this->CanteenProduct->Brand->find("list",array("order"=>array("Brand.name"=>"ASC"))));
		
		$this->set("currencies",$this->CanteenProduct->CanteenProductPrice->Currency->find("list",array("order"=>array("Currency.name"=>"ASC"))));
		
	}
	
	
	private function fixPublishDate() {
		
		if(isset($this->request->data['CanteenProduct']['pub_date']) && isset($this->request->data['CanteenProduct']['pub_time'])) {
			
			$this->request->data['CanteenProduct']['publish_date']  = $this->request->data['CanteenProduct']['pub_date']." ".$this->request->data['CanteenProduct']['pub_time'].":00";
			
		} else {
			
			unset($this->request->data['CanteenProduct']['publish_date']);
			
		}
		
	}
	
	private function uploadImage() {
		
		$file = $this->request->data['CanteenProduct']['AddImage'];
		
		if(is_uploaded_file($file['tmp_name'])) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
			
			$fileName = md5(time()).mt_rand(100,1000).".".$ext;
			
			move_uploaded_file($file['tmp_name'],TMP.$fileName);
			
			ImgServer::instance()->upload_product_image($fileName,TMP.$fileName);
			
			unlink(TMP.$fileName);
			
			$this->request->data['CanteenProductImage'][] = array(
				"file_name"=>$fileName
			);
			
		}
		
		
		
	}
	
	private function promoteFrontImage() {
		
		$prod_id = $this->request->data['CanteenProduct']['id'];
		
		//demote all the images
		
		$this->CanteenProduct->CanteenProductImage->updateAll(
			array(
				"front_image"=>0
			),
			array(
				"canteen_product_id"=>$prod_id
			)
		);
		
		foreach($this->request->data['PromoteFrontImage'] as $k=>$v) {
			
			$image_id = $k;
			
		}
		
		
		$this->CanteenProduct->CanteenProductImage->create();
		$this->CanteenProduct->CanteenProductImage->id = $image_id;
		
		$this->CanteenProduct->CanteenProductImage->save(array(
		
			"front_image"=>1
		
		));

		
	}
	
	private function promoteThumbImage() {
		
		$prod_id = $this->request->data['CanteenProduct']['id'];
		
		//demote all the images
		
		$this->CanteenProduct->CanteenProductImage->updateAll(
			array(
				"thumb_image"=>0
			),
			array(
				"canteen_product_id"=>$prod_id
			)
		);
		
		foreach($this->request->data['PromoteThumbImage'] as $k=>$v) {
			
			$image_id = $k;
			
		}
		
		
		$this->CanteenProduct->CanteenProductImage->create();
		$this->CanteenProduct->CanteenProductImage->id = $image_id;
		
		$this->CanteenProduct->CanteenProductImage->save(array(
		
			"thumb_image"=>1
		
		));
		
		
		
	}
	
	private function removeImage() {
		
		foreach($this->request->data['RemoveImage'] as $k=>$v) {
			
			$image_id = $k;
			
		}
		
		//get the image
		
		$img = $this->CanteenProduct->CanteenProductImage->find("first",array(
		
			"conditions"=>array(
				"CanteenProductImage.id"=>$image_id
			),
			"contain"=>array()
			
		
		));
		
		if(isset($img['CanteenProductImage']['id'])) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
		
			$this->CanteenProduct->CanteenProductImage->delete($image_id);
			
			ImgServer::instance()->delete_product_image($img['CanteenProductImage']['file_name']);
			
		}
		
	}
	
	private function removeOption() {
		
		$opt_id = false;
		
		foreach($this->request->data['RemoveOption'] as $k=>$v) {
			
			$opt_id = $k;
			
		}
		
		if($opt_id) {
			
			$this->CanteenProduct->id = $opt_id;
			$this->CanteenProduct->save(array(
				
				"deleted"=>1,
				"active"=>0
			
			));
			
			
		}
		
		
	}
	
	private function insertMeta() {
		
		$id = $this->CanteenProduct->Meta->addMeta($this->request->data['NewMetaKey'],$this->request->data['NewMetaVal']);
		
		$this->request->data['Meta'][] = $id;
		
		
	}
	
	private function removeMeta() {
		
		foreach($this->request->data['RemoveMeta'] as $k=>$v) {
			
			$id = $k;
			
		}
		
		
		foreach($this->request->data['Meta'] as $k=>$v) {
				
				if($id == $v) {
					
					unset($this->request->data['Meta'][$k]);
					
				}
				
		}	
		
		if(count($this->request->data['Meta'])<=0) {
			
			$this->request->data['Meta'][] = null;
			
		}
		
		
		
		
	}
	
	private function addCommonShirtOptions() {
		
		
		
	}
	
	
	private function uploadStyleCodeImage() {
		
		$file = $this->request->data['CanteenProduct']['style_code_image'];
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		if(!is_uploaded_file($file['tmp_name']) || !in_array($ext,array("jpg","jpeg","png","gif"))) {
			
			return false;
			
		}
		
		$fileName = md5(time().uniqid()).".".$ext;
		
		//move the file over to the temp dir
		if(move_uploaded_file($file['tmp_name'],TMP.$fileName)) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			ImgServer::instance()->upload_product_image($fileName,TMP.$fileName);
			
			unlink(TMP.$fileName);
			
			$this->request->data['CanteenProduct']['style_code_image'] = $fileName;
			
			return true;
			
		}
		
		return false;
		
	}
	
	public function attach_inventory_record() {
		
		if(count($this->request->data)>0) {

			$this->loadModel("CanteenProductInventory");
			
			$this->CanteenProductInventory->create();
			
			die($this->CanteenProductInventory->save($this->request->data));
			
		}
		
		die(0);
	}
	
	public function detach_inventory_record() {
		
		if(count($this->request->data)>0) {
			
			$this->loadModel("CanteenProductInventory");
			
			die($this->CanteenProductInventory->delete($this->request->data['canteen_product_inventory_id']));
			
		}

		die(0);
		
	}

	
	public function ajax_inv($id) {
		
		$product = $this->CanteenProduct->returnAdminProduct($id);
		
		$this->set(compact("product"));
		
	}
	
	public function make_inventory_priority($child_id,$prod_inv_id) {
		
		//clear out all the childs
		$this->CanteenProduct->query(
			"UPDATE canteen_product_inventories SET priority=0 WHERE canteen_product_id='{$child_id}'"
		);
		
		//now update the new record as proiority
		
		$this->CanteenProduct->query(
			"UPDATE canteen_product_inventories SET priority=1 WHERE canteen_product_id='{$child_id}' AND id='{$prod_inv_id}'"
		);
		
		return $this->redirect(base64_decode($this->request->params['named']['callback']));
		
	}
	
	public function copy_pricing($source_id,$dest_id) {
		
		$this->loadModel("CanteenProductPrice");
		
		//get the source products pricing
		$sp = $this->CanteenProductPrice->find("all",array("conditions"=>array("CanteenProductPrice.canteen_product_id"=>$source_id)));
		
		foreach($sp as $p) {
			
			$chk = $this->CanteenProductPrice->find("first",array(
				"conditions"=>array(
					"CanteenProductPrice.currency_id"=>$p['CanteenProductPrice']['currency_id'],
					"CanteenProductPrice.canteen_product_id"=>$dest_id		
				)
			
			));
			
			$this->CanteenProductPrice->create();
			
			if(!empty($chk['CanteenProductPrice']['id'])) $this->CanteenProductPrice->id = $chk['CanteenProductPrice']['id'];
			
			$d = array(
				"price"=>$p['CanteenProductPrice']['price'],
				"currency_id"=>$p['CanteenProductPrice']['currency_id'],
				"canteen_product_id"=>$dest_id
			);
			
			$this->CanteenProductPrice->save($d);
			
		}
		
		return $this->redirect("/canteen_products/edit/".$dest_id."#Pricing");
		
		
	}
	
	public function copy_products($product_id) {
		
		
	}
	
	public function validate_products() {
		
		if(count($this->request->data)>0) {
			
			$conditions = array(
				"CanteenProduct.parent_canteen_product_id"=>NULL
			);
			
			$conditions['CanteenProduct.active'] = $this->request->data['CanteenProduct']['active'];
			
			if(!empty($this->request->data['CanteenProduct']['canteen_category_id'])) {
				
				$conditions['CanteenProduct.canteen_category_id'] = $this->request->data['CanteenProduct']['canteen_category_id'];
				
			}
			
			$p_ids = $this->CanteenProduct->find("all",array(
				"fields"=>array(
					"CanteenProduct.id"
				),
				"conditions"=>$conditions,
				"contain"=>array(),
			));
			
			$products = array();
			
			foreach($p_ids as $v) {
				
				$prod = $this->CanteenProduct->returnAdminProduct($v['CanteenProduct']['id']);
				
				$msg = $this->CanteenProduct->validateProduct($prod);
				
				if(count($msg)>0) {
					
					$prod['ValidateMessage'] = $msg;
					
					$products[] = $prod;
					
				}
				
			}
			
			unset($prod);
			
			$this->set(compact("products"));
		}

		$this->canteenProductSelects();
		
	}
	
	public function ljg_products($canteen_product_id = false,$filter = false) {
		
		
		
		$canteen_product = $this->CanteenProduct->returnAdminProduct($canteen_product_id);
		
		$ljg_products = $this->parse_ljg_products_file();
		
		$schema = $this->ljg_products_schema;
		
		$this->set(compact("ljg_products","schema","canteen_product","filter"));
		
		
	}
	
	public function create_ljg_inventory() {
		
		$this->loadModel("CanteenProductInventory");
		$this->loadModel("CanteenInventoryRecord");
		
		$product_id = $this->request->data['LjgInventory']['canteen_product_id'];
		
		$ljg_products = $this->parse_ljg_products_file();
		
		$keys = $this->request->data['index'];
		
		$inv_items = array();
		
		foreach($keys as $v) {
			
			$inv_items[] = $ljg_products[$v];
			
		}
		
		foreach($inv_items as $v) {
			
			$size = $v['Size'];
			$upc = $v['UPC Code'];
			
			$p = $this->CanteenProduct->find("first",array(
				"conditions"=>array(
					'CanteenProduct.parent_canteen_product_id'=>$product_id,
					'CanteenProduct.opt_value'=>$size
				),
				"contain"=>array(
					"ParentCanteenProduct"=>array(
						"Brand"
					)
				)
			));
			
			if(!empty($p['CanteenProduct']['id'])) {
				
				$record_name = $p['ParentCanteenProduct']['Brand']['name']." ".$p['ParentCanteenProduct']['name']." ".$p['ParentCanteenProduct']['sub_title']." ".$p['CanteenProduct']['opt_label']." ".$p['CanteenProduct']['opt_value'];
				
				$this->CanteenInventoryRecord->create();
				$this->CanteenInventoryRecord->save(array(
					"name"=>$record_name,
					"warehouse_id"=>2,
					"foreign_key"=>$upc,
					"quantity"=>0,
					"allocated"=>0
				));
				
				$record_id = $this->CanteenInventoryRecord->id;
				$this->CanteenProductInventory->create();
				$this->CanteenProductInventory->save(array(
					"canteen_product_id"=>$p['CanteenProduct']['id'],
					"canteen_inventory_record_id"=>$record_id,
					"priority"=>1
				));
				
			}
			
		}
		
		$this->CanteenProduct->create();
		
		$this->CanteenProduct->id = $product_id;
		
		$this->CanteenProduct->save(array(
			"ljg_inv"=>1
		));
		
		return $this->redirect(base64_decode($this->request->data['LjgInventory']['callback']));
		
		//die(pr($inv_items));
		
	}
	
	public function view_ljg_products() {
		
		$ljg_products = $this->parse_ljg_products_file();
		
		$schema = $this->ljg_products_schema;
		
		$this->set(compact("ljg_products","schema"));
		
		
	}
	
	private function parse_ljg_products_file() {
		
		$ljg_products = array();
		
		//products file
		$products_file = "/home/sites/lajolla/product.txt";
		
		$products_string = file_get_contents($products_file);
		
		$products_string = trim($products_string);
		
		$products_csv_array = explode("\n",$products_string);
		
		
		
		foreach($products_csv_array as $v) {
			
			$v = trim($v);
			
			$row = explode("\t",$v);
			
			if($ljg_products[] = @array_combine($this->ljg_products_schema,$row)) {
				
				
			} else {
				
				continue 1;
				
			}
			
		}
		
		return $ljg_products;
		
	}
	
	public function import_lajolla_inventory_file() {
	
		$this->loadModel("CanteenInventoryRecord");
		
		$this->CanteenInventoryRecord->import_ljg_inventory();
	
	}
	
	public function copy_product($id) {
		
		$product = $this->CanteenProduct->returnAdminProduct($id);
		
		//prepare CanteenProduct
		unset(
				$product['CanteenProduct']['id'],
				$product['CanteenProduct']['modified'],
				$product['CanteenProduct']['created'],
				$product['CanteenProduct']['style_code_image'],
				$product['CanteenProduct']['active']
		);
		//prepare ChildCanteenProduct
		foreach($product['ChildCanteenProduct'] as $k=>$v) {
			
			unset(
					$product['ChildCanteenProduct'][$k]['id'],
					$product['ChildCanteenProduct'][$k]['modified'],
					$product['ChildCanteenProduct'][$k]['created'],
					$product['ChildCanteenProduct'][$k]['CanteenProductInventory'],
					$product['ChildCanteenProduct'][$k]['parent_canteen_product_id']
			);
			
		}

		foreach($product['CanteenProductPrice'] as $k=>$v) {
			
			unset(
					$product['CanteenProductPrice'][$k]['id'],
					$product['CanteenProductPrice'][$k]['modified'],
					$product['CanteenProductPrice'][$k]['created']
			);
			
		}

		unset($product['CanteenProductImage']);


		//die(pr($product));

		$product['CanteenProduct']['name'] .= " COPY";

		$this->CanteenProduct->saveAll($product);
		
		$this->flash("Product Copied Successfully","/canteen_products/edit/".$this->CanteenProduct->id);
		
	}
	
	
	
}