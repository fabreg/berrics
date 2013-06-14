<?php

App::import("Controller","LocalApp");

class StaticFilesController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
		
		
	}
	
	
	public function view() {
		
		if(isset($this->request->params['named']['file'])) {
			
			$file_name = $this->request->params['named']['file'];
			
		} else {
			
			$file_name = $this->request->params['file'];
			
		}
		
		$file_name = str_replace(".html","",$file_name);

		return $this->render($file_name);
		
	}
	
	
	
}

?>