<?php

App::uses("UnifiedAppController","Unified.Controller");

class HoursController extends UnifiedAppController {


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

	public function add_custom($store_id) {
			
		$this->set(compact("store_id"));

		if($this->request->is("post") || $this->request->is("put")) {
		
			$this->UnifiedStoreHour->setCustomLabelValidation();

			if($this->UnifiedStoreHour->validates()) {

				if($this->UnifiedStoreHour->save($this->request->data)) {

					die("<script> $('#UnifiedStoreForm').trigger('submit'); </script>");

				}



			} else {



			}
		
		}	

	}

}