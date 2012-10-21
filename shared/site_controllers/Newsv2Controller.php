<?php

App::import("Controller","Dailyops");

class Newsv2Controller extends DailyopsController {
	
	
	public $uses = array();
	
	private $section_id = 65;
	
	public function beforeFilter() {
		
	 	parent::beforeFilter();
		
	 	$this->Auth->allow();
		
	 	//force the newsv2 theme
	 	
	 	$this->theme = "newsv2";
	 	
	 	if(	!isset($this->request->params['pass'][0]) && 
			!isset($this->request->params['pass'][1]) && 
			!isset($this->request->params['pass'][2]) && $this->request->params['action'] != "view") {
	 		
	 		$this->request->params['action'] = "archive";
	 		
	 		
	 	}
	 	
	}
	
	public function archive() {
		
		$this->loadModel("Dailyop");
		
		$posts = $this->Dailyop->returnAtArchive();
		
		$this->set(compact("posts"));

		$this->set("title_for_layout","Aberrican Times Archive");
		
		$this->view = "archive";

		
	}
	
	public function section() {
		
		$this->loadModel("Dailyop");
		//check for an incoming timestamp
		if(
			isset($this->request->params['pass'][0]) && 
			isset($this->request->params['pass'][1]) && 
			isset($this->request->params['pass'][2]) &&
			(strtotime($this->request->params['pass'][0]."-".$this->request->params['pass'][1]."-".$this->request->params['pass'][2])>0)
		) {
			
			$date_in = date("Y-m-d",strtotime($this->request->params['pass'][0]."-".$this->request->params['pass'][1]."-".$this->request->params['pass'][2]));
			
		} else {
			
			//get the latest news day
			$date_in = $this->Dailyop->getLastNewsDay();
			
		}
		
		$this->request->params['date_in'] = $date_in;
		
		if((strtotime($this->request->params['date_in'])>time()) && !$this->isAdmin()) {
			
			throw new NotFoundException();
			
		}
		
		
		//conditions & sort
		$cond = array(
					"Dailyop.dailyop_section_id"=>65,
					"Dailyop.active"=>1,
					"Dailyop.misc_category"=>"news-general",
					"DATE(Dailyop.publish_date) = '{$this->request->params['date_in']}'"
				);
				
		$sort = array("Dailyop.display_weight"=>"ASC");
		
		
		
		if($this->request->params['date_in'] == '2012-01-08') {

			$cond = array(
					"Dailyop.dailyop_section_id"=>65,
					"Dailyop.active"=>1,
					"Dailyop.misc_category"=>"news-general",
					"Dailyop.best_of"=>1
				);
			
			$sort = array("Dailyop.best_of_weight"=>"ASC");
			
		}
		
		//lets gather all the news posts
		$token = "news_general_home_".$this->request->params['date_in'];
		
		if(($posts = Cache::read($token,"1min")) === false) {
			
			$posts = $this->Dailyop->find('all',array(
				
				"conditions"=>$cond,
				"contain"=>array(
					"DailyopTextItem"=>array(
						"MediaFile"
					)
				),
				"order"=>$sort
			
			));
			
			Cache::write($token,$posts,"1min");
			
		}
		
		$this->set(compact("posts"));


		//let's get the unified news and the event news
		$this->setUnified();
		
		//lets get the events
		$this->setNewsEvents();
		
		
	}
	
	
	public function view() {

		
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.uri"=>$this->request->params['uri'],
			"DailyopSection.uri"=>$this->request->params['section']	
		
		),$this->isAdmin());
		
		if(isset($post['Dailyop']['publish_date'])) {
			
			$this->request->params['date_in'] = date("Y-m-d",strtotime($post['Dailyop']['publish_date']));
			
		}
		
		$this->set(compact("post"));
		
		//set the unified news
		$this->setUnified();
		
		//set the events
		$this->setNewsEvents();
		
		if($this->request->params['uri'] == "happy-birthday-eric-koston.html") {
			
			$this->loadModel("InstagramImageItem");
			
			$instagram = $this->InstagramImageItem->returnImagesByTagRaw("happybirthdayerickoston");
			
			$this->set(compact("instagram"));
			
		}
		
		$this->view = "view";
		
	}
	
	private function setUnified() {
		
		$this->loadModel("Dailyop");
		
		//get the date in param
		$token = "news_unified_menu_".$this->request->params['date_in'];
		
		if(($unified = Cache::read($token,"1min")) === false) {
			
			$unified = $this->Dailyop->find("all",array(
			
				"conditions"=>array(
				"Dailyop.dailyop_section_id"=>65,
				"Dailyop.active"=>1,
				"Dailyop.misc_category"=>"news-unified",
				"DATE(Dailyop.publish_date) = '{$this->request->params['date_in']}'"
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
	
	private function setNewsEvents() {
		
		$this->loadModel("Dailyop");
		
		//get the date in param
		$token = "news_events_menu_".$this->request->params['date_in'];
		
		if(($event_news = Cache::read($token,"1min")) === false) {
			
			$event_news = $this->Dailyop->find("all",array(
			
				"conditions"=>array(
				"Dailyop.dailyop_section_id"=>65,
				"Dailyop.active"=>1,
				"Dailyop.misc_category"=>"news-event",
				"DATE(Dailyop.publish_date) = '{$this->request->params['date_in']}'"
			),
			"contain"=>array(
				"DailyopTextItem"
			),
			"order"=>array("Dailyop.display_weight"=>"ASC")
			));
			
			Cache::write($token,$event_news,"1min");
			
		}
		
		$this->set(compact("event_news"));
		
		return $event_news;
		
	} 
	
	private function setGeneral() {
		
		
		
	}
	
	
	
}