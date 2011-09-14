<?php

App::import("Controller","AdminApp");

class CanteenProductsController extends AdminAppController {
	
	public function beforeFilter() {
		
		App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
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
				)
			),
			"conditions"=>array(
				
					"CanteenProduct.parent_canteen_product_id"=>NULL
				
			)
		
		);
		
		$products = $this->Paginate("CanteenProduct");
		
		$this->set(compact("products"));
		
	}
	
	
	public function add() {
		
		if(count($this->data)>0) {
			
			$this->fixPublishDate();
			
			$this->data['Tag'] = $this->CanteenProduct->Tag->parseTags($this->data['CanteenProduct']['tags']);
			
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
				
			}
			
			if(isset($this->data['AddNewImage'])) {
				
				$this->uploadImage();
				
			}
			
			if(isset($this->data['AddMeta'])) {
				
				$this->insertMeta();
				
			}
			
			if(isset($this->data['RemoveMeta'])) {
				
				$this->removeMeta();
				
			}
			
			$this->data['Tag'] = $this->CanteenProduct->Tag->parseTags($this->data['CanteenProduct']['tags']);
			
			$this->CanteenProduct->saveAll($this->data);
			
			
			//stuff for after the save has occured.
			if(isset($this->data['PromoteFrontImage'])) {
				
				$this->promoteFrontImage();
				
			}
			
			if(isset($this->data['PromoteThumbImage'])) {
				
				$this->promoteThumbImage();
				
			}
			
			if(isset($this->data['RemoveImage'])) {
				
				$this->removeImage();
				
			}
			
			if(isset($this->data['RemoveOption'])) {
				
				$this->removeOption();
				
			}
			
			
			return $this->flash("Product Updated Successfully","/canteen_products/edit/".$this->data['CanteenProduct']['id']);
			
		} else {
			
			$product = $this->CanteenProduct->returnAdminProduct($id);
			$this->data = $product;
		}
		
		
		$this->canteenProductSelects();
		
		
		
	}
	
	
	private function canteenProductSelects() {
		
		$this->set("canteenCategories",$this->CanteenProduct->CanteenCategory->find("list"));
		$this->set("brands",$this->CanteenProduct->Brand->find("list"));
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
				"front_image"=>0
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
			
			$this->CanteenProduct->CanteenProductOption->id = $opt_id;
			$this->CanteenProduct->CanteenProductOption->save(array(
				
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}