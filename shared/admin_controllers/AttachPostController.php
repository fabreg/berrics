<?php

App::uses("LocalAppController","Controller");

class AttachPostController extends LocalAppController {


	public $uses = array("DailyopSection","Dailyop","UnifiedStoreMediaItem");


	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->initPermissions();

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

	public function index($model = false,$field = false,$foreignKey = false) {
		
		if(!$model) throw new BadRequestException("There needs to be a model specified");
		if(!$field) throw new BadRequestException("There needs to be a field specified");
		if(!$foreignKey) throw new BadRequestException("There needs to be a foreign Key Passed IN");

		if($this->request->is("post") || $this->request->is("put")) {
			
			foreach ($this->request->data['AttachPost']['id'] as $k => $v) {
				
				switch(strtolower($model)) {

					case "unifiedstoremediaitem": //unified store

						$this->UnifiedStoreMediaItem->create();

						$data = array(
							$field=>$foreignKey,
							"dailyop_id"=>$v,
							"display_weight"=>99
						);

						if(isset($this->request->params['named']['category'])) 
							$data['category'] = $this->request->params['named']['category'];

						$this->UnifiedStoreMediaItem->save($data);
						
					break;


				}


			}
			
			$this->Session->setFlash("Posts attached successfully");

			$cb = base64_decode($this->request->params['named']['cb']);

			$this->redirect($cb);

			return;

		}

	}


	public function browse() {
		


		$this->Paginator->settings = array(
					"Dailyop"=>array(
						"contain"=>array(
							"DailyopSection"
						),
						"limit"=>50,
						"order"=>array("Dailyop.publish_date"=>"DESC")
					)
				);

		if(isset($this->request->params['named']['Dailyop.name'])) {

			$this->Paginator->settings['Dailyop']['conditions']['Dailyop.name LIKE'] = "%".str_replace(" ","%",urldecode($this->request->params['named']['Dailyop.name']))."%";

			$this->request->data['Dailyop']['name'] = urldecode($this->request->params['named']['Dailyop.name']);

		}


		if(isset($this->request->params['named']['Dailyop.sub_title'])) {

			$this->Paginator->settings['Dailyop']['conditions']['Dailyop.sub_title LIKE'] = "%".str_replace(" ","%",urldecode($this->request->params['named']['Dailyop.sub_title']))."%";

			$this->request->data['Dailyop']['sub_title'] = urldecode($this->request->params['named']['Dailyop.sub_title']);

		}


		if(isset($this->request->params['named']['Dailyop.dailyop_section_id'])) {

			$this->Paginator->settings['Dailyop']['conditions']['Dailyop.dailyop_section_id'] = 
			$this->request->data['Dailyop']['dailyop_section_id'] = urldecode($this->request->params['named']['Dailyop.dailyop_section_id']);

			

		}




		$posts = $this->paginate("Dailyop");

		$dailyopSections = $this->Dailyop->DailyopSection->returnSelectList();
		$this->set(compact("dailyopSections","posts"));

	}


}
