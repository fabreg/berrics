<?php

App::uses("SplashAppController","Splash.Controller");

class SplashController extends SplashAppController {
	
	public $uses = array("SplashCreative","Dailyop","SplashDate","Poll");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow();
		
		$this->layout = "splash";
		
	}


	private function geo_check() {
		
		$user_state = (isset($_SERVER['GEOIP_REGION'])) ? $_SERVER['GEOIP_REGION']:"CA";

		if(isset($_GET['geo_override'])) $user_state = $_GET['geo_override'];

		$states = array(
			"WA","ID","OR","AK","MT","WY"
		);

		if(in_array($_SERVER['GEOIP_COUNTRY_CODE'],array("US"))) {

			if (in_array($user_state,$states)) {
				
				return true;

			}

		}

		$ca_states = array(
			"AB","BC","YT"
		);

		if(in_array($_SERVER['GEOIP_COUNTRY_CODE'],array("CA"))) {

			if (in_array($user_state,$ca_states)) {
				
				return true;

			}

		}

		return false;

	}


	
	
	public function index() {

		if($this->geo_check()) {

			return $this->skate_lite();

		}

		$pages = $this->SplashDate->getTodaysPages();

		$seed = mt_rand(0,(count($pages)-1));
		
		$page = $pages[$seed];
		
		if(!empty($page['SplashCreative']['directive'])) {

			$this->view = $page['SplashCreative']['directive'];

			return $this->{$page['SplashCreative']['directive']}();
			
		} else {

			$this->view = "view";
		
			return $this->view($page['SplashCreative']['hash_key']);

		}

		
	}
	
	
	public function view($hash = false) {
		
		$page = $this->SplashCreative->findByHashKey($hash);

		if(!empty($page['SplashCreative']['directive'])) {

			$this->view = $page['SplashCreative']['directive'];

			return $this->{$page['SplashCreative']['directive']}();

		} 
		
		$head_content = $page['SplashCreative']['head_content'];
		
		$title_for_layout = $page['SplashCreative']['page_title'];
		$meta_k = $page['SplashCreative']['meta_k'];
		$meta_d = $page['SplashCreative']['meta_d'];
	
		$this->set(compact("page","title_for_layout","head_content","meta_d","meta_k"));
		
	}

	public function canteen() {
		
		
		$this->loadModel('CanteenProduct');
		

		$product_id = $this->CanteenProduct->find("first",array(
							"fields"=>array(
								"CanteenProduct.id"
							),
							"conditions"=>array(
								"CanteenProduct.active"=>1,
								"CanteenProduct.brand_id"=>3,
								"CanteenProduct.publish_date < '".AppModel::awsNow()."'"
							),
							"contain"=>array(),
							"order"=>"RAND()",
							"limit"=>1
						));
		$product = $this->CanteenProduct->returnProduct(array(
						"conditions"=>array("CanteenProduct.id"=>$product_id['CanteenProduct']['id'])
					));

		$this->set(compact("product"));

	}

	public function jt_bc_interview() {
		
	}

	public function boo_interview() {
		
		$this->view = "/StaticFiles/interrogation-boo-johnson";

	}

	public function bangin() {
		
		$this->loadModel('Dailyop');

		$token = "bangin-splash";

		if(($tiles = Cache::read($token,"1min")) === false) {

			$posts = $this->Dailyop->find('all',array(
						"conditions"=>array(
							"Dailyop.active"=>1,
							"Dailyop.publish_date < '".AppModel::awsNow()."'",
							"Dailyop.dailyop_section_id"=>5
						),
						"contain"=>array(
							"DailyopMediaItem"=>array(
								"MediaFile",
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
								"limit"=>1
							)
						),
						"limit"=>100,
						"order"=>array("RAND()")
					));


			foreach($posts as $post) {

				$tiles[] = "<div class='tile-inner'><a href='/bangin/{$post['Dailyop']['uri']}?autoplay'><img class='lazy' src='//img.theberrics.com/i.php?w=275&src=/loading-imgs/loading-lazy.jpg' data-original='//img.theberrics.com/i.php?src=/video/stills/{$post['DailyopMediaItem'][0]['MediaFile']['file_video_still']}&w=275' border='0' /></a></div>";

			}

			Cache::write($token,$tiles,"1min");

		}



		$this->set(compact("tiles"));

	}

	public function reda() {
		
		$this->loadModel('Dailyop');

		$token = "reda-splash";

		if(($tiles = Cache::read($token,"1min")) === false) {

			$posts = $this->Dailyop->find('all',array(
						"conditions"=>array(
							"Dailyop.active"=>1,
							"Dailyop.publish_date < '".AppModel::awsNow()."'",
							"Dailyop.dailyop_section_id"=>3
						),
						"contain"=>array(
							"DailyopMediaItem"=>array(
								"MediaFile",
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
								"limit"=>1
							)
						),
						"limit"=>100,
						"order"=>array("RAND()")
					));


			foreach($posts as $post) {

				$tiles[] = "<div class='tile-inner'><a href='/wednesdays-with-reda/{$post['Dailyop']['uri']}?autoplay'><img class='lazy' src='//img.theberrics.com/i.php?w=275&src=/loading-imgs/loading-lazy.jpg' data-original='//img.theberrics.com/i.php?src=/video/stills/{$post['DailyopMediaItem'][0]['MediaFile']['file_video_still']}&w=275' border='0' /></a></div>";

			}

			Cache::write($token,$tiles,"1min");

		}



		$this->set(compact("tiles"));

	}

	public function mikey_days() {
		
		$this->loadModel('Dailyop');

		$token = "reda-splash";

		if(($tiles = Cache::read($token,"1min")) === false) {

			$posts = $this->Dailyop->find('all',array(
						"conditions"=>array(
							"Dailyop.active"=>1,
							"Dailyop.publish_date < '".AppModel::awsNow()."'",
							"Dailyop.dailyop_section_id"=>6
						),
						"contain"=>array(
							"DailyopMediaItem"=>array(
								"MediaFile",
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
								"limit"=>1
							)
						),
						"limit"=>100,
						"order"=>array("RAND()")
					));


			foreach($posts as $post) {

				$tiles[] = "<div class='tile-inner'><a href='/mikey-days/{$post['Dailyop']['uri']}?autoplay'><img class='lazy' src='//img.theberrics.com/i.php?w=275&src=/loading-imgs/loading-lazy.jpg' data-original='//img.theberrics.com/i.php?src=/video/stills/{$post['DailyopMediaItem'][0]['MediaFile']['file_video_still']}&w=275' border='0' /></a></div>";

			}

			Cache::write($token,$tiles,"1min");

		}



		$this->set(compact("tiles"));

	}

	/**
	SPLASH POLL METHODS
	*/


	public function splash_poll($poll_id = false) {
		
		$poll_id = 1;

		$this->layout = "empty";

		//check to see if they have voted
		$this->set(compact("poll_id"));

	}

	public function splash_poll_ajax($poll_id) {
		
		$poll = $this->Poll->returnPoll($poll_id);

		$this->set(compact("poll"));

		//check to see if they have already voted
		$user_id = (CakeSession::check("Auth.User.id"))  ? $this->Auth->user('id'):false;

		$chk = $this->Poll->PollVotingRecord->checkIfAlreadyVoted($poll_id,session_id(),$user_id);

		if($chk) {

			$results = $this->Poll->pollResultsRealtime($poll_id);
			$this->set(compact("results"));
			$this->view = "splash_poll_results";

		} else {

			$this->view = "splash_poll_vote";

		}

	}

	public function splash_handle_vote() {
		
		if($this->request->is("post") || $this->request->is("put")) {
			
			$user_id = (CakeSession::check("Auth.User.id"))  ? $this->Auth->user('id'):false;

			$this->Poll->PollVotingRecord->addVote($this->request->data['PollVotingRecord']['poll_voting_option_id'],session_id(),$user_id);

			sleep(2);

			$this->redirect("/");

		}

	}

	public function skate_lite() {
		
		$post = $this->Dailyop->returnPost(array("Dailyop.id"=>7440),1);

		$this->set(compact("post"));

		$this->view = "skate_lite";

	}



	public function vans_protec() {
		
		$post = $this->Dailyop->returnPost(array("Dailyop.id"=>7042),1);

		$this->set(compact("post"));

	}

	public function xgames() {

		$post = $this->Dailyop->returnPost(array("Dailyop.id"=>7058),1);

		$this->set(compact("post"));

	}

	public function poll() {
		
		$poll_id = 1;

		$this->set("poll_id",$poll_id);

	}

	public function sls() {
		
		
		
	}
	
	
	
}
