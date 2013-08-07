<?php

App::uses("LocalAppController","Controller");

class CalendarController extends LocalAppController {

	public $uses = array();

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	public function index($year = false,$month = false) {
		
		if(!$year) $year = date("Y");

		if(!$month) $month = date("m");

		$this->set(compact("year","month"));

		//get the content for the month

		$this->loadModel('Dailyop');
		
		$posts = $this->Dailyop->find("all",array(

					"conditions"=>array(
						"YEAR(Dailyop.publish_date) = '{$year}'",
						"MONTH(Dailyop.publish_date) = '{$month}'",
						"Dailyop.active"=>1,
						"Dailyop.hidden"=>0,
						"Dailyop.publish_date < '".AppModel::awsNow()."'"
					),
					"contain"=>array(
						"DailyopSection"
					)
				));

		$content = array();

		foreach($posts as $p) {

			$date = date("Y-m-d",strtotime($p['Dailyop']['publish_date']));

			$content[$date][] = $p;

		}

		$this->set(compact("content"));

	}

}