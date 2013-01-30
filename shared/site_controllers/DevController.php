<?php

App::uses('LocalAppController','Controller');

/**
* 
*/
class DevController extends LocalAppController {
	

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	public function index() {

		$this->loadModel('Dailyop');
		
		$this->layout = "version3";

		$todays_date = date("Y-m-d");

		$posts = $this->Dailyop->find("all",array(
					"conditions"=>array(
						"DATE(Dailyop.publish_date) = '{$todays_date}'",
						"Dailyop.active"=>1,
						"Dailyop.hidden"=>0
					),
					"contain"=>array(
						"Tag"=>array(
							"User",
							"Brand",
						),
						"DailyopMediaItem"=>array(
							"order"=>array(
								"DailyopMediaItem.display_weight"=>"ASC"
							),
							"limit"=>1,
							"MediaFile"
						),
						"DailyopTextItem"=>array(
							"order"=>array(
								"DailyopTextItem.display_weight"=>"ASC"
							),
							"limit"=>1,
							"MediaFile"
						),
						"DailyopSection"
					),
					"limit"=>3,
					"order"=>array(
						"Dailyop.publish_date"=>"DESC"
					)
		));

		$this->set(compact("posts"));

	}



}