<?php

App::import("Controller","BerricsApp");

class SplashController extends BerricsAppController {
	
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
	
	
	
	
}

?>