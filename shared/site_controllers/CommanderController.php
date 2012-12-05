<?php

App::import("Controller","LocalApp");

class CommanderController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {

		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow();
		
		$this->theme = "commander";
		
		if($this->request->params['action'] == "section") {
			
			$this->request->params['action'] = "view";
			
		}
		
	}

	
	public function view() {
		
		$posts = $this->returnPosts();
	
		$this->view = "view";
		
	}
	
	
	public function section() {
		
		
			
	}
	
	private function returnPosts($uri = false) {
		
		$this->loadModel("Dailyop");
		
		$cond = array();
		
		//standard stuff
		$cond['Dailyop.active'] = 1;
		
		if(!$this->isAdmin()) {
			
			$cond[] = 'Dailyop.publish_date < NOW()';
			
		}
		
		
		//get the sections we are looking for
		switch($this->request->params['section']) {
			
			case "battle-commander":
				$section_id = 1;
			break;
			case "recruit":
				$section_id = 27;
			break;
			case "united-nations":
				$section_id = 39;
			break;
		}
		
		$cond['Dailyop.dailyop_section_id'] = $section_id;
		
		//cache for 1 minute
		$cache_token = "commander_".md5(serialize($cond));
		
	
		if(($posts = Cache::read($cache_token,"1min")) === false) {
			
			
			$posts = $this->Dailyop->find("all",array(
		
				"conditions"=>$cond,
				"contain"=>array(
					"DailyopMediaItem"=>array(
						"MediaFile",
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
					),
					"DailyopSection",
					"Tag"=>array(
						"User",
						"Brand"
					),
					"User"
				),
				"order"=>array("Dailyop.publish_date"=>"DESC")
			
			));
			
			//Cache::write($cache_token,$posts,"1min");
			
		}
		
		$viewing = false;
		
		if(isset($this->request->params['uri']) && !empty($this->request->params['uri'])) {
			
			foreach($posts as $k=>$v) {
				
				if($v['Dailyop']['uri'] == $this->request->params['uri']) {
					
					$viewing = $posts[$k];
					
				}
				
			}
			
		}
		
		if(!$viewing || count($viewing)<=0) {
			
			$viewing = $posts[0];
			
		}

		$years = array();

		foreach($posts as $v) $years[date("Y",strtotime($v['Dailyop']['publish_date']))][] = $v;

		$posts = $years;

		unset($years);
		
		//set the FB META TAG
		
		$fb_meta_img = "<meta property='og:image' content='http://img.theberrics.com/images/".$viewing['DailyopMediaItem'][2]['MediaFile']['file']."' />";
		
		$this->set(compact("posts","viewing","fb_meta_img"));
		return $posts;
		
	}
	
	private function menuList() {
		
		
		
	}
	
	
	
	
	
	
}



?>