<?php

App::uses("UnifiedAppController","Unified.Controller");

class StoreController extends UnifiedAppController {


	public $uses = array("UnifiedStoreHour");

	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->deny();

		$this->initPermissions();

	}

	public function add($store_id) {
		
	}

	public function edit($id = false) {
		# code...
	}

}