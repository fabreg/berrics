<?php

App::import("Controller","LocalApp");

class DailyopsController extends LocalAppController {
	
	//public $cacheAction = "1 Minute";
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	
	public function index() {
	
		//FIX SEARCH ENGINES!!!!
		if(isset($_GET['page'])) {
			
			return $this->redirect("/dailyops",301,true);
			
		}
		
		
		$conditions = array(
							"Dailyop.active"=>1,
							"Dailyop.publish_date <= NOW()",
							"Dailyop.hidden"=>0
						);
		$limit = 10;
		$home_page = false;
		
				
		//let's check for the date
		$dateIn = false;
		
		//is there an incoming date?
		if(isset($this->params['year']) && isset($this->params['month']) && isset($this->params['day'])) {
			
			$dateIn = date("Y-m-d",strtotime($this->params['year']."-".$this->params['month']."-".$this->params['day']));
			
			$conditions = array(
			
				"DATE(Dailyop.publish_date) = '{$dateIn}'",
				"Dailyop.active"=>1,
				"Dailyop.publish_date <= NOW()",
				"Dailyop.hidden"=>0
				
			);
			
			$limit = 100;
			
		} else {
			
			$dateIn = date("Y-m-d",time());
			
			//$dateIn = $this->Dailyop->getNextDate($dateIn);
			
			$home_page = true;
			$batb_mode = false;
			if(in_array(date("Y-m-d"),array("2012-05-21","2012-05-19"))) { 
				
				$batb_mode = true;
				
			}
			
			switch($dateIn) {
	
				default:
					
					$conditions[] = "DATE(Dailyop.publish_date) = '$dateIn'";
					
				break;
				
			}
	
		}
		
		
		$dailyops = $this->Dailyop->find("all",array(
		
			"contain"=>array(
				"User",
				"Tag"=>array("User"),
				"DailyopSection",
				"DailyopMediaItem"=>array("MediaFile","order"=>array("DailyopMediaItem.display_weight"=>"ASC"),"limit"=>1)
			),
			"order"=>array("Dailyop.publish_date"=>"DESC"),
			"limit"=>$limit,
			"conditions"=>$conditions
		
		));
		
		
		
		if($home_page && count($dailyops)<3 && !$batb_mode) {
			
			//let's get yesterdays posts
			//$yesterday = date("Y-m-d",strtotime("-2 Day",strtotime($dateIn)));
			
			//let's get the next post day based on a post that is in scope
			$dateCond = $this->Dailyop->getNextDate($dateIn,true);
			
			$yd = $this->Dailyop->find("all",array(
				
					"contain"=>array(
						"User",
						"Tag"=>array("User"),
						"DailyopSection",
						"DailyopMediaItem"=>array("MediaFile","order"=>array("DailyopMediaItem.display_weight"=>"ASC"),"limit"=>1)
					),
					"order"=>array("Dailyop.publish_date"=>"DESC"),
					"conditions"=>array(
						"DATE(Dailyop.publish_date) = '{$dateCond}'",
						"Dailyop.publish_date < NOW()",
						"Dailyop.active"=>1,
						"Dailyop.hidden"=>0
						
					)

				));
			
		
			foreach($yd as $d) $dailyops[] = $d;
		
		}
		if(count($dailyops)<=0) {
			
			return $this->cakeError("error404");
			
		}
		
		
		
		//if we got a dateIn, let's get all the tags for meta_keywords
		if($dateIn!=false) {
			
			$mK = array();
			
			foreach($dailyops as $d) {
				
				foreach($d['Tag'] as $t) {
					
					$mK[$t['slug']] = $t['name'];
					
				}
				
			}
			
			$meta_k = implode(",",$mK);
			
		}
		

		$date_nav_array = $this->get_full_date_nav();
		
		//check for a theme override
		$theme_override = false;
		
		foreach($dailyops as $post) {
			
			if(!empty($post['Dailyop']['theme_override'])) {
				
				$theme_override = $post['Dailyop']['theme_override'];
				
			}
			
		}
		
		if($theme_override) {
			
			$this->theme = $theme_override;
			
		}
		
		$dateIn = $dailyops[0]['Dailyop']['publish_date'];
		
		$dateArg = date("Y-m-d",strtotime($dateIn));
		
		$older_date = $this->Dailyop->getNextDate($dateArg);
		
		$newer_date = $this->Dailyop->getNextDate($dateArg,false);
		
		$this->set(compact("dailyops","dateIn","meta_k","newer_date","older_date"));
		
		$this->setRssFeed();

		//do a get theme override
		if($home_page && isset($_GET['wheelbite']) && is_dir(WWW_ROOT."theme/".$_GET['wheelbite'])) {
			
			$this->theme = $_GET['wheelbite'];
			
		}
		
		
		//get the additional yn3 posts
		if(preg_match("/^(\/dailyops)/",$_SERVER['REQUEST_URI'])) {
			
			switch(date("Y-m-d")) {
				
				case "2012-04-20":
				case "2012-04-26":
				case "2012-04-27":
				case "2012-05-03":
				case "2012-05-04":
					$dateSeed = strtotime("-2 Days");
					
					$dateArg = date("Y-m-d",$dateSeed);
					
					$yp = $this->Dailyop->find("all",array(
						"conditions"=>array(
							"Dailyop.active"=>1,
							"Dailyop.hidden"=>0,
							"Dailyop.dailyop_section_id"=>66,
							"DATE(Dailyop.publish_date) < '{$dateArg}'"
						),
						"contain"=>array(),
						"order"=>array("Dailyop.publish_date"=>"DESC")
					));
					
					
					foreach($yp as $v) {
						
						$yn3[] = $this->Dailyop->returnPost(array("Dailyop.id"=>$v['Dailyop']['id']));
						
					}
					
					$this->set(compact("yn3"));
					
					break;
				
				
			}
			
		}
		

	}
	
	
	private function setRssFeed() {
		
		$rss_feed = "<link rel='alternate' type='application/rss+xml' title='The Berrics - The DailyOps' href='/dailyops/rss/' />";
		
		$this->set(compact("rss_feed"));
		
	}
	
