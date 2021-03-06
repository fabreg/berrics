<?php

App::import("Controller","LocalApp");

class CoverPagesController extends LocalAppController {
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	
	public function index() {
		
		$this->paginate['CoverPage'] = array(
		
			"limit"=>100
		
		);
		
		//check for the category filter
		if(isset($this->request->params['named']['CoverPage.aberrica_category_id'])) {
			
			$this->paginate['CoverPage']['conditions']['CoverPage.aberrica_category_id'] = $this->request->params['named']['CoverPage.aberrica_category_id'];
			
		} else {
			
			$this->paginate['CoverPage']['conditions']['CoverPage.aberrica_category_id'] = 0;
			
		}
		
		$coverPages = $this->paginate("CoverPage");
		
		$this->set(compact("coverPages"));
		
	}
	
	public function add($aberrica_category_id = false) {
		
		$this->loadModel("AberricaCategory");
		
		if(count($this->request->data)) {
			
			
			if($this->CoverPage->save($this->request->data)) {
				
				return $this->flash("Cover Page Added Successfully",array("action"=>"edit",$this->CoverPage->id));
				
			}
			
			
		}
		
		if(isset($aberrica_category_id)) {
			
			
			
			$cat = $this->AberricaCategory->find("first",array("conditions"=>array("AberricaCategory.id"=>$aberrica_category_id)));
			
			$this->set(compact("cat"));
			
		}
		
		
		
		
	}
	
	
	public function edit($id = false) {
		
		if(count($this->request->data)) {
			
			if($this->CoverPage->save($this->request->data)) {
				
				return $this->flash("Cover Update Updated Successfully",array("action"=>"index"));
				
			}
			
		} else {
			
			
			$this->request->data = $this->CoverPage->find("first",array(
			
			
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