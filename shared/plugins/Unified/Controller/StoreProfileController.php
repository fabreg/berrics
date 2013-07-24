<?php

App::uses("UnifiedAppController","Unified.Controller");

class StoreProfileController extends UnifiedAppController {

	public $uses = array("UnifiedStore");

	private $store = false;

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

		if(isset($this->request->params['uri'])) {

			$this->setHeroUnit();

		}

		$this->setStore();

		$this->set("body_element","layout/unified-store-body");

		$this->theme = "unified";

	}

	private function setStore() {

		$uri = $this->request->params['uri'];

		if(empty($uri)) throw new BadRequestException("Invalid Store Request");

		$cache = true;

		if(preg_match('/(dev|v3)/',$_SERVER['HTTP_HOST'])) {


			$cache = false;

		}

		$this->store = $store = $this->UnifiedStore->returnStore($uri,1);

		$this->set(compact("store"));

	}

	public function view() {

		//if(isset($_GET['view'])) 
		$this->view = "view2";
		//get the news

		$store = $this->store;

		$this->UnifiedStore->getStoreNewsItems($this->store['UnifiedStore']['id']);

		//format media
		$mediaItems = array();

		foreach($store['UnifiedStoreMediaItem'] as $k=>$v) {

			$mediaItems[$v['category']][] = $v;

		}

		//format employees
		$employees = array();

		foreach($store['UnifiedStoreEmployee'] as $v) {

			if($v['team_rider']) continue;

			$employees[] = $v;

		}

		$team = array();

		foreach ($store['UnifiedStoreEmployee'] as $k => $v) {
			
			if(!$v['team_rider']) continue;

			$team[] = $v;

		}

		$posts = $this->UnifiedStore->getStorePosts($store['UnifiedStore']['id']);

		$news = $this->UnifiedStore->getStoreNewsItems($store['UnifiedStore']['id']);

		$this->set(compact("mediaItems","employees","team","posts","news"));

		
	}


	//store methods

	private function setHeroUnit() {



	}

	public function bio() {
		


	}

	public function media() {


	}
	
	public function events() {


	}

	public function employees() {


	}

	public function brands() {
		


	}


}
