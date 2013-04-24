<?php

App::uses("UnifiedAppController","Unified.Controller");

class StoreProfileController extends UnifiedAppController {

	public $uses = array("UnifiedStore");


	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

		if(isset($this->request->params['uri'])) {

			$this->setHeroUnit();

		}

		$this->setStore();

		//$this->set("body_element","layout/unified-store-body");

	}

	private function setStore() {

		$uri = $this->request->params['uri'];

		if(empty($uri)) throw new BadRequestException("Invalid Store Request");

		$store = $this->UnifiedStore->returnStore($uri,1);

		$this->set(compact("store"));

	}

	public function view() {

		

		
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
