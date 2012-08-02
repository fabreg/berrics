<?php


App::import("Controller","LocalApp"); 

class LevisController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
		$this->Auth->deny("upload_image");
		
		$this->Auth->loginAction['action'] = "form";
		
		$this->initPermissions();
		
		$this->theme = "levis-511-contest";
		
		$this->Session->write("here",$this->here);
		
		//die(print_r($this->Auth));
		
	}
	
	public function section() {
		
		
		
		
	}
	
	public function view() {
		
		
		
	}
	
	public function upload_image() {
		
	
		
	}
	
	
}