	protected function setFacebookMetaData($post) {
		
		//set the image
		$mediaFile = $post['DailyopMediaItem'][0]['MediaFile'];
		$img = '';
		
		switch($mediaFile['media_type']) {
			
			case "bcove":
				$img = "/video/stills/".$mediaFile['file_video_still'];
			break;
			default:
				$img = "/images/".$mediaFile['file'];
			break;
		}
		
		$img = "http://img.theberrics.com".$img;
		
		$fb_meta_img = "<meta property='og:image' content='{$img}' />";
		
		$title = addslashes($post['Dailyop']['name']);
		
		if(!empty($post['Dailyop']['sub_title'])) $title .=" ".stripslashes($post['Dailyop']['sub_title']);
		
		//$fb_meta_img .= "<meta property='og:title' content='The Berrics - {$title}' />";	
		
		
		$this->set(compact("fb_meta_img"));
		
		
		
	}
	
	protected function setFacebookMetaImg($mediaFile) {
		
		$img = '';
		
		switch($mediaFile['media_type']) {
			
			case "bcove":
				$img = "/video/stills/".$mediaFile['file_video_still'];
			break;
			default:
				$img = "/images/".$mediaFile['file'];
			break;
		}
		
		$img = "http://img.theberrics.com".$img;
		
		$fb_meta_img = "<meta property='og:image' content='{$img}' />";
		
			
		$this->set(compact("fb_meta_img"));
		
		
	}
	
	
	public function view() {
		
		$this->loadModel("DailyopSection");
		
		$entry = $this->Dailyop->returnPost(array(
		
			"DailyopSection.uri"=>$this->params['section'],
			"Dailyop.uri"=>$this->params['uri']
		
		),$this->isAdmin());
		
		if(!$entry) {
			
			return $this->cakeError("error404");
			
		}
		
		$sections = $this->DailyopSection->returnSections();
		
		$section = Set::extract("/DailyopSection[uri=".$this->params['section']."]/id",$sections);

		$section_id = $section[0];

		//get the rest of the post from this category from the same month/year
		
		$posts = $this->Dailyop->returnPostsByMonth($entry['Dailyop']['publish_date'],$entry['Dailyop']['dailyop_section_id'],$entry['Dailyop']['id']);
		
		
		//let's get the media item we want to show on facebook
		if(isset($entry['DailyopMediaItem'][0]['MediaFile'])) {
			
			//$this->setFacebookMetaImg($entry['DailyopMediaItem'][0]['MediaFile']);
			
		}
		
		$this->setFacebookMetaData($entry);
		
		$this->set(compact("entry","posts"));
		
		
		//set the title of the page
		
		$this->set("title_for_layout",stripslashes($entry['Dailyop']['name']." ".$entry['Dailyop']['sub_title']));
		
		//build a list of tags for meta_k
		
		$k = array();
		
		foreach($entry['Tag'] as $t) {
			
			$k[] = $t['name'];
			
		}
		
		if(count($k)>0) {
			
			$meta_k = implode(",",$k);
			
			$this->set(compact("meta_k"));
			
		}
		
		$this->setRssFeed();
	
		
	}
	
