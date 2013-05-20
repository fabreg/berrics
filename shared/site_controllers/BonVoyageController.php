<?php

App::uses("DailyopsController","Controller");

class BonVoyageController extends DailyopsController {

	public $uses = array();

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

		$this->request->params['view'] = 
		$this->request->params['action'] = "view";


	}

	public function section() {
		



	}

	public function view() {
		
		$post = $this->Dailyop->returnPost();

		
		
		$this->set(compact("post"));

	}

}
