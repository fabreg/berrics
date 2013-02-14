<?php

App::uses("LocalAppController","Controller");

class BonesNewGroundController extends LocalAppController {

	public $uses = array("OndemandTitle","Dailyop");

	public function beforeFilter() {

		parent::beforeFilter();

		$this->initPermissions();

		$this->Auth->allow();

		$this->theme = "bones-new-ground";

		if($this->request->params['action'] == "section") {

			$this->setPost("bones-new-ground","intro.html");

		}

		if($this->request->params['action'] == "view") {

			$this->request->params['action'] = 
			$this->view = "section";
			$this->setPost();

		}



	}

	private function setPost($section = false,$uri = false) {

		if(!$section) $section = $this->request->params['section'];
		if(!$uri) $uri = $this->request->params['uri'];

		$post = $this->Dailyop->returnPost(array(
					"Dailyop.uri"=>$uri,
					"DailyopSection.uri"=>$section
				),$this->isAdmin());

		$this->set(compact("post"));

	}

	public function section() {

		$this->set("body_element","body-element");

		$title = $this->OndemandTitle->returnTitle(1);

		//die(pr($title));

		$this->set(compact("title"));

	}

	public function view() {

		
		
	}


}