	public function section($year = false, $auto_render = true,$legacy = false) {
		
		$sections = $this->Dailyop->DailyopSection->returnSections();
		
		$section_uri = $this->params['section'];
				
		$section = Set::extract("/DailyopSection[uri={$section_uri}]",$sections);
		
		$section=$section[0]['DailyopSection'];
		
		if(!$year || !preg_match('/[0-9]{4}/',$year)) {
			
			$year = $this->Dailyop->getLatestYear($section['id']);
			
		}
		
		$this->set(compact("year"));
		
		if(!empty($section['uri'])) {
			
			$this->theme = $section['uri'];
			
		}
		
		$cache_token = "section_".$section['id']."_".$year;
				
		if(($posts = Cache::read($cache_token,"1min")) === false) {
				
				$kw = array();	
			
				$this->Dailyop->virtualFields = array(
				
					"month_token"=>"MONTH(Dailyop.publish_date)"
				
				);
			
				//get the posts for the month
				$posts = $this->Dailyop->find("all",array(
					
					"conditions"=>array(
						"Dailyop.dailyop_section_id"=>$section['id'],
						"Dailyop.active"=>1,
						"Dailyop.publish_date < NOW()",
						"YEAR(Dailyop.publish_date) = '{$year}'"
						
					),
					"contain"=>array(
					
						"DailyopMediaItem"=>array(
						
							"MediaFile",
							"order"=>array(
								"DailyopMediaItem.display_weight"=>"ASC"
							),
							"limit"=>1
					
						),
						"Tag"
					
					),
					"order"=>array(
						"Dailyop.publish_date"=>"DESC"
					)
				
				));
				
				$months = array();
				
				foreach($posts as $post) { 
					
					foreach($post['Tag'] as $t) $kw[$t['name']] = $t['name'];
					
					$post['DailyopSection'] = $section;
					$months[date("m",strtotime("{$year}-".$post['Dailyop']['month_token']."-01"))][] = $post;
					
				}
				
				$posts = $months;
				$posts['Keywords'] = $kw;
				Cache::write($cache_token,$posts,"1min");
			
		}
		
		
		
		//do the title for the layout and some key words
		$title_for_layout = $section['name'];
		$meta_k = implode(",",$posts['Keywords']);
		unset($posts['Keywords']);
		
		$this->set(compact("meta_k","title_for_layout"));
		
		if($auto_render) {
			
			//get the view that we are suppose to be using
			if(empty($section['section_view_override']) || !array_key_exists($section['section_view_override'],Arr::sectionViewOverrides())) {
				
				$ctp = "section";
				
			} else {
				
				$ctp = $section['section_view_override'];
				
			}
			
			////let's check if we need more data for a custom view
			switch($ctp) {
				
				case "firstpost":
				case "firstpost2":
				case "firstpost3":
					$this->set("first_post",$this->Dailyop->returnLatestPostBySection($section['id'],$year));
				break;
				
			}
			
			
			//get the available years 
			
			$years = $this->Dailyop->getYearsBySection($section['id']);
			
			$this->set(compact("section","posts","year_in","years")); 
			
			return $this->render("/dailyops/{$ctp}");
			
		} else {
			
			return compact("section","posts");
			
		}

		
	}
	
	
	public function rss() {
		
		//get the pots
		
		$posts = $this->Dailyop->find("all",array(

			"contain"=>array(
				"User",
				"Tag",
				"DailyopSection",
				"DailyopMediaItem"=>array("MediaFile","order"=>array("DailyopMediaItem.display_weight"=>"ASC"),"limit"=>1)
			),
			"order"=>array("Dailyop.publish_date"=>"DESC"),
			"limit"=>50,
			"conditions"=>array(
				"Dailyop.active"=>1,
				"Dailyop.publish_date < NOW()"
			)
		
		));
		
		
		$title_for_feed = "The DailyOps - The Berrics";
		$link_for_feed = "http://".$_SERVER['SERVER_NAME']."/dailyops";
		
		$this->layout = "rss/rss";
		
		$this->set(compact("posts","title_for_feed","link_for_feed"));
		
		
	}
	
	public function get_months_in_year($options = array()) {
		
		$cond = array(
			"YEAR(Dailyop.publish_date) >="=>2007,
			"Dailyop.active"=>1,
			"Dailyop.publish_date < NOW()"
		);
		
		if(isset($options['dailyop_section_id'])) {
			
			$cond['Dailyop.dailyop_section_id'] = $options['dailyop_section_id'];
			
		}
		
		$cache_token = "dop_section_months_".md5(serialize($cond));
		
		if(($months = Cache::read($cache_token,"1min")) === false) {
			
				$months = $this->Dailyop->find("all",array(
					"fields"=>array(
						"DISTINCT(MONTH(Dailyop.publish_date)) AS `Month`",
						"YEAR(Dailyop.publish_date) AS `Year`"
					),
					"conditions"=>$cond,
					"contain"=>array()
				
				));
		
				Cache::write($cache_token,$months,"1min");
	
		}
		
		$m = array();
		
		foreach($months as $month) $m[$month[0]['Year']][] = $month[0]['Month'];
	
		return $m;

	}
	
