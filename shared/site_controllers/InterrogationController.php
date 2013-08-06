<?php

App::uses("DailyopsController","Controller");

class InterrogationController extends DailyopsController {

	public $uses = array();

	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

		if($this->request->params['action'] == 'section') {

			$this->view = "/Dailyops/section";

		}

		

	}

	public function view() {

		$this->loadModel('Dailyop');
		

		$post = $this->Dailyop->returnPost(array(
				"Dailyop.uri"=>$this->request->params['uri'],
				"DailyopSection.uri"=>$this->request->params['section']),
				$this->isAdmin());

		$related = $this->Dailyop->postViewRelated($post);

		$this->set(compact("post","related"));

	}


}

