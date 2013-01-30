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
					),
					"contain"=>array(),
					"order"=>array(
						"User.employee_group"=>"ASC",
						"User.first_name"=>"ASC"
					)
				));
		
		$groups = array();

		foreach ($users as $k => $v) {
			
			$groups[$v['User']['employee_group']][] = $v;

		}

		//push in the canteen
		$groups['unified'][] = array(
								"User"=>array(
									"first_name"=>"The Berrics",
									"last_name"=>"Canteen",
									"berrics_email"=>"canteen@theberrics.com"
								)
							);

		$groups['general'][] = array(
								"User"=>array(
									"first_name"=>"Trickipedia",
									"last_name"=>"Request",
									"berrics_email"=>"trickipedia@theberrics.com"
								)
							);

		$groups['general'][] = array(
								"User"=>array(
									"first_name"=>"Watch",
									"last_name"=>"This",
									"berrics_email"=>"watchthis@theberrics.com"
								)
							);

		//push in support
		$groups['website'][] = array(
								"User"=>array(
									"first_name"=>"Website",
									"last_name"=>"Support",
									"berrics_email"=>"support@theberrics.com"
								)
							);

		$groups['bizdev'][] = array(
								"User"=>array(
									"first_name"=>"Advertising",
									"last_name"=>"Inquiries",
									"berrics_email"=>"advertising@theberrics.com"
								)
							);

		$this->set(compact("groups"));


	}

}