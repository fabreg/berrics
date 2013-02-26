<?php

App::uses("UnifiedAppController","Unified.Controller");

class BrandsController extends UnifiedAppController {


	public $uses = array("UnifiedStoreBrand");

	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->deny();

		$this->initPermissions();

	}

	public function brand_list() {

		$cond = array();

		if($this->request->is("post")) {
			
			$ids = Set::extract("/Brand/id",$this->request->data);

			$cond['NOT'] = array(
				"Brand.id"=>$ids
			);

		}

		$brands = $this->UnifiedStoreBrand->Brand->find('all',array(
					"conditions"=>$cond,
					"contain"=>array(),
					"order"=>array(
						"Brand.name"=>"ASC"
					)
				));

		$this->set(compact("brands"));

	}


}