<?php

App::import("Controller","Dailyops");

class NewsController extends DailyopsController {
	
	public $uses = array("Dailyop");
	
	//public $cacheAction = "1 Minute";
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		//$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->theme = "news";
		
		/*
		 * DATE STUFF VERY SKETCHY!!!!!!!!! 
		 */
			$date_in = strtotime($this->request->params['pass'][0]."-".$this->request->params['pass'][1]."-".$this->request->params['pass'][2]);
			
			if($date_in <=1) {
				
				$date_in = $this->Dailyop->getLastNewsDay();
				
				//$date_in = '2011-08-28';
			} else {
				
				$date_in = $this->request->params['pass'][0]."-".$this->request->params['pass'][1]."-".$this->request->params['pass'][2];
				
			}
			
			$this->request->params['date_in'] = $date_in;
			
			if(isset($_GET['date_in'])) {
				
				$this->request->params['date_in'] = $_GET['date_in'];
				
			}
			
			if(isset($this->request->params['named']['date_in'])) {
				
				$this->request->params['date_in'] = $this->request->params['named']['date_in'];
				
			}
		/* 
		 * END TOE DRAG 
		 */
		
		if(strtotime($this->request->params['date_in']>time() && !$this->isAdmin())) {
			
			throw new NotFoundException();
			
		}
			
	}
	
	
	public function view() {
		
		$this->set("right_column","");
		
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.dailyop_section_id"=>65,
			"Dailyop.uri"=>$this->request->params['uri']
		
		),$this->isAdmin());
		
		$this->request->params['date_in'] = date("Y-m-d",strtotime($post['Dailyop']['publish_date']));
		
		$this->unified_menu();
		$this->events_menu();
		$this->latest_menu();
		
		$this->set(compact("post"));
		
	}
	
	
	public function section() {
		

		//just get all the active news for now
		//"DATE(Dailyop.publish_date) = '{$this->request->params['date_in']}'
		
		$token = "news_section_".$this->request->params['date_in'];
		
		if(($general = Cache::read($token,"1min")) === false) {
			
			$general = $this->Dailyop->find("all",array(
		
				"conditions"=>array(
					"Dailyop.dailyop_section_id"=>65,
					"Dailyop.active"=>1,
					"Dailyop.misc_category"=>"news-general",
					"DATE(Dailyop.publish_date) = '{$this->request->params['date_in']}'"
				),
				"contain"=>array(
					"DailyopTextItem"=>array(
						"MediaFile"
					)
				),
				"order"=>array("Dailyop.display_weight"=>"ASC")
			
			));
			
			Cache::write($token,$general,"1min");
			
		}
		
		$older_date = $this->Dailyop->getNextDate($this->request->params['date_in']);
		
		$newer_date = $this->Dailyop->getNextDate($this->request->params['date_in'],false);
		
		$this->unified_menu();
		$this->events_menu();
		
		$this->set(compact("general","older_date","newer_date"));
		
	}
	
	public function unified_menu() {
		
		//"DATE(Dailyop.publish_date)<NOW()"
		$this->paginate['Dailyop'] = array(
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
			"limit"=>5,
			"order"=>array("Dailyop.display_weight"=>"ASC")
		);
		
		$this->skip_page_view = true;
		
		$this->set("unified_posts",$this->paginate("Dailyop"));
		
		if($this->request->params['isAjax']) {
			
			$this->render("/elements/news/unified_menu_element");
			
		}
		
		
	}
	
	public function events_menu($page = 1) {
		
				
		$token = "events_menu_".md5($page.$this->request->params['date_in']);
		
		
		//"DATE(Dailyop.publish_date)<NOW()"
		$this->paginate['Dailyop'] = array(
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>65,
				"Dailyop.active"=>1,
				"Dailyop.misc_category"=>"news-event",
				"DATE(Dailyop.publish_date) = '{$this->request->params['date_in']}'"
			),
			"contain"=>array(
				"UnifiedStore",
				"DailyopTextItem"
			),
			"limit"=>5,
			"order"=>array("Dailyop.display_weight"=>"ASC")
		);
		
		
		
		$this->set("event_posts",$this->paginate("Dailyop"));
		$this->set("event_posts_count",$this->request->params['paging']['Dailyop']['count']);
		
		$this->skip_page_view = true;
		
		if($this->request->params['isAjax']) {
			
			$this->render("/elements/news/events_menu");
			
		}
		
	}
	
	public function latest_menu() {
		
				
		//"DATE(Dailyop.publish_date)<NOW()"
		$this->paginate['Dailyop'] = array(
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>65,
				"Dailyop.active"=>1,
				"Dailyop.misc_category"=>"news-general",
				"DATE(Dailyop.publish_date) = '{$this->request->params['date_in']}'"
			),
			"contain"=>array(
				"UnifiedStore",
				"DailyopTextItem"
			),
			"limit"=>5,
			"order"=>array("Dailyop.display_weight"=>"ASC")
		);
		
		
		$this->set("latest_posts",$this->paginate("Dailyop"));
		
		$this->skip_page_view = true;
		
		if($this->request->params['isAjax']) {
			
			$this->render("/elements/news/latest_menu");
			
		}
		
		
	}
	
	
	
	
	
}