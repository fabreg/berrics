<?php

App::uses("LocalAppController","Controller");

class SupportController extends LocalAppController {

	public $uses = array();


	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->allow();

	}

	public function index() {
		
		

	}


}