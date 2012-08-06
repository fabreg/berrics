<?php


App::import("Controller","Dailyops"); 

class LevisController extends DailyopsController {
	
	public $uses = array("MediahuntEvent","MediahuntTask","MediahuntMediaItem");
	
	private $event_id = 2;
	
	public function beforeFilter() {
		
		if(isset($_GET['xid']) && strlen($_GET['xid'])>10) {
		
			Configure::write('Session.cookie','berricsupload');
			
			$this->Session->start($_GET['xid']);
			
		}
		
		parent::beforeFilter(true);
		
		$this->Auth->allow("*");
		
		$this->Auth->deny("tasks","handle_upload");
		
		$this->Auth->loginAction['action'] = "form";
		
		$this->initPermissions();
		
		$this->theme = "levis-511-contest";

		//die(print_r($this->Auth));
		
		//force from hash pushing shit
		if(!in_array($this->params['action'],array("section","view")) && !$this->RequestHandler->isAjax()) {
			
			$this->redirect("/".$this->params['section']."#levis=".base64_encode("/".$_GET['url']));
			
		}
		
		
		
		
	}
	
	public function section() {
		
		//get all the tasks
		$tasks = $this->MediahuntTask->find("all",array(
					"conditions"=>array(
						"MediahuntTask.mediahunt_event_id"=>$this->event_id		
					),
					"contain"=>array()
				));
		
		
		$this->set(compact("tasks"));
		
	}
	
	public function view() {
		
		
		
	}
	
	public function tasks($id = false) {
		
		//get the task
		$task = $this->MediahuntTask->find("first",array(
					"conditions"=>array(
						"MediahuntTask.id"=>$id		
					),
					"contain"=>array(
						"MediahuntMediaItem"=>array(
							"conditions"=>array(
								"MediahuntMediaItem.user_id"=>$this->Auth->user("id")		
							)		
						)			
					)
				));
		
		$this->set(compact("task"));
		
		$instagram_token = $this->Auth->user("instagram_oauth_token");
		
		if(!empty($instagram_token)) {
			
			$cache_token = "instagram_feed-".md5($instagram_token);
			
			if(($instagram_images = Cache::read($cache_token,"1min")) === false) {
				
				App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
					
				$i = InstagramApi::userInstance($instagram_token);
					
				$instagram_images = json_decode($i->instagram->getUserRecent($this->Auth->user("instagram_account_num")));
					
				Cache::write($cache_token,$instagram_images,"1min");
				
			}
			
			$this->set(compact("instagram_images"));
			
		}
		
	}
	
	private function instagram_image_request($params) {
		
		
		
		
	}
	
	public function handle_upload() {
		
		
	}
	
	public function handle_add_instagram() {
		
		
		
	}
	
	
}