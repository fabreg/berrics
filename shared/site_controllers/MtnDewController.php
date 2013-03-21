<?php

App::uses("DailyopsController","Controller");

class MtnDewController extends LocalAppController {


	public $uses = array("Dailyops");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->theme = "mtn-dew";

	}

	public function section() {
		

		
		

	}


}
