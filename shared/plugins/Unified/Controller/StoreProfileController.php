<?php

App::uses("UnifiedAppController","Unified.Controller");

class StoreProfileController extends UnifiedAppController {

	public $uses = array("UnifiedStore");


	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	private function setStore($uri = false) {

		if(!$uri) throw new BadRequestException("Invalid Store Request");

		

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
