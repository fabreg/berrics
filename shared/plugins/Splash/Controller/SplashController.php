<?php

App::uses("SplashAppController","Splash.Controller");

class SplashController extends SplashAppController {
	
	public $uses = array("SplashCreative","Dailyop","SplashDate");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow();
		
		$this->layout = "splash";
		
	}
	
	
	public function index() {
		
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
								"CanteenProduct.publish_date < NOW()"
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
							"Dailyop.publish_date < NOW()",
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
							"Dailyop.publish_date < NOW()",
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


	public function vans_protec() {
		
		$post = $this->Dailyop->returnPost(array("Dailyop.id"=>7042),1);

		$this->set(compact("post"));

	}

	public function xgames() {

		$post = $this->Dailyop->returnPost(array("Dailyop.id"=>7058),1);

		$this->set(compact("post"));

	}
	
	
	
}
