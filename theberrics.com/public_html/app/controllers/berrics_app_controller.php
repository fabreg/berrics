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
		
		$this->setSections();
		
		$this->setFeaturedPost();
		
		$this->getUserCurrency();
		
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
		
		if(isset($_GET['currency_override'])) {
			
			$cid = $_GET['currency_override'];
			
		} else if($this->Session->check("UserCurrency")) { 
	
			$cid = $this->Session->read("UserCurrency");
			
		} else {
			
			$cid = CanteenConfig::returnUserCurrencyId($_SERVER['GEOIP_COUNTRY_CODE']);
			
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