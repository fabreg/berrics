<?php

App::import("Controller","BerricsApp");

class TheotisController extends BerricsAppController {
	
	
	public $uses = array();
	
	private $user_contest_id = 1;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		//force "view" request to go to "Section"
		if($this->params['action'] == "view") {
			
			$this->params['action'] = "section";
			
		}
		
		$this->theme = "31-days-of-theotis";
		
		$this->set("title_for_layout","Skull Candy Presents: 31 Days of Theotis");
		
	}
	
	public function section() {

		//get all the theostis posts
		$this->getPosts();
		
		if(isset($this->params['uri']) && !empty($this->params['uri'])) {
			
			$this->setViewPost();
			
		}
		
		
	}
	
	public function view() {
		
		
		
	}
	
	public function found() {
		
		//verify that shit!
		$cipher = $this->verifyCipher();
		
		$this->set(compact("cipher"));
		
		//aight, let's show them the button!
		
	}
	
	public function thanks($cipher = false) {
		
		if($cipher) $this->data['UserContest'][$this->Session->id()] = $cipher; 
		
		$cipher = $this->verifyCipher();
		
	}
	/**
	 * 
	 * STUB METHOD TO BUILD A COMPACT HASH TO SEND TO FACEBOOK AS A PAYLOAD
	 * 
	 * @return VOID
	 */
	public function handle_fb() {
		
		$cipher = $this->verifyCipher();
		
		//ok, we got that shit, now send them to FB with the cipher string as the callback
		
		return $this->redirect("/identity/login/send_to_facebook/".base64_encode("/31-days-of-theotis/handle_entry/".base64_encode(serialize($cipher))));
		
	}
	
	/**
	 * CALLBACK FOR FACEBOOK API, USE THE PAYLOAD AS THE CIPHER STRING
	 * AND SUBMIT THE ENTRY
	 * @return VOID
	 */
	
	public function handle_entry() {
		
		$fb_cipher = $this->params['pass'][0];
		
		if(!empty($fb_cipher)) $this->data['UserContest'][$this->Session->id()] = $fb_cipher;
		
		$cipher = $this->verifyCipher();
		
		//ok, so we're looking good on security
		//lets take the cipher and verify it
		if(!$this->verifyDailyopPost($cipher)) {
			
			return $this->cakeError("error404");
			
		}
		
		//ok, so we have a valid cipher, and post, send them through the entry processes with the cipher in hand
		//let's insert the contest entry!
		$this->submitEntry($cipher);
		
	}
	
	private function submitEntry($cipher = false) {
		
		if(!$cipher) {
			
			return $this->cakeError("error404");
			
		}
		
		//lets check to see if they already entered for this post
		//NOTE: we will checkout against id, model, foreign_key, user_id
		
		$this->loadModel("UserContestEntry");
		
		$check = $this->UserContestEntry->find("count",array(
		
			"conditions"=>array(
				"UserContestEntry.user_contest_id"=>$this->user_contest_id,
				"UserContestEntry.user_id"=>$this->Auth->user("id"),
				"UserContestEntry.model"=>"Dailyop",
				"UserContestEntry.foreign_key"=>$cipher['dailyop_id']
			),
			"contain"=>array()
		
		));
		
		//if are check fails, then let's make an entry
		if($check<=0) {
			
			//insert entry!
			$this->UserContestEntry->create();
			$this->UserContestEntry->save(array(
				"user_contest_id"=>$this->user_contest_id,
				"user_id"=>$this->Auth->user("id"),
				"model"=>"Dailyop",
				"foreign_key"=>$cipher['dailyop_id'],
				"active"=>1
			));
			
			
		}
		
		return $this->redirect("/31-days-of-theotis/thanks/".base64_encode(serialize($cipher)));
		
	}
	
	
	private function verifyDailyopPost($cipher = false) {
		
		//ok, we got the post id, let's verify that it's an active contest post in the theotis cat
		$this->loadModel("Dailyop");
		
		$check = $this->Dailyop->find("count",array(
		
			"conditions"=>array(
				"Dailyop.contest_post"=>1,
				"Dailyop.active"=>1,
				"Dailyop.publish_date < NOW()",
				"Dailyop.id"=>$cipher['dailyop_id']
			),
			"contain"=>array()
		
		));
		
		return $check;
		
	}
	
	/**
	 * CIPHER THE INCOMING POST DATA
	 * IF WE FAIL WE TRIGGER AN AUTOMATIC 404 ERROR
	 * Cipher = BASE64( SERIALIZED ( ARRAY( SESSION_ID, DAILYOP_ID, USERID ) ) )
	 * @return Array
	 */
	private function verifyCipher() {
		
		if(count($this->data)) {

			$arr = unserialize(base64_decode($this->data['UserContest'][$this->Session->id()]));
			
			if($this->Session->id() != $arr['session_id']) {
				
				return $this->cakeError("error404");
				
			}
			
			if(!isset($arr['dailyop_id']) || empty($arr['dailyop_id'])) {
				
				return $this->cakeError("error404");
				
			}
			
		} else {
				
			return $this->cakeError("error404");
			
		}
		
		return $arr;
		
	}
	
	private function setViewPost() {
		
		$viewing = $this->Dailyop->returnPost(array(
			"Dailyop.uri"=>$this->params['uri'],
			"DailyopSection.uri"=>$this->params['section']
		),$this->isAdmin());
		
		$this->set(compact("viewing"));
		
	}
	
	private function getPosts() {

		$token = "31-days-of-theotis-cal-list";
		
		if(($posts = Cache::read($token,"1min")) === false) {
			
			$this->loadModel("Dailyop");
			//get all the theotis posts
			$posts = $this->Dailyop->find("all",array(
			
				"conditions"=>array(
					"Dailyop.active"=>1,
					"DailyopSection.uri"=>"31-days-of-theotis",
					"Dailyop.publish_date < NOW()"
				),
				"contain"=>array("DailyopSection")
			
			));
			
			//get all the post id's
			$ids = Set::extract("/Dailyop/id",$posts);
			
			//get the entries based ont he id's
			$this->loadModel("UserContestEntry");
			
			$entries = $this->UserContestEntry->find("all",array(
			
				"conditions"=>array(
					"UserContestEntry.user_contest_id"=>$this->user_contest_id,
					"UserContestEntry.model"=>"Dailyop",
					"UserContestEntry.foreign_key"=>$ids,
					"UserContestEntry.winner"=>1
				),
				"contain"=>array()
			
			));
			
			
			//extract foreign keys
			$found_ids = Set::extract("/UserContestEntry/foreign_key",$entries);
			
			//populate posts if they are found to be "found"
			foreach($posts as $k=>$v) {
				
				if(in_array($v['Dailyop']['id'],$found_ids)) {
					
					$posts[$k]['Dailyop']['found'] = true;
					
				}
				
				$posts[$k]['Dailyop']['check_date'] = date("Y-m-d",strtotime($v['Dailyop']['publish_date']));
				//$posts[$k]['Dailyop']['check_date'] = '2011-12-01';
				
				$t[$v['Dailyop']['id']] = $posts[$k];
						
			}
			
			$posts = $t;
				
			Cache::write($token,$posts,"1min");
			
		}
		
		$this->set(compact("posts"));
		
	}
	
}