<?php

App::uses("UnifiedAppController","Unified.Controller");

class SiteController extends UnifiedAppController {

	public $uses = array("UnifiedStore");

	public function beforeFilter() {
		
		//enforce ssl for some shit

		if(in_array($this->request->params['action'],array("signup"))) {

			$this->enforceSSL();

		}

		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();



	}

	public function index() {

		$this->set("body_element","layout/unified-body-element");


		//get all the stores


		$s = $this->UnifiedStore->find("all",array(
						"contains"=>array(
							"GeoLocation"
						),
						"order"=>array(
							"UnifiedStore.shop_name"=>"ASC"
						)
				));

		$stores = array();

		foreach($s as $v) $stores[$v['UnifiedStore']['id']] = $v;

		$this->set(compact("stores"));

	}


	public function signup() {



	}

	


}
