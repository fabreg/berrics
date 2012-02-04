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
			"SELECT * FROM 
			users `User`
			LEFT JOIN user_profiles `UserProfile` ON UserProfile.user_id = User.id
			WHERE User.id IN (
			SELECT user_id FROM user_contest_entries where user_contest_id = 3
			) AND UserProfile.geo_region_name = 'California'
			AND User.email NOT IN (
			'
skate.4.me@hotmail.com,steezemachine@hotmail.com,porkypen15@yahoo.com,cody.blanc007@yahoo.com,greenjay84@yahoo.com,samuelreguerra@yahoo.com,stoneskull11@yahoo.com,christiangurule@yahoo.com,joseescobedo57@yahoo.com,kruxskater55@aol.com,autocadesigns@yahoo.com,penguinsact@yahoo.com,bryant24chang@yahoo.com,dboysk8metal@gmail.com,sk8erjy@cox.net,steveberra@theberrics.com,wolfman4991@att.net,zeroactive05@gmail.com,randomidity7@yahoo.com,guesswho@thekayostore.com,bustacap29@yahoo.com,kjcraig77@yahoo.com,ivalle1991@yahoo.com,wassupskater@aol.com,al.eaton@comcast.net,corbinwaltz@aol.com,giuseppestephens@yahoo.com,chrisiskoala@aim.com,wasadee@aim.com,themightygrant@gmail.com,jackson_deloach@yahoo.com,robertkoston@yahoo.com,dillpill879@hotmail.com,maryhite@hotmail.com,spitfire4lyfe@hotmail.com,mothepro2009@live.com,carlosgarcia911@yahoo.com,joshee5919@aol.com,juliusayala@gmail.com,jcflores@linkline.com,kylesweett@yahoo.com,danhalen96@gmail.com,santamonica36@aol.com,piratesteez@gmail.com,cheder04@yahoo.com,connord3@hotmail.com,etserrano@hotmail.com,Brokenspindles@earthlink.net,erikgllgs@yahoo.com,itunes41@aim.com,facebook@shaolinux.org,pgarc2@yahoo.com,gonzalez.frank@yahoo.com,delcid.eric@yahoo.com,justinahorvath@yahoo.com,bmessinger@ymail.com,power_Of_da_w4zn@yahoo.com,ianlittleworth@gmail.com,hardcore72492@yahoo.com,hankster98@mac.com,cheesybeaner@gmail.com,geannpark@yahoo.com,Pjaeyi@gmail.com,topeteu05@yahoo.com,ceasarsonic@hotmail.com,mra123@gmail.com,luckyshot919@aol.com,tony2yankee@yahoo.com,stevenswanson@live.com,Benmaldonadoii@gmail.com,Petersvn@gmail.com,shawnsandfer@gmail.com,tomgammage@hotmail.com,erik7833@yahoo.com,josetarro14@yahoo.com'
			) LIMIT 75;
			"
		);
		
		
		foreach($q as $v) {
			
			echo $v['User']['email'].",";
			
		}
		die();
		die(print_r($q));
		
		
	}
	
	
	
}


?>