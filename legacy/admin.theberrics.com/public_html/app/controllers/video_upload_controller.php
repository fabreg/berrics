<?php

App::import("Controller","LocalApp");


class VideoUploadController extends LocalAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function index() {
		
		
	}
	
	public function ajax_upload_form() {
		
		
		
	}
	
	
	
	
}