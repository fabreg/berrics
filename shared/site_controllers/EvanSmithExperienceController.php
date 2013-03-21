<?php

App::uses("LocalAppController","Controller");


class EvanSmithExperienceController extends LocalAppController {

	public $uses = array();

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

		$this->theme = "evan-smith-experience";


	}

	public function section() {
		
		$this->set("body_element","layouts/evan-smith");

		$post = $this->Dailyop->returnPost(array("Dailyop.id"=>6784),1);

		$this->set(compact("post"));
		
	}

}
