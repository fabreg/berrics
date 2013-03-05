<?php

App::uses("UnifiedAppController","Unified.Controller");

class SiteController extends UnifiedAppController {

	public $uses = array();

	public function beforeFilter() {
		
		//enforce ssl for some shit

		if(in_array($this->request->params['action'],array("signup"))) {

			$this->enforceSSL();

		}

		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

		if(isset($this->request->params['uri'])) {

			$this->setHeroUnit();

		}

	}

	public function index() {

		$this->set("body_element","unified-body-element");

	}


	public function signup() {



	}

	


}
