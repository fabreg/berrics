<?php

App::import("Controller","LocalApp");

class CanteenCategoriesController extends LocalAppController {

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function index() {
		
		$cats = $this->CanteenCategory->find("all",array(
		
			"contain"=>array(),
			"order"=>array("CanteenCategory.lft"=>"ASC")
		
		));
		
		$this->set(compact("cats"));
		
	}
	
	
	public function add($id = false) {
		
		if(count($this->request->data)>0) {
			
			if($this->CanteenCategory->save($this->request->data)) {
				
				$this->Session->setFlash("New Category Added Successfully");
				
				$this->redirect("/canteen_categories/");
				
			}
			
		}
		
		if($id) {
			
			$cat = $this->CanteenCategory->findById($id);
			$this->set(compact("cat"));
			
		}
		
		
		
	}
	
	public function move_up($id = false, $delta = 1) {
		
		$this->CanteenCategory->id = $id;
		$this->CanteenCategory->moveup($id,abs($delta));
		$this->Session->setFlash("Category Updated");
		return $this->redirect(array("action"=>"index"));
		
	}
	
	public function move_down($id = false, $delta = 1) {
		
		$this->CanteenCategory->id = $id;
		$this->CanteenCategory->movedown($id,abs($delta));
		$this->Session->setFlash("Category Update");
		return $this->redirect(array("action"=>"index"));
		
	}
	
	
	public function addChild() {
		
		
		
	}
	
	public function edit($id = false) {
		
		if(count($this->request->data)) {
			
			//validate that the URL is unique
			$check = $this->CanteenCategory->find("all",array(
			
				"conditions"=>array(
					"CanteenCategory.id !="=>$this->request->data['CanteenCategory']['id'],
					"CanteenCategory.uri"=>$this->request->data['CanteenCategory']['uri']
				),
				"contain"=>array()
			
			));
			
			if(count($check)<=0) {
				
				$this->CanteenCategory->id = $this->request->data['CanteenCategory']['id'];
				$this->CanteenCategory->save($this->request->data);
			
				$this->Session->setFlash("Category Updated");
				return $this->redirect(array("action"=>"index"));
				
			} else {
				
				$this->CanteenCategory->validationErrors['uri'] = "The URI that you have chosen is already in use";
				
			}
			
			
		} else {
			
			$cat = $this->CanteenCategory->find("first",array(
				"conditions"=>array(
					"CanteenCategory.id"=>$id
				),
				"contain"=>array()
			));
			
			$this->request->data = $cat;
			
		}
		
		
	}
	
	public function remove($id) {
		
		$id = $this->CanteenCategory->delete($id);
		
		return $this->redirect(array("action"=>"index"));
		
	}
	
	public function sort_products($id = false) {
		
		if(!$id) throw new NotFoundException();
		
		$this->loadModel("CanteenProduct");
		
		if(count($this->request->data)>0) {
			
			
			foreach($this->request->data['CanteenProduct']['display_weight'] as $k=>$w) {
				
				$this->CanteenProduct->create();
				
				$this->CanteenProduct->id = $k;
				
				$this->CanteenProduct->save(array(
					"display_weight"=>$w
				));
				
			}
			
			return $this->flash("Sorting Updated",$this->request->here);
			
		}
		
		
		
		
		$products = $this->CanteenProduct->find("all",array(
							"conditions"=>array(
								"CanteenProduct.parent_canteen_product_id"=>NULL,
								"CanteenProduct.active"=>1,
								"CanteenProduct.featured"=>1,
								"CanteenProduct.canteen_category_id"=>$id
							),
							"contain"=>array(
								"CanteenProductImage"=>array(
									"order"=>array("CanteenProductImage.thumb_image"=>"DESC")
								),
								"Brand"
							),
							"order"=>array(
								"CanteenProduct.display_weight"=>"ASC"
							)
		));
		
		$category = $this->CanteenCategory->find("first",array(
			"conditions"=>array(
				"CanteenCategory.id"=>$id
			),
			"contain"=>array()
		));
		
		$this->set(compact("products","category"));
		
	}
	
	
	
}


?>