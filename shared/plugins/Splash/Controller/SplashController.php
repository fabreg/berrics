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
		
		$this->view = "view";
		
		return $this->view($page['SplashCreative']['hash_key']);
		
	}
	
	
	public function view($hash = false) {
		
		$page = $this->SplashCreative->findByHashKey($hash);
		
		$head_content = $page['SplashCreative']['head_content'];
		
		$title_for_layout = $page['SplashCreative']['page_title'];
		$meta_k = $page['SplashCreative']['meta_k'];
		$meta_d = $page['SplashCreative']['meta_d'];
	
		$this->set(compact("page","title_for_layout","head_content","meta_d","meta_k"));
		
	}
	
	
	
}
