<?php

App::uses('LocalAppController','Controller');

/**
* 
*/
class DevController extends LocalAppController {
	

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	public function index() {

		$this->layout = "version3";



	}



}