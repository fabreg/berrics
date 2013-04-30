<?php

App::uses('DaiyopsController','Controller');

class DeathwishVideoController extends DailyopsController {


	public $uses = array();

	public function beforeFilter() {
		
		parent::beforeFilter();

		if(in_array($this->request->params['action'],array(
				'view'
			))) {

			$this->request->params['action'] = "section";
			$this->view = 'section';


		}

	}

	public function section() {



	}


}