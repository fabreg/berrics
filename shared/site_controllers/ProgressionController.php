<?php

App::uses("DailyopsController","Controller");

class ProgressionController extends DaiyopsController {


	public function beforeFilter() {

		parent::beforeFilter();

		if($this->request->params['action'] == "view") {

			$this->request->params['action'] = $this->view = "section";

		}

	}


	public function section() { 



	}

}