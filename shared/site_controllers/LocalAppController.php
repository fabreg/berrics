<?php

App::import("Vendor","BCAPI",array("file"=>"bc_api.php"));
App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));


class LocalAppController extends AppController {
	
	public $app_name = "TheBerrics";
	
	public $helpers = array(
							"Berrics",
							"Media",
							"Store",
							"Number",
							"Form" => array(
							        "className" => "BootstrapForm"
							 )
					);

	public $theme = "website";
	
	public $enforce_ssl = false;

	public $body_element = "layout/v3/two-column";

	public $top_element = "layout/v3/top_element";
	
	public function beforeFilter() {
		
		
		//do a splash page check
		
		if(date("Y-m-d")=='2012-08-13') {
			
			if(!in_array($this->request->params['controller'],array("splash"))) {
					
				if(!$this->Session->check("visited_splash")) {
			
			
					header("Location:/");
					die();
			
				}
					
			} else {
					
				$this->Session->write("visited_splash",1);
					
			}
			
		}
		
		
		parent::beforeFilter();
		
		if(isset($_SERVER['DEVSERVER']) && $_SERVER['DEVSERVER'] == 1) $this->fixGeoIp();
		
		//$this->setSections();
		
		$this->setCanteenCategories();
		
		$this->setFeaturedPost();
		
		$this->getUserCurrency();
		
		$this->setCanteenProduct();
		
		if($this->enforce_ssl==true && ($_SERVER['HTTPS']!=1)) {
			
			$this->enforceSSL();
			
		} elseif($this->enforce_ssl==false && $_SERVER['HTTPS']==1) {
			
			$this->releaseSSL();
			
		}

		$this->set("body_element",$this->body_element);
		$this->set("top_element",$this->top_element);
		
		
	}
	
	private function fixGeoIp() {
		
		if(!isset($_SERVER['GEOIP_COUNTRY_CODE']) || empty($_SERVER['GEOIP_COUNTRY_CODE'])) $_SERVER['GEOIP_COUNTRY_CODE'] = "US";
		
		if(!isset($_SERVER['GEOIP_POSTAL_CODE']))  $_SERVER['GEOIP_POSTAL_CODE'] = '';
		
		if(!isset($_SERVER['GEOIP_REGION_NAME'])) $_SERVER['GEOIP_REGION_NAME'] = "California";
		
		if(isset($_GET['geoip_override']))  $_SERVER['GEOIP_COUNTRY_CODE'] = $_GET['geoip_override'];
		
		
	}
	
	public function setCanteenCategories() {
		
		$this->loadModel("CanteenCategory");
		$this->set("main_canteen_categories",$this->CanteenCategory->treeArray());
		
	}
	
	
	public function setSections() {
		
		$this->loadModel("DailyopSection");
		
		$sections_array = $this->DailyopSection->returnSections();
		
		$this->set(compact("sections_array"));
		
	}
	
	public function setFeaturedPost() {
		
		$this->loadModel("Dailyop");
		
		$featured_post = $this->Dailyop->returnPost(array(
		
			"Dailyop.featured_archive"=>1
		
		));
		
		$this->set(compact("featured_post"));
		
	}
	
	public function setCanteenProduct() {
		
		$this->loadModel("CanteenProduct");
		
		$home_random_product = $this->CanteenProduct->returnRandomProduct();
		
		$this->set(compact("home_random_product"));
		
	}
	
	public function getUserCurrency() {
		
		$cid = "USD";
		$geo = (isset($_SERVER['GEOIP_COUNTRY_CODE'])) ? $_SERVER['GEOIP_COUNTRY_CODE']:"US";
		if(isset($_GET['currency_override'])) {
			
			$cid = $_GET['currency_override'];
			
		} else if($this->Session->check("UserCurrency")) { 
	
			$cid = $this->Session->read("UserCurrency");
			
		} else {
			
			$cid = CanteenConfig::returnUserCurrencyId();
			
		}
		
		$this->set("user_currency_id",$cid);
		
		return $cid;
		
	}
	
	public function getUserLanguage() {
		
		$def = "en_us";
		
		$this->set("user_locale",$def);
		
		return $def;
		
	}
	
	protected function enforceSSL() {
		
		/*
		 * 
		 * if(
			(!preg_match('/^(https)/',$_SERVER['SCRIPT_URI']) && !preg_match('/(dev)/',$_SERVER['SERVER_NAME'])) || 
			(preg_match('/(127\.0\.0\.1)/',$_SERVER['HTTP_X_FORWARDED_FOR']))
			) 
		 * 
		 */
		
		if(
			$_SERVER['HTTPS']!=1
			) 
		{
			
			return $this->redirect("https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
			
		}
		
	}
	
	protected function releaseSSL() {
		
		if(
			$_SERVER['HTTPS']==1
			) 
		{
			
			return $this->redirect("http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
			
		}
		
	}
	
	
}


?>