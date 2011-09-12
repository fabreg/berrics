<?php

class QsAppController extends AppController {
	
	
	public $app_name = "qs";
	
	public function beforeFitler() {
		

		parent::beforeFiler();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	
	
	
	
	
}


?>