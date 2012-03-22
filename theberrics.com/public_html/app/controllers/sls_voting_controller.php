<?php

App::import("Controller","Dailyops");

class SlsVotingController extends DailyopsController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->theme = "sls-voting";
		
	}
	
	public function section() {
		
		//get all the entires
		$entries = $this->SlsEntry->find("all",array(
			"conditions"=>array(
				"SlsEntry.active"=>1
			),
			"contain"=>array(),
			"order"=>array(
				"SlsEntry.sort_order"=>"ASC"
			)
		));
		
		
		$this->set(compact("entries"));
		
	}
	
	public function view() {
		
		
		
	}
	
	public function place_vote() {
		
		
	}
	
	
}