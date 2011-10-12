<?php

App::import("Controller","BerricsApp");
App::import("Vendor","UpsApi",array("file"=>"UpsApi.php"));

class TesterController extends BerricsAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	
	public function index() {
		
		$ups = new UpsApi();
		
		$ups->test(array(
			"Shipping"=>array(
				"first_name"=>"John",
				"last_name"=>"Hardy",
				"street_address"=>"2669 Nutmeg Cir",
				"apt"=>"",
				"city"=>"Simi Valley",
				"province"=>"CA",
				"country"=>"US",
				"postal"=>"93063",
			"phone"=>"818-888-8888"
			)
		));
		
	}
	
	public function tags() {
		
		
		$this->loadModel("Tag");
		$this->loadModel("Dailyop");
		
		$test = $this->Tag->searchTags("koston");
		
		$tags = Set::extract("/Tag/id",$test);
		
		$posts = $this->Tag->returnHighestRankedPosts($tags);
		
		pr($posts);
		
		die();
		
	}
	
	
	
	public function fb() {
		
		$fb = FacebookApi::instance();
		
		$sql = 'SELECT name, hometown_location, locale, current_location FROM user WHERE uid="94806328"';
		
		$q = $fb->facebook->api(array(
			
			"method"=>"fql.query",
			"query"=>$sql,
			"format"=>"json"
		
		));
		
		die(pr($q));
		
	}
	
	
	public function insta() {
		
		App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
		
		$i = InstagramApi::instance();
		
		$i->instagram->openAuthorizationUrl();
		
		
		
	}
	
	
	public function callback() {
		
		
		//die(print_r($_REQUEST));
		
		App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
		
		$i = InstagramApi::berricsInstance();
		
		$pop = $i->instagram->getUserRecent(InstagramApi::$berrics_id);
		
		die(print_r($pop));
		
		
	}
	
	
}


?>