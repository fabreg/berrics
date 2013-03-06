<?php

App::uses('UnifiedAppController','Unified.Controller');

class MediaItemController extends UnifiedAppController {


	public $uses = array('UnifiedStoreMediaItem');

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->deny();

		$this->initPermissions();

	}

	public function add_image() {

		

	}

	public function upload_video() {



	}

	public function attach_media_item() {



	}


}