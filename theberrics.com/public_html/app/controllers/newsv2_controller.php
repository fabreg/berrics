<?php

App::import("Controller","Dailyops");

class Newsv2Controller extends DailyopsController {
	
	
	public $uses = array();
	
	private $section_id = 65;
	
	public function beforeFilter() {
		
	 	parent::beforeFilter();
		
	 	$this->Auth->allow("*");
		
	 	//force the newsv2 theme
	 	
	 	$this->theme = "newsv2";
	 
	 	
	}
	
	
	public function section() {
		
		$this->loadModel("Dailyop");
		//check for an incoming timestamp
		if(
			isset($this->params['pass'][0]) && 
			isset($this->params['pass'][1]) && 
			isset($this->params['pass'][2]) &&
			(strtotime($this->params['pass'][0]."-".$this->params['pass'][1]."-".$this->params['pass'][2])>0)
		) {
			
			$date_in = date("Y-m-d",strtotime($this->params['pass'][0]."-".$this->params['pass'][1]."-".$this->params['pass'][2]));
			
		} else {
			
			//get the latest news day
			$date_in = $this->Dailyop->getLastNewsDay();
			
		}
		
		$this->params['date_in'] = $date_in;
		
		//lets gather all the news posts
		$token = "news_general_home_".$this->params['date_in'];
		
		if(($posts = Cache::read($token,"1min")) === false) {
			
			$posts = $this->Dailyop->find('all',array(
				
				"conditions"=>array(
					"Dailyop.dailyop_section_id"=>65,
					"Dailyop.active"=>1,
					"Dailyop.misc_category"=>"news-general",
					"DATE(Dailyop.publish_date) = '{$this->params['date_in']}'"
				),
				"contain"=>array(
					"DailyopTextItem"=>array(
						"MediaFile"
					)
				),
				"order"=>array("Dailyop.display_weight"=>"ASC")
			
			));
			
			Cache::write($token,$posts,"1min");
			
		}
		
		$this->set(compact("posts"));


		//let's get the unified news and the event news
		$this->setUnified();
		
		//lets get the events
		$this->setEvents();
		
		
	}
	
	public function view() {
		
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.uri"=>$this->params['uri'],
			"DailyopSection.uri"=>$this->params['section']	
		
		),$this->isAdmin());
		
		$this->set(compact("post"));
		
		//set the unified news
		$this->setUnified();
		
		//set the events
		$this->setEvents();
		
		
	}
	
	
	private function setUnified() {
		
		$this->loadModel("Dailyop");
		
		//get the date in param
		$token = "news_unified_menu_".$this->params['date_in'];
		
		if(($unified = Cache::write($token,"1min")) === false) {
			
			$unified = $this->Dailyop->find("all",array(
			
				"conditions"=>array(
				"Dailyop.dailyop_section_id"=>65,
				"Dailyop.active"=>1,
				"Dailyop.misc_category"=>"news-unified",
				"DATE(Dailyop.publish_date) = '{$this->params['date_in']}'"
			),
			"contain"=>array(
				"UnifiedStore",
				"DailyopTextItem"
			),
			"order"=>array("Dailyop.display_weight"=>"ASC")
			));
			
			Cache::write($token,$unified,"1min");
			
		}
		
		$this->set(compact("unified"));
		
		return $unified;
		
		
	}
	
	private function setEvents() {
		
		$this->loadModel("Dailyop");
		
		//get the date in param
		$token = "news_events_menu_".$this->params['date_in'];
		
		if(($events = Cache::write($token,"1min")) === false) {
			
			$events = $this->Dailyop->find("all",array(
			
				"conditions"=>array(
				"Dailyop.dailyop_section_id"=>65,
				"Dailyop.active"=>1,
				"Dailyop.misc_category"=>"news-events",
				"DATE(Dailyop.publish_date) = '{$this->params['date_in']}'"
			),
			"contain"=>array(
				"UnifiedStore",
				"DailyopTextItem"
			),
			"order"=>array("Dailyop.display_weight"=>"ASC")
			));
			
			Cache::write($token,$events,"1min");
			
		}
		
		$this->set(compact("events"));
		
		return $events;
		
	} 
	
	private function setGeneral() {
		
		
		
	}
	
	
	
}