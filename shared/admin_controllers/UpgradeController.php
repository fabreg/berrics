<?php

/**
* 
*/

App::uses("LocalAppController","Controller");

class UpgradeController extends LocalAppController
{
	
	public $uses = array();

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->initPermissions();


	}

	public function fix_user_tags() {

		$this->loadModel("TagsUser");
		$this->loadModel("User");
		$this->loadModel("Tag");

		//get all the tags
		$ut = $this->TagsUser->find('all');

		foreach($ut as $v) {

			$this->Tag->create();
			$this->Tag->id = $v['TagsUser']['tag_id'];

			$this->Tag->save(array(
					"user_id"=>$v['TagsUser']['user_id']
				));

		}


	} 

	public function fix_trickipedia() {
		
		$this->loadModel('Dailyop');
		$posts = $this->Dailyop->find('all',array(
			"conditions"=>array(
				'Dailyop.dailyop_section_id'=>4
			),
			"contain"=>array(
				"DailyopMediaItem"=>array(
					"MediaFile"
				)
			)
		));


		foreach ($posts as $key => $v) {
			
			foreach ($v['DailyopMediaItem'] as $k => $val) {
				
				$this->Dailyop->DailyopMediaItem->create();

				$this->Dailyop->DailyopMediaItem->id = $val['id'];

				switch(strtoupper($val['MediaFile']['media_type'])) {

					case 'IMG':
						$seed = 2;
					break;
					default:
						$seed = 1;
					break;


				}

				$this->Dailyop->DailyopMediaItem->save(array(
					"display_weight"=>$seed
				));

			}

		}


	}

}