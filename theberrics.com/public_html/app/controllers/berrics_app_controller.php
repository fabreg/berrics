<?php

App::import("Vendor","BCAPI",array("file"=>"bc_api.php"));
App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));


class BerricsAppController extends AppController {
	
	
	
	public $app_name = "TheBerrics";
	
	public $helpers = array("Berrics","Media","Store","Number");
	
	public $view = "Theme";
	
	public $theme = "website";
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		if(isset($_SERVER['DEVSERVER']) && $_SERVER['DEVSERVER'] == 1) $this->fixGeoIp();
		
		$this->setSections();
		
		$this->setCanteenCategories();
		
		$this->setFeaturedPost();
		
		$this->getUserCurrency();
		
	}
	
	private function fixGeoIp() {
		
		if(!isset($_SERVER['GEOIP_COUNTRY_CODE'])) $_SERVER['GEOIP_COUNTRY_CODE'] = "US";
		
		if(!isset($_SERVER['GEOIP_POSTAL_CODE']))  $_SERVER['GEOIP_POSTAL_CODE'] = '';
		
		if(!isset($_SERVER['GEOIP_REGION_NAME'])) $_SERVER['GEOIP_REGION_NAME'] = "Los Angeles";
		
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
	
}


?>