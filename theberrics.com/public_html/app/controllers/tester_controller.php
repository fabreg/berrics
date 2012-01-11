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
		
		$data = $ups->estimateShipping(array(
			"Shipping"=>array(
				"first_name"=>"John",
				"last_name"=>"Hardy",
				"street_address"=>"",
				"apt"=>"",
				"city"=>"LONDON",
				"province"=>"",
				"country"=>"GB",
				"postal"=>"",
				"phone"=>"818-888-8888"
			),
			"Service"=>array(
				"code"=>"03"
			)
		));
		
		
		die(print_r($data));
		
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
		
		$sql = "SELECT url, normalized_url, share_count, like_count, comment_count, total_count,
				commentsbox_count, comments_fbid, click_count FROM link_stat WHERE url='http://theberrics.com/gen-ops/girl-chocolate-trailer.html'";
		
		$q = $fb->facebook->api(array(
			
			"method"=>"fql.query",
			"query"=>$sql,
			"format"=>"json"
		
		));
		
		$count = $q[0]['total_count'];
		
		die($count);
		
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
	
	public function pizza_emails() {
		
		$this->loadModel("User");
		
		$q = $this->User->query(
			"select u.email,p.geo_region_name,p.geo_city_name from users u
			left join user_profiles p ON (p.user_id = u.id)
			where p.geo_region_name like 'calif%' and p.geo_city_name != 'san francisco'
			and email != 'john@theberrics.com' and email != 'john.hardy@me.com'
			limit 75
			"
		);
		
		foreach($q as $v) {
			
			echo $v['u']['email'].",";
			
		}
		die();
		die(print_r($q));
		
		
	}
	
	
	
}


?>