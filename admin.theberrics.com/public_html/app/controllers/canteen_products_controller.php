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
				'Long Desc',
				'Technical Desc'
		
	);
	
	public function beforeFilter() {
		
		App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}	
	

	public function filter() {
		
		if(count($this->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"s"=>true
				);
				
				
				foreach($this->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						$url[$k.".".$kk]=$vv;
						
					}
					
				}
				
				return $this->redirect($url);
				
		}
		
		
	}
	
	
	public function index() {
		
		$this->paginate['CanteenProduct'] = array(
		
			"contain"=>array(
				"CanteenCategory",
				"CanteenProductImage"=>array(
					"order"=>array(
						"CanteenProductImage.front_image"=>"DESC",
						"CanteenProductImage.display_weight"=>"ASC"
					),
					"limit"=>1
				),
				"Brand"
			),
			"conditions"=>array(
				
					"CanteenProduct.parent_canteen_product_id"=>NULL
				
			),
			"order"=>array("CanteenProduct.created"=>"DESC")
		
		);
		
		if(isset($this->params['named']['s'])) {

			if(isset($this->params['named']['CanteenProduct.canteen_category_id'])) {
				
				$this->paginate['CanteenProduct']['conditions']['CanteenProduct.canteen_category_id'] = 
				$this->data['CanteenProduct']['canteen_category_id'] = 
				$this->params['named']['CanteenProduct.canteen_category_id'];
				
			}
			if(isset($this->params['named']['CanteenProduct.brand_id'])) {
				
				$this->paginate['CanteenProduct']['conditions']['CanteenProduct.brand_id'] = 
				$this->data['CanteenProduct']['brand_id'] = 
				$this->params['named']['CanteenProduct.brand_id'];
				
			}
			if(isset($this->params['named']['CanteenProduct.active'])) {
				
				$this->paginate['CanteenProduct']['conditions']['CanteenProduct.active'] = 
				$this->data['CanteenProduct']['active'] = 
				$this->params['named']['CanteenProduct.active'];
				
			}
			if(isset($this->params['named']['CanteenProduct.featured'])) {
				
				$this->paginate['CanteenProduct']['conditions']['CanteenProduct.featured'] = 
				$this->data['CanteenProduct']['featured'] = 
				$this->params['named']['CanteenProduct.featured'];
				
			}
			
		} else {
			
			$this->data['CanteenProduct']['active'] = $this->data['CanteenProduct']['featured'] = 1;
			
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
		
		$url = base64_decode($this->params['named']['callback']);
		
		return $this->redirect($url);
		
	}
	
	
	public function add() {
		
		if(count($this->data)>0) {
			
			$this->fixPublishDate();
			
			$this->data['Tag'] = $this->CanteenProduct->Tag->parseTags($this->data['CanteenProduct']['tags']);
			
			if(empty($this->data['CanteenProduct']['uri'])) {
				
				$brand = $this->CanteenProduct->Brand->find("first",array(
					"conditions"=>array("Brand.id"=>$this->data['CanteenProduct']['brand_id']),
					"contain"=>array()
				));
				
				$ustr = $brand['Brand']['name']." ".$this->data['CanteenProduct']['name']." ".$this->data['CanteenProduct']['sub_title'];
				
				$this->data['CanteenProduct']['uri'] = Tools::safeUrl($ustr).".html";
				
			}
			
			$this->data['CanteenProduct']['display_weight'] = 99;			
			$this->CanteenProduct->save($this->data);
			
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
			
			$this->data['CanteenProduct']['pub_date'] = date("Y-m-d",strtotime("+30 Day"));
			$this->data['CanteenProduct']['pub_time'] = "00:00";			
			
		}
		
		$this->canteenProductSelects();
		
		
	}
	
	public function edit($id = false) {
		
		if(count($this->data)>0) {
			
			$this->fixPublishDate();
			
			if(isset($this->data['AddNewOption'])) {
				
				$this->CanteenProduct->addNewOption($this->data);
				
				$this->updateHash = "#Options %26 Inventory";
				
			}
			
			if(isset($this->data['AddCommonShirtOptions'])) {
				
				$this->CanteenProduct->addCommonShirtOptions($this->data);
				
				$this->updateHash = "#Options %26 Inventory";
				
			}
			
			
			
			if(isset($this->data['AddNewImage'])) {
				
				$this->uploadImage();
				
				$this->updateHash = "#Images";
				
			}
			
			if(isset($this->data['AddMeta'])) {
				
				$this->insertMeta();
				
				$this->updateHash = "#Meta Data";
				
			}
			
			if(isset($this->data['RemoveMeta'])) {
				
				$this->removeMeta();
				
				$this->updateHash = "#Meta Data";
				
			}
			
			$this->data['Tag'] = $this->CanteenProduct->Tag->parseTags($this->data['CanteenProduct']['tags']);
			
			if(!is_uploaded_file($this->data['CanteenProduct']['style_code_image']['tmp_name'])) unset($this->data['CanteenProduct']['style_code_image']);
			
			if(isset($this->data['UploadStyleCodeImage'])) {
				
				$this->uploadStyleCodeImage();
				
			}
			
			$this->CanteenProduct->saveAll($this->data);
			
			
			//stuff for after the save has occured.
			if(isset($this->data['PromoteFrontImage'])) {
				
				$this->promoteFrontImage();
				
				$this->updateHash = "#Images";
			}
			
			if(isset($this->data['PromoteThumbImage'])) {
				
				$this->promoteThumbImage();
				
				$this->updateHash = "#Images";
			}
			
			if(isset($this->data['RemoveImage'])) {
				
				$this->removeImage();
				
				$this->updateHash = "#Images";
			}
			
			if(isset($this->data['RemoveOption'])) {
				
				$this->removeOption();
				$this->updateHash = "#Options %26 Inventory";
			}
			
			if(isset($this->data['UpdateOptions'])) {
				
				
				$this->updateHash = "#Options %26 Inventory";
			}
	
			return $this->flash("Product Updated Successfully","/canteen_products/edit/".$this->data['CanteenProduct']['id']."/c:".time().$this->updateHash);
			
		} else {
			
			$product = $this->CanteenProduct->returnAdminProduct($id);
			$this->data = $product;
		}
		
		
		$this->canteenProductSelects();
		
		
		
	}
	
	
	private function canteenProductSelects() {
		
		//$this->set("canteenCategories",$this->CanteenProduct->CanteenCategory->find("list"));
		$this->set("canteenCategories",$this->CanteenProduct->CanteenCategory->treeList());
		$this->set("brands",$this->CanteenProduct->Brand->find("list",array("order"=>array("Brand.name"=>"ASC"))));
		
		$this->set("currencies",$this->CanteenProduct->CanteenProductPrice->Currency->find("list",array("order"=>array("Currency.name"=>"ASC"))));
		
	}
	
	
	private function fixPublishDate() {
		
		if(isset($this->data['CanteenProduct']['pub_date']) && isset($this->data['CanteenProduct']['pub_time'])) {
			
			$this->data['CanteenProduct']['publish_date']  = $this->data['CanteenProduct']['pub_date']." ".$this->data['CanteenProduct']['pub_time'].":00";
			
		} else {
			
			unset($this->data['CanteenProduct']['publish_date']);
			
		}
		
	}
	
	private function uploadImage() {
		
		$file = $this->data['CanteenProduct']['AddImage'];
		
		if(is_uploaded_file($file['tmp_name'])) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
			
			$fileName = md5(time()).mt_rand(100,1000).".".$ext;
			
			move_uploaded_file($file['tmp_name'],TMP.$fileName);
			
			ImgServer::instance()->upload_product_image($fileName,TMP.$fileName);
			
			unlink(TMP.$fileName);
			
			$this->data['CanteenProductImage'][] = array(
				"file_name"=>$fileName
			);
			
		}
		
		
		
	}
	
	private function promoteFrontImage() {
		
		$prod_id = $this->data['CanteenProduct']['id'];
		
		//demote all the images
		
		$this->CanteenProduct->CanteenProductImage->updateAll(
			array(
				"front_image"=>0
			),
			array(
				"canteen_product_id"=>$prod_id
			)
		);
		
		foreach($this->data['PromoteFrontImage'] as $k=>$v) {
			
			$image_id = $k;
			
		}
		
		
		$this->CanteenProduct->CanteenProductImage->create();
		$this->CanteenProduct->CanteenProductImage->id = $image_id;
		
		$this->CanteenProduct->CanteenProductImage->save(array(
		
			"front_image"=>1
		
		));

		
	}
	
	private function promoteThumbImage() {
		
		$prod_id = $this->data['CanteenProduct']['id'];
		
		//demote all the images
		
		$this->CanteenProduct->CanteenProductImage->updateAll(
			array(
				"thumb_image"=>0
			),
			array(
				"canteen_product_id"=>$prod_id
			)
		);
		
		foreach($this->data['PromoteThumbImage'] as $k=>$v) {
			
			$image_id = $k;
			
		}
		
		
		$this->CanteenProduct->CanteenProductImage->create();
		$this->CanteenProduct->CanteenProductImage->id = $image_id;
		
		$this->CanteenProduct->CanteenProductImage->save(array(
		
			"thumb_image"=>1
		
		));
		
		
		
	}
	
	private function removeImage() {
		
		foreach($this->data['RemoveImage'] as $k=>$v) {
			
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
		
		foreach($this->data['RemoveOption'] as $k=>$v) {
			
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
		
		$id = $this->CanteenProduct->Meta->addMeta($this->data['NewMetaKey'],$this->data['NewMetaVal']);
		
		$this->data['Meta'][] = $id;
		
		
	}
	
	private function removeMeta() {
		
		foreach($this->data['RemoveMeta'] as $k=>$v) {
			
			$id = $k;
			
		}
		
		
		foreach($this->data['Meta'] as $k=>$v) {
				
				if($id == $v) {
					
					unset($this->data['Meta'][$k]);
					
				}
				
		}	
		
		if(count($this->data['Meta'])<=0) {
			
			$this->data['Meta'][] = null;
			
		}
		
		
		
		
	}
	
	private function addCommonShirtOptions() {
		
		
		
	}
	
	
	private function uploadStyleCodeImage() {
		
		$file = $this->data['CanteenProduct']['style_code_image'];
		
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
			
			$this->data['CanteenProduct']['style_code_image'] = $fileName;
			
			return true;
			
		}
		
		return false;
		
	}
	
	public function attach_inventory_record() {
		
		if(count($this->data)>0) {

			$this->loadModel("CanteenProductInventory");
			
			$this->CanteenProductInventory->create();
			
			die($this->CanteenProductInventory->save($this->data));
			
		}
		
		die(0);
	}
	
	public function detach_inventory_record() {
		
		if(count($this->data)>0) {
			
			$this->loadModel("CanteenProductInventory");
			
			die($this->CanteenProductInventory->delete($this->data['canteen_product_inventory_id']));
			
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
		
		return $this->redirect(base64_decode($this->params['named']['callback']));
		
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
	
	public function ljg_products($canteen_product_id = false,$filter = false) {
		
		
		
		$canteen_product = $this->CanteenProduct->returnAdminProduct($canteen_product_id);
		
		$ljg_products = $this->parse_ljg_products_file();
		
		$schema = $this->ljg_products_schema;
		
		$this->set(compact("ljg_products","schema","canteen_product","filter"));
		
		
	}
	
	public function create_ljg_inventory() {
		
		$this->loadModel("CanteenProductInventory");
		$this->loadModel("CanteenInventoryRecord");
		
		$product_id = $this->data['LjgInventory']['canteen_product_id'];
		
		$ljg_products = $this->parse_ljg_products_file();
		
		$keys = $this->data['index'];
		
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
					"foreign_key"=>$upc
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
		
		return $this->redirect(base64_decode($this->data['LjgInventory']['callback']));
		
		//die(pr($inv_items));
		
	}
	
	private function parse_ljg_products_file() {
		
		$ljg_products = array();
		
		//products file
		$products_file = WWW_ROOT."lajolla/15_CTWEB_product.txt";
		
		$products_string = file_get_contents($products_file);
		
		$products_csv_array = explode("\n",$products_string);
		
		array_pop($products_csv_array);
		
		foreach($products_csv_array as $v) {
			
			$row = explode("\t",$v);
			
			array_pop($row);
			
			if($ljg_products[] = array_combine($this->ljg_products_schema,$row)) {
				
				
			} else {
				
				die(pr($row));
				
			}
			
		}
		
		return $ljg_products;
		
	}
	
	
}