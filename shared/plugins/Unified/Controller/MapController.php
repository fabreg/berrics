<?php


class MapController extends UnifiedAppController {


	public $uses = array("GeoLocation");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	public function index() {

		$this->set("body_element","layout/v3/one-column");

	}

}