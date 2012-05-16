<?php

App::import("Controller","LocalApp");

class SplashController extends LocalAppController {
	
	public $uses = array("SplashPage");
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->layout = "splash";
		
	}
	
	
	public function index() {
		
		//get the latest active page
		
		$page = $this->SplashPage->find("first",array(
		
			"conditions"=>array(
				"SplashPage.active"=>1,
				"SplashPage.publish_date < NOW()"
			),
			"order"=>array("SplashPage.publish_date"=>"DESC")
		
		));
		
		
		$this->set(compact("page"));
		
	}
	
	public function yn3_countdown() {
		
		$this->set("title_for_layout","The Berrics - Vans Presents: YOUnited Nations 3");
		
		
	}
	
	public function yn3_final_trailer() {
		
		$this->set("title_for_layout","The Berrics - Vans Presents: YOUnited Nations 3");
		$this->layout = "empty";
		
		//get the chaz post
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4939
		
		));
		
		$this->set(compact("post"));
	}
	
	public function kony() {
		
		$this->set("title_for_layout","The Berrics - The worlds most award winning skateboarding site.");
		
	}
	
	public function test() {
		
		
		
		
	}
	
	public function preview($preview_hash = false) {
		
		if(!$preview_hash) {
			
			return $this->cakeError("error404");
			
		}
		
		
		$page = $this->SplashPage->find("first",array(
		
			"conditions"=>array(
		
				"SplashPage.preview_hash"=>$preview_hash
		
		
			)
		
		
		));
		
		
		if(!isset($page['SplashPage']['id'])) {
			
			return $this->cakeError("error404");
			
		}
		
		$this->set(compact("page"));
		
		$this->render("index");
		
	}
	
	public function rotator() {
		
		$this->layout = "splash_comments";
		//get the pages that they have already viewed
		
		$viewed = ($this->Session->check("SplashViews")) ? $this->Session->read("SplashViews"):array();
	
		
		//get all the promo splash pages
		
		$page = $this->SplashPage->find("first",array(
		
			"conditions"=>array(
			
				"SplashPage.active"=>1,
				"SplashPage.promo"=>1,
				"NOT"=>array("SplashPage.id "=>$viewed)
			),
			"order"=>array(
				"RAND()"
			)
		
		));
		
		if(!isset($page['SplashPage']['id'])) {
			
			$this->Session->delete("SplashViews");
			return $this->rotator();
			
		}
		
		
		$viewed[] = $page['SplashPage']['id'];
		
		$this->Session->write("SplashViews",$viewed);

		$this->set(compact("page"));
		
	}
	
	
	public function instagram() {
		
		App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
		
		$token = "instagram_splash";
		
		if(($pics = Cache::read($token,"30sec")) === false) {
			
			
			$i = InstagramApi::berricsInstance();
			
			$pics = $i->instagram->getUserRecent(InstagramApi::$berrics_id);
			
			$pics = json_decode($pics);
			
			Cache::write($token,$pics,"30sec");
			
		}
		
		$this->set(compact("pics"));
		
		
		
	}
	
	public function sls() {
		
		
		
		
	}
	
	public function westchester() {
		
		
		
		
	}

	
	public function gatorade() {
		
		$this->layout = "empty";
		
		//get the chaz post
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>3554
		
		));
		
		$this->set(compact("post"));
		
		
	}
	
	public function random() {
		
		$seed = mt_rand(1,9);
		
		
		switch($seed) {
			
			case 1:
			case 2:
			case 3;
				$this->dc_mo();
				return $this->render("dc_mo");
			break;
			case 4:
			case 5:
			case 6:
				$this->dc_2012();
				return $this->render("dc_2012");
				break;
			case 7:
			case 8:
				$this->lrg();
				return $this->render("lrg");
				break;
			case 9:
			default:
				$this->diy();
				return $this->render("diy");
				break;
			break;
		}
		
		
	}
	
	public function gc() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4124
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function element_am_video() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>5070
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function dc_rediscover() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4290
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function bday() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4193
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function wild() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>3588
		
		));
		
		$this->set(compact("post"));
	}
	
	public function diy() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4368
		
		));
		
		$this->set(compact("post"));
	}	
	
	public function by3($dude = 'derek') {
		
		$this->layout = "empty";
		
		$yoshi = 3663;
		$derek = 3660;
		
		$key = $$dude;
		
		
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>$key
		
		));
		
		$this->set(compact("post","dude"));
		
	}
	
	public function dc() {
		
		
		$this->layout = "empty";
		
		
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>3716
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function dc_2012() {
		
		$this->layout = "empty";
		
		
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4343
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function dc_cole() {
		
		$this->layout = "empty";
		
		
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4529
		
		),1);
		
		$this->set(compact("post"));
		
	}

	public function dc_miller() {
		
		$this->layout = "empty";
		
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>5110
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function dc_mo() {
		
		$this->layout = "empty";
		
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4678
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function lrg() {
		
		$this->layout = "empty";
		
		
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4595
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	
	public function ross() {
		
		$this->layout = "empty";
		
		
		$this->loadModel("Dailyop");
		$post1 = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>3756
		
		),1);
		$post2 = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>3767
		
		),1);
		$this->set(compact("post1","post2"));
		
	}
	
	public function weekendtage() {
		
		$this->loadModel("Dailyop");
		
		$ids = $this->Dailyop->find("all",array(
			"fields"=>array(
				"Dailyop.id"
			),
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>76
			),
			"contain"=>array()
		));
		
		$ids = Set::classicExtract($ids,"{n}.Dailyop.id");
		
		$seed = mt_rand(0,count($ids));
		
		
		$this->layout = "empty";
		
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>$ids[$seed]
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function vans() {
		
		$this->layout = "empty";
		
		$this->loadModel("Dailyop");
		
		$post_id = 4536;
		$part = "PART 1";
		
		switch(date("Y-m-d")) {
			

			case "2012-02-08":
				$post_id = 4537;
				$part = "PART 2";
				
				break;
			case "2012-02-09":
				$post_id = 4538;
				$part = "PART 3";
				break;

		}
						
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>$post_id
		
		),1);
		
		$this->set(compact("post","part"));
		
	}
	
	public function nike() {
		
		$this->layout = "empty";
		
	}
	
	
	public function ishod() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4344
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function haroshi() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4434
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function sls_selection() {
		
		$this->layout = "empty";
		
		$this->loadModel("SlsVote");
		
		$s = array();
		
		$stats = $this->SlsVote->getVoteStats();
	
		foreach($stats['Stats'] as $k=>$v) {
			
			if($k>4) {
				
				$s['out'][] = $v;
				
			} else {
				
				$s['in'][] = $v;
				
			}
			
		}
		
		$this->set(compact("s"));
		
	}
	
	public function wfl() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4930
		
		),1);
		
		$this->set(compact("post"));
		
		
	}
	
public function dc_apr() {
		
		$this->layout = "empty";
		$this->loadModel("Dailyop");
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4943
		
		),1);
		
		$this->set(compact("post"));
		
	}
	
	public function berra_bday() {
		
		$this->loadModel("InstagramImageItem");
		
		$instagram = $this->InstagramImageItem->returnImagesByTagRaw("happybirthdaysteveberra");
		
		$this->set(compact("instagram"));
		
		$this->set("title_for_layout","The Berrics - Happy Birthday Steve Berra! - Instagram: #happybirthdaysteveberra");
		
	}
	
	public function sls_kc() {
		
		
		
		
	}
	
}

?>
