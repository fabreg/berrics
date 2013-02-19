<?php

App::uses("LocalAppController","Controller");

class AttachMediaController extends LocalAppController {

	public $uses = array("MediaFile");

	public function beforeFilter() {

		parent::beforeFilter();

		$this->initPermissions();

	}

	public function index($model = false,$field = false,$foreignKey = false) {

		if(!$model) throw new BadRequestException("There needs to be a model specified");
		if(!$field) throw new BadRequestException("There needs to be a field specified");
		if(!$foreignKey) throw new BadRequestException("There needs to be a foreign Key Passed");

		if($this->request->is("post")) {
		
			$m = ClassRegistry::init($model);
			
			foreach($this->request->data['AttachMedia']['id'] as $v) {

				$m->create();

				switch(strtoupper($model)) {

					case "DAILYOPMEDIAITEM":
						
						$m->save(array(
							$field=>$foreignKey,
							"display_weight"=>99,
							"media_file_id"=>$v
						));
					break;

				}

			}

			$this->Session->setFlash("Media Files attached successfully");

			$this->redirect(base64_decode($this->request->params['named']['cb'])."?tab=media");

		
		}


	}

	
	public function filter() {
		
		$url = array(
		
			"action"=>"browse",
			"search"=>true
		);
		
		
		foreach($this->request->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				if(empty($vv)) continue;

				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
		
		return $this->redirect($url);
		
		
	}
	
	public function browse() {
		
		$this->Paginator->settings = array();

		$this->Paginator->settings['MediaFile'] = array(
			"limit"=>50,
			"order"=>array(
				"MediaFile.modified"=>"DESC"
			),
			"contain"=>array(
				"Website"
			)
		);

		if(isset($this->request->params['named']['MediaFile.name'])) {

			$this->request->data['MediaFile']['name'] = urldecode($this->request->params['named']['MediaFile.name']);

			$this->Paginator->settings['MediaFile']['conditions']['MediaFile.name LIKE'] = "%".str_replace(" ","%",urldecode($this->request->params['named']['MediaFile.name']));

		}

		if(isset($this->request->params['named']['MediaFile.media_type'])) {


		}

		if(isset($this->request->params['named']['MediaFile.website_id'])) {

			$this->Paginator->settings['MediaFile']['conditions']['MediaFile.website_id'] = 
			$this->request->data['MediaFile']['website_id'] = 
				$this->request->params['named']['MediaFile.website_id'];

		} else { //default it at the berrics

			$this->request->data['MediaFile']['website_id'] =
			$this->Paginator->settings['MediaFile']['conditions']['MediaFile.website_id'] = 1;

		}


		$websites = $this->MediaFile->Website->dropdown();

		$mediaTypes = MediaFile::mediaFileTypes();

		$files = $this->paginate("MediaFile");

		$this->set(compact("files","websites","mediaTypes"));

	}

}
