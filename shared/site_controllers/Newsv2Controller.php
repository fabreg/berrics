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
	 		
	 		//$this->request->params['action'] = "archive";
	 		
	 		
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
		
		$this->Paginator->settings = array(

			"Dailyop"=>array(
				"conditions"=>array(
					"Dailyop.active"=>1,
					"Dailyop.dailyop_section_id"=>65,
					"Dailyop.publish_date < NOW()"
				),
				"contain"=>array(
					"DailyopTextItem"=>array(
						"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
						"limit"=>1,
						"MediaFile"
					),
					"DailyopMediaItem"=>array(
						"MediaFile",
						"order"=>array(
							"DailyopMediaItem.display_weight"=>"ASC"
						),
						"limit"=>1
					),
					"DailyopSection",
					"Tag"=>array(
						"User",
						"Brand"
					)
				),
				"order"=>array(
					"Dailyop.publish_date"=>"DESC"
				),
				"limit"=>15

			)

		);



		$posts = $this->paginate("Dailyop");

		//die(print_r($posts));

		$this->set(compact("posts"));

	}

	public function section_endless() {
		
		$posts = $this->Dailyop->newsFeed($this->request->params['named']['datein']);

		$this->set(compact("posts"));

		if($this->request->is('ajax')) {

			$this->beforeRender();
			$this->render("/Elements/news/news-index");

		}


	}

	public function __section() {
		
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
			
			//throw new NotFoundException();
			
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
		
		if(($posts = Cache::read($token,"5min")) === false) {
			
			$posts = $this->Dailyop->find('all',array(
				
				"conditions"=>$cond,
				"contain"=>array(
					"DailyopTextItem"=>array(
						"MediaFile"
					),
					"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
					"limit"=>1
				),
				"order"=>$sort
			
			));
			
			Cache::write($token,$posts,"5min");
			
		}
		
		$this->set(compact("posts"));


		//let's get the unified news and the event news
		$this->setUnified();
		
		//lets get the events
		$this->setNewsEvents();
		
		
	}
	
	
	public function view() {

		
		$this->loadModel("Dailyop");
		
		$is_dev = preg_match('/(ADMIN|WEB2VM)/',strtoupper(php_uname('-n')));
		
		$token = "article_".md5($this->request->params['uri']);

		$post = $this->Dailyop->returnPost(array(
					
						"Dailyop.uri"=>$this->request->params['uri'],
						"DailyopSection.uri"=>$this->request->params['section']	
					
					),$this->isAdmin());
		
		if(isset($post['Dailyop']['publish_date'])) {
			
			$this->request->params['date_in'] = date("Y-m-d",strtotime($post['Dailyop']['publish_date']));
			
		}
		
		$related = $this->Dailyop->postViewRelated($post);

		$this->set(compact("post","related"));

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