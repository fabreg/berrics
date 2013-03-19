<?php

App::uses("LocalAppController","Controller");


class EvanSmithExperience extends LocalAppController {

	public $uses = array();

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->Auth->initPermissions();

	}

	public function section() {
		
		
		
	}

}
