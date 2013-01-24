<?php

App::uses("LocalAppController","Controller");

class HeadquartersController extends LocalAppController {

	public $uses = array("Dailyop","User");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	public function index() {
		
		//get all the employees

		$users = $this->User->find("all",array(
					"conditions"=>array(
						"User.berrics_employee"=>1,
						"User.active"=>1
					),
					"contain"=>array(),
					"group"=>array("User.employee_group")
				));
		
		$groups = array();

		foreach ($users as $k => $v) {
			
			$groups[$v['User']['employee_group']][] = $v;

		}


		$this->set(compact("groups"));


	}

}