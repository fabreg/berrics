<?php
App::uses('UnifiedAppController', 'Unified.Controller');
/**
 * Unifieds Controller
 *
 */
class UnifiedController extends UnifiedAppController {

	public $uses = array();

	public function beforeFilter() {

		parent::beforeFilter();

		$this->initPermissions();

		$this->Auth->allow();

	}


	public function index() {
		
		
		
	}


}
