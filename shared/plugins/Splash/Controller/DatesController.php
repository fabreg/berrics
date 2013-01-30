<?php

App::uses("SplashAppController","Splash.Controller");

class DatesController extends SplashAppController {
	
	
	public $uses = array("SplashDate");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['SplashDate'] = array(

				"order"=>array(
					"SplashDate.publish_date"=>"DESC"		
				),
				"limit"=>50,
				"contain"=>array("SplashCreative")
				
		);
		
		$dates = $this->paginate("SplashDate");
		
		$this->set(compact("dates"));
		
	}
	
	
	public function add() {
		
		
		
	}
	
	public function edit($date_in = false) {
		
		if($this->request->is("post")) {
			
			$this->SplashDate->create();
			
			$this->SplashDate->save($this->request->data);
			
			$this->Session->setFlash("Splash creative attached");
			
			$this->redirect($this->here);
			
		}
		
		$dates = $this->SplashDate->findAllByPublishDate($date_in);
		
		$this->set(compact("date_in","dates"));
		
	}
	
	public function delete($id = false) {
		
		
		$this->SplashDate->delete($id);
		
		
		$this->redirect(base64_decode($this->request->params['named']['cb']));
		
		
	}
	
}