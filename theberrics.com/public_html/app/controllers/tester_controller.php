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
	
	public function fix_batb($id = false) {
		
		
		$this->loadModel("BatbVote");
		
		
		$votes = $this->BatbVote->query("
			select user_id,count(*) as `total` from batb_votes where batb_match_id = {$id} group by user_id order by total desc 
		");
		
		$i = 0;
		//die(pr($votes));
		foreach($votes as $v) {
			
			if($v[0]['total']>1) {
				
				$uid = $v['batb_votes']['user_id'];
				$dlimit = $v[0]['total']-1;
				
				//echo "Total: ".$dlimit;
				//echo "User: ".$uid;
				//echo "<br />";
				//$this->BatbVote->query("DELETE FROM batb_votes WHERE user_id='{$uid}' AND batb_match_id='{$id}' LIMIT {$dlimit}");
				echo "DELETE FROM batb_votes WHERE user_id='{$uid}' AND batb_match_id='{$id}' LIMIT {$dlimit};";
			}
			
		}
		echo $i;
		die($i);
		
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
skate.4.me@hotmail.com,steezemachine@hotmail.com,porkypen15@yahoo.com,cody.blanc007@yahoo.com,greenjay84@yahoo.com,samuelreguerra@yahoo.com,stoneskull11@yahoo.com,christiangurule@yahoo.com,joseescobedo57@yahoo.com,kruxskater55@aol.com,autocadesigns@yahoo.com,penguinsact@yahoo.com,bryant24chang@yahoo.com,dboysk8metal@gmail.com,sk8erjy@cox.net,steveberra@theberrics.com,wolfman4991@att.net,zeroactive05@gmail.com,randomidity7@yahoo.com,guesswho@thekayostore.com,bustacap29@yahoo.com,kjcraig77@yahoo.com,ivalle1991@yahoo.com,wassupskater@aol.com,al.eaton@comcast.net,corbinwaltz@aol.com,giuseppestephens@yahoo.com,chrisiskoala@aim.com,wasadee@aim.com,themightygrant@gmail.com,jackson_deloach@yahoo.com,robertkoston@yahoo.com,dillpill879@hotmail.com,maryhite@hotmail.com,spitfire4lyfe@hotmail.com,mothepro2009@live.com,carlosgarcia911@yahoo.com,joshee5919@aol.com,juliusayala@gmail.com,jcflores@linkline.com,kylesweett@yahoo.com,danhalen96@gmail.com,santamonica36@aol.com,piratesteez@gmail.com,cheder04@yahoo.com,connord3@hotmail.com,etserrano@hotmail.com,Brokenspindles@earthlink.net,erikgllgs@yahoo.com,itunes41@aim.com,facebook@shaolinux.org,pgarc2@yahoo.com,gonzalez.frank@yahoo.com,delcid.eric@yahoo.com,justinahorvath@yahoo.com,bmessinger@ymail.com,power_Of_da_w4zn@yahoo.com,ianlittleworth@gmail.com,hardcore72492@yahoo.com,hankster98@mac.com,cheesybeaner@gmail.com,geannpark@yahoo.com,Pjaeyi@gmail.com,topeteu05@yahoo.com,ceasarsonic@hotmail.com,mra123@gmail.com,luckyshot919@aol.com,tony2yankee@yahoo.com,stevenswanson@live.com,Benmaldonadoii@gmail.com,Petersvn@gmail.com,shawnsandfer@gmail.com,tomgammage@hotmail.com,erik7833@yahoo.com,josetarro14@yahoo.com,john@theberrics.com,john.hardy@me.com,michael.pooops@gmail.com,steezemachine@hotmail.com,joshpaul15@gmail.com,cody.blanc007@yahoo.com,wiiskate@yahoo.com,samuelreguerra@yahoo.com,christiangurule@yahoo.com,elmitchello@hotmail.com,joseescobedo57@yahoo.com,neezer9@yahoo.com,Metalaxe31@aol.com,marcusims55@yahoo.com,kruxskater55@aol.com,autocadesigns@yahoo.com,penguinsact@yahoo.com,bryant24chang@yahoo.com,moneykas16@hotmail.com,sk8erjy@cox.net,sanchezeee93@yahoo.com,christophercaputo@ymail.com,wolfman4991@att.net,danollek@gmail.com,harrys2013@wildwoodstudent.org,ivalle1991@yahoo.com,priceline_negotiator7@yahoo.com,gaby122001@hotmail.com,joelmhdz12@yahoo.com,robertkoston@yahoo.com,dillpill879@hotmail.com,jasonbenavidez21@yahoo.com,emerica_rider92@yahoo.com,spitfire4lyfe@hotmail.com,towers221@yahoo.com,alanappr@aol.com,ivanchavez113@hotmail.com,carlosgarcia911@yahoo.com,ksorensen18@yahoo.com,juliusayala@gmail.com,jcflores@linkline.com,andrew.truong@email.ucr.edu,truningermatthew@yahoo.com,cheder04@yahoo.com,fishwwc@gmail.com,connord3@hotmail.com,etserrano@hotmail.com,louisborzage@yahoo.com,erikgllgs@yahoo.com,micorodriguezcoh@yahoo.com,lovetoskate909@aol.com,joel111592@yahoo.com,rampartosa@gmail.com,toefoo37@yahoo.com,bmessinger@ymail.com,kevin.m.brown12533@gmail.com,masonmae07@aol.com,mamiyano@ucdavis.edu,melidoll1213@aol.com,andrewwasthere@yahoo.com,elloshane@yahoo.com,cheesybeaner@gmail.com,littlerenren3@hotmail.com,topeteu05@yahoo.com,vumpler1@gmail.com,luckyshot919@aol.com,stevenswanson@live.com,Petersvn@gmail.com,Andmattsays@gmail.com,shawnsandfer@gmail.com,tomgammage@hotmail.com,finallyflared14@yahoo.com,josetarro14@yahoo.com,diego.moreno@aol.com,dsdorough@aol.com'
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