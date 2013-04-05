<?php

App::uses("DailyopsController","Controller");

class ProgressionController extends DailyopsController {


	public function beforeFilter() {

		parent::beforeFilter();

		$this->request->params['action'] = 
		$this->view = "dailyops";



	}

	public function dailyops() {

		$this->theme = "progression";

		$this->set("body_element","layout/v3/one-column");

		//get the post
		$this->loadModel('Dailyop');

		$post = $this->Dailyop->returnPost(array(
					"Dailyop.id"=>6848
				),$this->isAdmin());
		
		$this->setFacebookMetaImg($post["DailyopMediaItem"][0]['MediaFile']);

		$this->set(compact("post"));

	}

}