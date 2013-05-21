<?php

App::uses("DailyopsController","Controller");

class BonVoyageController extends DailyopsController {

	public $uses = array();

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

		$this->view = 
		$this->request->params['action'] = "view";

		$this->theme = "bon-voyage";

		$this->set("body_element","body-element");

	}

	public function section() {
		
		

	}

	public function view() {
		
		$post = $this->Dailyop->returnPost(array(
					"Dailyop.id"=>7081
				),$this->isAdmin());


		$this->set(compact("post"));

	}

}
