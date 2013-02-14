<?php

App::uses("LocalAppController","Controller");

class BonesNewGroundController extends LocalAppController {

	public $uses = array();

	public function beforeFilter() {

		parent::beforeFilter();

		$this->initPermissions();

		$this->Auth->allow();

	}

	public function section() {



	}

	public function view() {

		
		
	}


}