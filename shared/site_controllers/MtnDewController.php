<?php

App::uses("DailyopsController","Controller");

class MtnDewController extends DailyopsController {


	public $uses = array("Dailyops");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->theme = "mtn-dew";

	}

	public function section() {
		
		$this->loadModel('Dailyop');
		
		$post_ids = $this->Dailyop->DailyopsTag->find("all",array(
						"fields"=>array(
							"DailyopsTag.dailyop_id"
						),
						"conditions"=>array(
							"DailyopsTag.tag_id"=>3388
						),
						"contain"=>array()
					));

		$post_ids = Set::extract("/DailyopsTag/dailyop_id",$post_ids);

		
		$posts = $this->Dailyop->find("all",array(
					"conditions"=>array(
						"Dailyop.id"=>$post_ids,
						"Dailyop.active"=>1,
						"Dailyop.publish_date < NOW()"
					),
					"contain"=>array(
							"DailyopMediaItem"=>array(
								
								"MediaFile"=>array(
			
								),
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
							),
							"User"=>array(

							),
							"DailyopSection"=>array(

							),
							"Tag"=>array(

								"User"
							),
							"Meta",
							"DailyopTextItem"=>array(
								"MediaFile"=>array(

								),
								"order"=>array("DailyopTextItem.display_weight"=>"ASC")
							)
					
					),
					"order"=>array("Dailyop.publish_date"=>"DESC")
				));

		$this->set(compact("posts"));

	}


}
