<?php

App::uses("UnifiedAppController","Unified.Controller");

class EmployeesController extends UnifiedAppController {


	public $uses = array("UnifiedStoreEmployee","UnifiedStore");

	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->deny();

		$this->initPermissions();

		

	}

	public function add($store_id = false) {

		if(!$store_id) throw new InvalidRequestException("Invalid Link");

		$this->UnifiedStore->UnifiedStoreEmployee->setEmployeeValidation($this->request->data);

		if($this->request->is("post") || $this->request->is("put")) {
		
			if($this->UnifiedStore->UnifiedStoreEmployee->validates()) {

				$this->request->data['UnifiedStoreEmployee']['image_file'] = $this->UnifiedStoreEmployee->uploadImage($this->request->data['UnifiedStoreEmployee']['image_file']);

				$this->UnifiedStore->UnifiedStoreEmployee->save($this->request->data,false);

				die("<script> $('#UnifiedStoreForm').trigger('submit'); </script>");

			} else {

				$this->Session->setFlash("Please correct the fields marked in red");

			}

			
		
		} else {

			$this->request->data['UnifiedStoreEmployee']['unified_store_id'] = $store_id;

		}

		
		$this->view = "/Elements/employee/edit";

	}

	public function edit($id) {

		if($this->request->is("post") || $this->request->is("put")) {
			
			$this->UnifiedStoreEmployee->setEmployeeValidation($this->request->data);

			if($this->UnifiedStoreEmployee->validates()) {

				$this->UnifiedStoreEmployee->create();
				$this->UnifiedStoreEmployee->id = $this->request->data['UnifiedStoreEmployee']['id'];

				if(isset($this->request->data['UnifiedStoreEmployee']['image_file']['tmp_name'])) {

					$this->request->data['UnifiedStoreEmployee']['image_file'] = $this->UnifiedStoreEmployee->uploadImage($this->request->data['UnifiedStoreEmployee']['image_file']);

				} else {

					unset($this->request->data['UnifiedStoreEmployee']['image_file']);

				}

				$this->UnifiedStoreEmployee->save($this->request->data,false);

				die("<script> $('#UnifiedStoreForm').trigger('submit'); </script>");

			} else {

				$this->Session->setFlash("Please correct the fields marked in red");

			}
		
		}

		$this->request->data = $this->UnifiedStoreEmployee->returnAdminEmployee($id);

		$this->view = "/Elements/employee/edit";

	}

}