	private function get_latest_month($section_id = false) {
		
		$cond = array(
						"Dailyop.publish_date < NOW()",
						"Dailyop.active"=>1
					);
					
		if($section_id) {
			
			$cond["Dailyop.dailyop_section_id"] = $section_id;
			
		}
		
		$cache_token = "section_month_check_".$section_id;
		
		if(($check = Cache::read($cache_token,"1min")) === false) {
			
				$check = $this->Dailyop->find("first",array(
			
					"fields"=>array(
						"MONTH(Dailyop.publish_date) AS `m`",
						"YEAR(Dailyop.publish_date) AS `y`"
						
					),
					"conditions"=>$cond,
					"contain"=>array(),
					"order"=>array(
						"Dailyop.publish_date"=>"DESC"
					),
					"limit"=>1
				
				));
				
				
				Cache::write($cache_token,$check,"1min");
				
				
		}
		

		
		return $check[0];
		
	}
	
	private function get_next_prev_days($date = false) {
		
		
		
	}
	
	
	public function get_full_date_nav() {
		
		$cache_token = "full_date_nav";
		
		if(($date = Cache::read($cache_token,"1min")) === false) {
			
			$dates = $this->Dailyop->find("all",array(
		
				"fields"=>array(
					"YEAR(Dailyop.publish_date) AS `y`",
					"MONTH(Dailyop.publish_date) AS `m`",
					"DAY(Dailyop.publish_date) AS `d`"
				),
				"conditions"=>array(
					"Dailyop.publish_date < NOW()",
					"Dailyop.active"=>1,
					"Dailyop.hidden"=>0
				),
				"group"=>array(
					"d","m","y"
				),
				"order"=>array(
					"y"=>"DESC","m"=>"DESC","d"=>"DESC"
				),
				"contain"=>array()
			
			));
			
			$date = array();
			
			foreach($dates as $v) $date[$v[0]['y']][$v[0]['m']][] = $v[0]['d'];
			
			Cache::write($cache_token,$date,"1min");
			
			
		}
		
		$this->set("date_nav_array",$date);
		
		return $date;
		
	}
	
	
	public function get_available_days() {
		
		
	}
	
	
	public function legacy() {
		
		$id = $_GET['postid'];
		
		$post = $this->Dailyop->find("first",array(
		
			"conditions"=>array(
				"Dailyop.legacy_id"=>$id
			),
			"contain"=>array(
				"DailyopSection"
			)
		
		));
		
		$uri = "/".$post['DailyopSection']['uri']."/".$post['Dailyop']['uri'];
		
		return $this->redirect($uri);
		
		//now redirect
		//return $this->redirect(date("/Y/m/d/",strtotime($post['Dailyop']['publish_date'])).$post['Dailyop']['uri']);
		
		
	}
	
	public function related($dailyop_id = false) {
		
		$related = $this->Dailyop->getRelatedPosts($dailyop_id);
		
		$this->set($related);
		
		$this->render("/elements/related/dailyops-related");
		
	}
	
	public function ajax_emotw_paginator($dailyop_id = false) {
		
		$this->loadModel("DailyopTextItem");
		
		$this->paginate['DailyopTextItem'] = array(
		
			"conditions"=>array(
				"DailyopTextItem.dailyop_id"=>$dailyop_id
			),
			"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
			"limit"=>1,
			"contain"=>array(
				"MediaFile"
			)
		
		);
		
		$item = $this->paginate("DailyopTextItem");
		
		$this->set(compact("item"));
		
		
	}
	
	//slide show methods
	function ajax_slideshow($dailyop_id = false,$img_weight = false,$direction = "next") {
		
		//do we have the correct data coming in?
		if(!$dailyop_id || !$img_weight) {
			
			die('0');
			
		}
		
		$this->loadModel("DailyopMediaItem");
		
		$cache_token = "dailyop_slide_show_".$dailyop_id."_".$img_weight;
		
		
		if(($items = Cache::read($cache_token,"1min")) === false) {
			
				$items = $this->DailyopMediaItem->find("neighbors",array(
					"field"=>"DailyopMediaItem.display_weight",
					"value"=>$img_weight,
					"order"=>array(
						"DailyopMediaItem.display_weight"=>"ASC"
					),
					"conditions"=>array(
						"DailyopMediaItem.dailyop_id"=>$dailyop_id
					),
					"contain"=>array("MediaFile")
					
				));
				
				Cache::write($cache_token,$items,"1min");
					
		}
		
		//check to see if we have an available item
		if($items[$direction] == null) die('0');
		
		$data = $items[$direction];
		
		
		//$data = $this->params;
		
		$this->set(compact("data"));
		
	}
	
	
	
}


?>