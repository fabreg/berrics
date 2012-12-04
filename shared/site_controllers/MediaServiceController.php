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

		$handheld = false;

		if(
				$this->request->is('mobile') && 
				preg_match('/(iPhone|iPod)/',$_SERVER['HTTP_USER_AGENT'])
			) {

			$handheld = true;

		}


		if(isset($this->request->data['dailyop_id'])) {

			$Post = $this->Dailyop->returnPost(array(
				'Dailyop.id'=>$this->request->data['dailyop_id']
			),$this->isAdmin());

		}

		if(!empty($MediaFile['MediaFile']['preroll_label'])) {

			if($handheld) {

				$data[]['AdUrl'] = 'http://pubads.g.doubleclick.net/gampad/ads?sz=320x180&iu=/5885/MVPRE001&ciu_szs&impl=s&gdfp_req=1&env=vp&output=xml_vast2&unviewed_position_start=1&url=[referrer_url]&correlator=[timestamp]';

			} else {

				$data[]['AdUrl'] = MediaFile::formatVastUrl($MediaFile['MediaFile']['preroll_label']);

			}

			

		}

		$d['MediaFile'] =  $MediaFile['MediaFile'];
		if(isset($Post)) $d['Dailyop'] = $Post;
		if($handheld && !empty($d['MediaFile']['limelight_file_mobile'])) $d['MediaFile']['limelight_file'] = $d['MediaFile']['limelight_file_mobile'];

		$data[] = $d;

		if(!empty($MediaFile['MediaFile']['postroll_label'])) {

			//$data[]['AdUrl'] = MediaFile::formatVastUrl($MediaFile['MediaFile']['postroll_label']);

		}

		$this->set(compact("data"));

	}


}