<?php

App::import("Controller","Dailyops");


class TrickipediaController extends DailyopsController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		if($this->request->params['action']=="view") {
			
			$this->request->params['action'] = "section";
			$this->view = "section";

		}

	}
	
	
	public function view() {
		
		throw new NotFoundException("Invalid Request");
	}
	
	public function section() {
		
		//load models
		$this->loadModel("Dailyop");

		$posts = $this->Dailyop->trickipedia_list();

		//die(pr($posts));

		//$this->render('/Elements/sql_dump');
		
		if(isset($this->request->params['uri']) && !empty($this->request->params['uri'])) {
			
			$uri = $this->request->params['uri'];
			
		} else {
			
			$uri = $posts[0]['Dailyop']['uri'];
			
		}
		
		$post = $this->Dailyop->returnPost(array("Dailyop.uri"=>$uri,'Dailyop.dailyop_section_id'=>4),$this->isAdmin());
		
		$this->setFacebookMetaData($post);
		
		$this->extractMenu($posts);

		$this->set(compact("posts","post"));

	}

	private function extractMenu($posts) {
		
		$token = "trickipedia-select-menu";

		if(($menu = Cache::read($token,"1min")) === false) {

			$menu = array();

			foreach($posts as $post) {

				//get the trick meta tag
				$trick = Set::extract("/Meta[key=/trick/i]/val",$post);

				$link = "/trickipedia/".$post['Dailyop']['uri'];

				$menu[$link] = strtoupper($trick[0]);

			}

			asort($menu);

			Cache::write($token,$menu,"1min");

		}

		$this->set("trick_menu",$menu);

		return $menu;


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
		
		if(isset($this->request->params['uri']) && !empty($this->request->params['uri'])) {
			
			$uri = $this->request->params['uri'];
			
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