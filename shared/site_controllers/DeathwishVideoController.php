<?php

App::uses('DailyopsController','Controller');

class DeathwishVideoController extends DailyopsController {


	public $uses = array();

	public function beforeFilter() {
		
		parent::beforeFilter();

		if(in_array($this->request->params['action'],array(
				'view'
			))) {

			$this->request->params['action'] = "section";
			$this->view = 'section';


		}

		$this->theme = "deathwish-video";

		$this->set('body_element','body-element');

	}

	public function section() {

		$post = $this->Dailyop->returnPost(array("Dailyop.id"=>6985),$this->isAdmin());

		$this->set("post",$post);

	}


}