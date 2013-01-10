<?php 

App::uses("DailyopsController","Controller");

class Batb6Controller extends DailyopsController {


	public function beforeFilter() {



		parent::beforeFilter();

		$this->theme = "battle-at-the-berrics-6";



	}

	public function section() {

		//set the body element
		$this->set("body_element","layout/body-element");

		$this->loadModel('BatbEvent');
			
		//get the event //batb6 = 50019
		$event = $this->BatbEvent->returnEvent(50018);
		
		$this->set(compact("event"));

		

	}

	public function view() {






	}



}
