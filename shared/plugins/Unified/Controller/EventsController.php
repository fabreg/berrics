<?php

App::uses("UnifiedAppController","Unified.Controller");

class EventsController extends UnifiedAppController {

	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->deny();

		$this->initPermissions();

	}

}