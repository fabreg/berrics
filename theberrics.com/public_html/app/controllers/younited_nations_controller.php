<?php 

App::import("Controller","Dailyops");

class YounitedNationsController extends DailyopsController {
	
	public $uses = array("YounitedNationsEvent");
	
	public $event_id = false;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allowedActions = array();

		$this->Auth->allow("index","view","section","entry_form");

		$this->initPermissions();
		
		//set the theme up
		
		$this->theme = $this->params['section'];
		
		switch($this->theme) {
			
			case "younited-nations-3":
			
				if($this->params['action'] == "section") {
			
					$this->params['action'] = "entry_form";
					
				}
				
				$title_for_layout = "YOUnited Nations 3";
				
				$this->event_id = 4;
				
			break;
			
		}
		
		
		$this->set(compact("title_for_layout"));
		$this->set("event_id",$this->event_id);
		
	}
	
	public function entry_form() {
		
		if(count($this->data)>0) {
			
			
			
		} else {
			
			
			$this->data['YounitedNationsEntry']['country'] = $_SERVER['GEOIP_COUNTRY_CODE'];
			
		}
		
		$posse = false;
		
		if($this->Auth->user("id")) {
			
			//find the posse
			
		}
		
		$this->set(compact("posse"));
		
	}

	
	
	public function locatePosse() {
		
		
		
	}
	
	public function index() {
		
		
		
	}
	
	public function section() {
		
		
		
		
	}
	
	public function view() {
		
		
		
	}
	
	public function crews() {
		
		
		
	}
	
	public function setEvent() {
		
		
		
	}
	
}