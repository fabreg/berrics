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
	
	
	
}
