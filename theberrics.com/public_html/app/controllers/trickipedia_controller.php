<?php

App::import("Controller","BerricsApp");


class TrickipediaController extends BerricsAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		if($this->params['action']=="view") {
			
			$this->params['action'] = "section";
			
		}

	}
	
	
	public function view() {
		
		die("You're Stupid");
		
	}
	
	public function section() {
		
		//load models
		$this->loadModel("Dailyop");
		
		//get all the active tickipedia post ids
		$trick_id_token = "trickipedia_post_ids";
		
		if(($trick_ids = Cache::read($trick_id_token,"1min")) === false) {
			
			$trick_ids = $this->Dailyop->find('all',array(
			
				"conditions"=>array(
					"Dailyop.active"=>1,
					"Dailyop.publish_date<NOW()",
					"Dailyop.dailyop_section_id"=>4
				),
				"contain"=>array(),
				"fields"=>array(
					"Dailyop.id"
				)
			
			));
			
			Cache::write($trick_id_token,$trick_ids,"1min");
			
		}
		
		$posts_token = "trickpedia_posts_cache";
		if(($posts = Cache::read($posts_token,"1min")) === false) {
			
			$posts = array();
			
			foreach($trick_ids as $id) {
				
				$post_id = $id['Dailyop']['id'];
				
				$posts[] = $this->Dailyop->returnPost(array(
					"Dailyop.id"=>$post_id
				),$this->isAdmin(),false,
				array(
			
					"DailyopMediaItem"=>array(
						"MediaFile"=>array("User"),
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
					),
					"DailyopSection",
					"Tag",
					"Meta",
					
			
				)
				);
				
			}
			
			//sort the posts
			
			$posts = Set::sort($posts,'{n}.Dailyop.publish_date','desc');
			
			Cache::write($posts_token,$posts,"1min");
			
		}
		
		if(isset($this->params['uri']) && !empty($this->params['uri'])) {
			
			$uri = $this->params['uri'];
			
		} else {
			
			$uri = $posts[0]['Dailyop']['uri'];
			
		}
		
		$video = $this->Dailyop->returnPost(array("Dailyop.uri"=>$uri,'Dailyop.dailyop_section_id'=>4),$this->isAdmin());
		
		
		$this->set(compact("posts","video"));
	}
	
	
	public function ____section() {
		
		$this->loadModel("Dailyop");
		$this->loadModel("DailyopMediaItem");
		$this->loadModel("User");
		$token = "trickipedia_list";
		
		if(($posts = Cache::read($token,"1min")) === false) {
			
			$posts = $this->Dailyop->find("all",array(
			
				"conditions"=>array(
					"Dailyop.dailyop_section_id"=>4,
					"Dailyop.publish_date < NOW()",
					"Dailyop.active"=>1
				),
				"contain"=>array(
			
					"Meta"		
				
				),
				"order"=>array(
					
					"Dailyop.publish_date"=>"DESC"
				
				)
	
			));
			
			
			$post_ids = Set::extract("/Dailyop/id",$posts);
			
			$media = $this->DailyopMediaItem->find("all",array(
				"fields"=>array("MediaFile.*","DailyopMediaItem.*"),
				"conditions"=>array(
					"DailyopMediaItem.dailyop_id"=>$post_ids
				),
				"joins"=>array(
					"INNER JOIN media_files AS `MediaFile` ON (MediaFile.id = DailyopMediaItem.media_file_id)",
					
				),
				"contain"=>array()
			));
			
			$media_ids = Set::extract("/MediaFile/id",$media);
			
			$users = $this->User->find("all",array(
				"fields"=>Array(
					"User.*","MediaFilesUser.*"
				),
				"conditions"=>array(
					"MediaFilesUser.media_file_id"=>$media_ids
				),
				"joins"=>array(
					"JOIN media_files_users AS `MediaFilesUser` ON (MediaFilesUser.user_id = User.id)"
				),
				"contain"=>array()
			
			));
			

			foreach($posts as $k=>$v) {
				
				
				$id = $v['Dailyop']['id'];
				
				$posts[$k]['DailyopMediaItem'] = $posts[$k]['User'] = array();
				
				$items = Set::extract("/DailyopMediaItem[dailyop_id={$id}]",$media);
				
				foreach($items as $key=>$item) {
					
					$posts[$k]['DailyopMediaItem'][$key] = $item['DailyopMediaItem'];
					
					$mi = Set::extract("/MediaFile[id=".$item['DailyopMediaItem']['media_file_id']."]",$media);
					
					$posts[$k]['DailyopMediaItem'][$key]['MediaFile'] = $mi[0]['MediaFile'];
					
					foreach($users as $u) {
						
						if($mi[0]['MediaFile']['id'] == $u['MediaFilesUser']['media_file_id']) {
							
							$posts[$k]['DailyopMediaItem'][$key]['MediaFile']['User'][] = $u['User'];
							
						}
						
					}
					
				}
				
				
			}
			
			
			
			Cache::write($token,$posts,"1min");
			
		}

		$this->set(compact("posts"));
		
		if(isset($this->params['uri']) && !empty($this->params['uri'])) {
			
			$uri = $this->params['uri'];
			
		} else {
			
			$uri = $posts[0]['Dailyop']['uri'];
			
		}
		
		$video = $this->Dailyop->find("first",array(
		
			"conditions"=>array(
		
				"Dailyop.uri"=>$uri,
				"Dailyop.dailyop_section_id"=>4,
				"Dailyop.publish_date < NOW()",
				"Dailyop.active"=>1
		
			),
			"contain"=>array(
		
				"DailyopMediaItem"=>array(
		
					"MediaFile"=>array("User")	
		
				),
				"Meta",
				"DailyopSection",
				"Tag"		
			
			)
		
		));
		

		$this->set(compact("video"));
		
		
	}
	
}



?>