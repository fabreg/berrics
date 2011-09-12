<?php

App::import("Controller","AdminApp");

class CoverPagesController extends AdminAppController {
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	
	public function index() {
		
		$this->paginate['CoverPage'] = array(
		
			"limit"=>100
		
		);
		
		//check for the category filter
		if(isset($this->params['named']['CoverPage.aberrica_category_id'])) {
			
			$this->paginate['CoverPage']['conditions']['CoverPage.aberrica_category_id'] = $this->params['named']['CoverPage.aberrica_category_id'];
			
		} else {
			
			$this->paginate['CoverPage']['conditions']['CoverPage.aberrica_category_id'] = 0;
			
		}
		
		$coverPages = $this->paginate("CoverPage");
		
		$this->set(compact("coverPages"));
		
	}
	
	public function add($aberrica_category_id = false) {
		
		$this->loadModel("AberricaCategory");
		
		if(count($this->data)) {
			
			
			if($this->CoverPage->save($this->data)) {
				
				return $this->flash("Cover Page Added Successfully",array("action"=>"edit",$this->CoverPage->id));
				
			}
			
			
		}
		
		if(isset($aberrica_category_id)) {
			
			
			
			$cat = $this->AberricaCategory->find("first",array("conditions"=>array("AberricaCategory.id"=>$aberrica_category_id)));
			
			$this->set(compact("cat"));
			
		}
		
		
		
		
	}
	
	
	public function edit($id = false) {
		
		if(count($this->data)) {
			
			if($this->CoverPage->save($this->data)) {
				
				return $this->flash("Cover Update Updated Successfully",array("action"=>"index"));
				
			}
			
		} else {
			
			
			$this->data = $this->CoverPage->find("first",array(
			
			
				"conditions"=>array(
					"CoverPage.id"=>$id
				),
				"contain"=>array(
					"AberricaCategory",
					"MediaFile"
				)
			
			));
			
		}
		
		
		
	}
	
	
}


?>