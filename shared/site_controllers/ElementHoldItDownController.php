<?php

App::uses("DailyopsController","Controller");


class ElementHolditDownController extends DailyopsController {

	public $uses = array("Dailyop","OndemandTitle");

	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->allow();

		$this->theme = "hold-it-down";



		if($this->request->params['action'] == "section") {

			$this->setPost("element-eu-hold-it-down","intro.html");

		}

		if($this->request->params['action'] == "view") {

			$this->request->params['action'] = 
			$this->view = "section";
			$this->setPost();

		}

	}

	public function view() {



	}

	public function section() {


		$this->set("body_element","layout/body-element");

		$title = $this->OndemandTitle->returnTitle(5);

		$this->set(compact("title"));

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


}

