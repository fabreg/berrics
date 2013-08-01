<?php

App::uses("LocalAppController", "Controller");

class RunAndGunController extends LocalAppController {


	public $uses = array("RgVote","Dailyop");

	private $section_id = 103;

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->initPermissions();

	}

	public function index() {
		
		//get all the run and gun posts

		$posts = $this->Dailyop->find('all',array(
					"conditions"=>array(
						"Dailyop.dailyop_section_id"=>$this->section_id
					),
					"contain"=>array(

					),
					"order"=>array("Dailyop.publish_date"=>"ASC")
				));


		$this->set(compact("posts"));

	}

	public function grab_score($dailyop_id) {
		
		$score = $this->RgVote->getPostAverage($dailyop_id);

		die(json_encode($score));

	}



}
