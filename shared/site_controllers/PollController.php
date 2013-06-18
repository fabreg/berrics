<?php

App::uses("LocalAppController","Controller");

class PollController extends LocalAppController {


	public $uses = array("Poll");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}



}