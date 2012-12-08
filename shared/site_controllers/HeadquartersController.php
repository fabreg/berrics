<?php

App::uses("LocalAppController","Controller");

class HeadquartersController extends LocalAppController {

	public $uses = array("Dailyop");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	public function index() {
		
		
			
	}

}