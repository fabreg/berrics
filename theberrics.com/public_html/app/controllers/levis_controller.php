<?php


App::import("Controller","Dailyops"); 

class LevisController extends DailyopsController {
	
	public $uses = array("MediahuntEvent","MediahuntTask","MediahuntMediaItem");
	
	public function beforeFilter() {
		
		parent::beforeFilter(true);
		
		$this->Auth->allow("*");
		
		$this->Auth->deny("upload_image");
		
		$this->Auth->loginAction['action'] = "form";
		
		$this->initPermissions();
		
		$this->theme = "levis-511-contest";
		
		$this->Session->write("here",$this->here);
		
		//die(print_r($this->Auth));
		
		//force from hash pushing shit
		if(!in_array($this->params['action'],array("section","view")) && !$this->RequestHandler->isAjax()) {
			
			$this->redirect("/".$this->params['section']."#!".$_GET['url']);
			
		}
		
	}
	
	public function section() {
		
		//get all the tasks
		$tasks = $this->MediahuntTask->find("all",array(
					"conditions"=>array(
						"MediahuntTask.mediahunt_event_id"=>2		
					),
					"contain"=>array()
				));
		
		
		$this->set(compact("tasks"));
		
	}
	
	public function view() {
		
		
		
	}
	
	public function upload_image() {
		
	
		
	}
	
	
}