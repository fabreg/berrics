<?php 

App::uses("LocalAppController","Controller");

class MediaServiceController extends LocalAppController {


	public $uses = array(
		"MediaFile"
	);


	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}


	public function video_player_request() {
		
		$this->layout = "ajax";

		$data = array();

		$media_file_id = (isset($this->request->data['media_file_id'])) ? 
				$this->request->data['media_file_id']:'4d6ed946-4d48-4735-8272-37a20ab5431b';

		$MediaFile = $this->MediaFile->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$media_file_id
			),
			"contain"=>array()
		));

		if(!empty($MediaFile['MediaFile']['preroll_label'])) {

			$data[]['AdUrl'] = MediaFile::formatVastUrl($MediaFile['MediaFile']['preroll_label']);

		}

		$data[]['MediaFile'] = $MediaFile['MediaFile'];

		if(!empty($MediaFile['MediaFile']['postroll_label'])) {

			$data[]['AdUrl'] = MediaFile::formatVastUrl($MediaFile['MediaFile']['postroll_label']);

		}

		$this->set(compact("data"));

	}


}