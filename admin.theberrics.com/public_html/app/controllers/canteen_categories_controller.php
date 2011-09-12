<?php

App::import("Controller","AdminApp");

class CanteenCategoriesController extends AdminAppController {

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
		
		if(count($this->data)>0) {
			
			if($this->CanteenCategory->save($this->data)) {
				
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
		
		if(count($this->data)) {
			
			//validate that the URL is unique
			$check = $this->CanteenCategory->find("all",array(
			
				"conditions"=>array(
					"CanteenCategory.id !="=>$this->data['CanteenCategory']['id'],
					"CanteenCategory.uri"=>$this->data['CanteenCategory']['uri']
				),
				"contain"=>array()
			
			));
			
			if(count($check)<=0) {
				
				$this->CanteenCategory->id = $this->data['CanteenCategory']['id'];
				$this->CanteenCategory->save($this->data);
			
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
			
			$this->data = $cat;
			
		}
		
		
	}
	
	public function remove($id) {
		
		$id = $this->CanteenCategory->delete($id);
		
		return $this->redirect(array("action"=>"index"));
		
	}
	
	
	
}


?>