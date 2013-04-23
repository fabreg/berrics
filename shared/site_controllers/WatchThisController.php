<?php
App::uses("DailyopsController","Controller");


class WatchThisController extends DailyopsController {


	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

	}


	public function view() {



	}

	public function section() {
		
		$this->view = "/Dailyops/section";

		return parent::section();

	}


}