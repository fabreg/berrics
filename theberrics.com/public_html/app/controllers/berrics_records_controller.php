<?php


App::import("Controller","BerricsApp");


class BerricsRecordsController extends BerricsAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->theme = "for-the-record";
		
		if($this->params['action'] == "view") {
			
			$this->params['action'] = "section";
			
		}
		
	}
	
	
	public function section() {
		
		if(isset($this->params['uri'])) {
			
			$this->setPost();
			
		}
		
		$records = $this->BerricsRecord->getRecords();
		
		$this->set(compact("records"));
		
	}
	
	private function setPost() {
		
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array(
			"Dailyop.uri"=>$this->params['uri'],
			"DailyopSection.uri"=>$this->params['section']
		));
		
		$this->set(compact("post"));
		
	}
	
}