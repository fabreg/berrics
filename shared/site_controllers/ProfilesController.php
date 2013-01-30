<?php


App::import("Controller","LocalApp");

class ProfilesController extends LocalAppController {
	
	public $uses = array("User","Dailyop");
	
	private $profile = false;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->theme = "profiles";
		
		$this->profile = $this->setProfile();

				

	}
	
	
	public function index() {
		
		
		
	}
	
	public function view() {
		


		$this->media();
		
	}

	public function media() {
		
		
		$post_ids = $this->User->returnTaggedPostIds($this->profile);

		$this->Paginator->settings = array();
		$this->Paginator->settings['Dailyop']['conditions'] = array(
					"Dailyop.id"=>$post_ids,
					"Dailyop.active"=>1,
					"Dailyop.publish_date < NOW()",
					"Dailyop.promo"=>0
				);
		$this->Paginator->settings['Dailyop']['order'] = array("Dailyop.publish_date"=>"DESC");
		$this->Paginator->settings['Dailyop']['contain'] = array(
			"DailyopMediaItem"=>array(
				"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
				"limit"=>1,
				"MediaFile"
			),
			"DailyopSection",
			"DailyopTextItem"=>array(
				"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
				"limit"=>1,
				"MediaFile"
			)

		);

		$posts = $this->paginate("Dailyop");

		$this->set(compact("posts"));
	}
	
	public function instagram() {
		
		$this->loadModel("InstagramImageItem");
		
		$instagram = $this->InstagramImageItem->returnInstagramRecent($this->profile['User']);
		
		$this->set(compact("instagram"));
		
	}
	
	private function setProfile() {
		
		if(isset($this->request->params['uri'])) {
			
			$profile = $this->User->returnProfile(array(
		
				"User.profile_uri"=>$this->request->params['uri']
			
			));
			$this->profile = $profile;
			$this->set(compact("profile"));
			
		}
		
		
		if(
			!isset($this->request->params['uri']) || 
			!isset($profile['User']['id'])	
		) throw new NotFoundException();
		
		return $profile;
	}
	
}