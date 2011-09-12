<?php

class BatbAppController extends AppController {
	
	public $app_name = "Batb4";
	
	public $batb_event_id = 50016;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
        $this->Auth->loginAction = array('controller' => 'login', 'action' => 'batb_login','plugin'=>'identity');
				
	}
	
}

?>