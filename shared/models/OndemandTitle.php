<?php

class OndemandTitle extends AppModel {
	
	
	public $belongsTo = array(
		"User"
	);
	
	public $hasAndBelongsToMany = array(
		"Tag",
	);
	public $hasMany = array(
				"Dailyop"
			);
	
	public function returnTitle($id) {

		$token = "ondemand-title-{$id}";

		if(($data = Cache::read($token,"1min")) === false) {

			$data = $this->find("first",array(
						"conditions"=>array(
							"OndemandTitle.id"=>$id
						),
						"contain"=>array(
							"Dailyop"=>array(
								"DailyopMediaItem"=>array(
									"MediaFile",
									"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
								),
								"order"=>array("Dailyop.display_weight"=>"ASC")
							)
						)
					));

			//Cache::write($token,$data,"1min");

		}

		return $data;

	}

	public function returnTitleMediaVO($id) {
		
		$title = $this->find("first",array(
					"conditions"=>array(
						"OndemandTitle.id"=>$id
					),
					"contain"=>array(
						"Dailyop"=>array(
							"order"=>array(
								"Dailyop.display_weight"=>"ASC"
							),
							"fields"=>array("Dailyop.id",'Dailyop.display_weight'),
							"DailyopMediaItem"=>array(
								"MediaFile"=>array(
									"fields"=>array("MediaFile.id")
								),
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
								"limit"=>1
							)
						)
					)
				));

		$videos = array();
		//die(pr($title));
		foreach($title['Dailyop'] as $k=>$v) {

			$videos[$v['display_weight']] = $this->Dailyop->DailyopMediaItem->MediaFile->returnVideoVO($v['DailyopMediaItem'][0]['MediaFile']['id'],$v['id']);

		}

		return $videos;

	}
	
}