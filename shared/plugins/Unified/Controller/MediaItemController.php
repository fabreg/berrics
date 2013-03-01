<?php

App::uses('UnifiedAppController','Unified.Controller');

class MediaItemController extends UnifiedAppController {


	public $uses = array('UnifiedStoreMediaItem');

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->deny();

		$this->initPermissions();

	}


}