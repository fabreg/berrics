<?php

App::uses("LocalAppController","Controller");

class DailyopsV3Controller extends LocalAppController {


	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

		$this->layout = "version3";

	}


	public function index() {
		
		$this->loadModel('Dailyop');
		
		$this->layout = "version3";

		$date = date("Y-m-d");

		//$date = '2011-10-15';

		$posts = $this->Dailyop->find("all",array(

			"conditions"=>array(
				"DATE(Dailyop.publish_date)" => $date,
				"Dailyop.active"=>1,
				"Dailyop.hidden"=>0
			),
			"order"=>array(
				"Dailyop.publish_date"=>"DESC"
			),
			"contain"=>array(
				"DailyopMediaItem"=>array(
					"MediaFile",
					"limit"=>1,
					"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
				),
				"DailyopSection",
				"Tag"=>array(
					"User",
					"Brand"
				)
			)

		));

		$this->setTrendingContent();

		$this->set(compact("posts"));

	}

	public function setTrendingContent() {
		
		$this->loadModel('Dailyop');
		
		//get get the last 5 battle commanders

		$trending = $this->Dailyop->find("all",array(

			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>1,
				"Dailyop.active"=>1
			),
			"contain"=>array(
				"DailyopSection",
				"DailyopMediaItem"=>array(
					"MediaFile",
					"order"=>array(
						"DailyopMediaItem.display_weight"=>"ASC"
					),
					"limit"=>1
				)
			),
			"limit"=>5

		));

		$this->set("trending_posts",$trending);
			

	}

	public function section() {
		
	}



	########################################
	# TEST METHODS
	########################################
	public function video_controls() {
		
		$this->layout = "version3";

	}

	public function ajax_video_play() {

		die('<video src="http://berrics.vo.llnwd.net/o45/50a26e34-9974-4db5-80cd-6f88c6659e49.mp4" autoplay="true" controls="true"></video>');

	}


}
