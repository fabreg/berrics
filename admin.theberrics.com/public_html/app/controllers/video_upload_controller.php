<?php

App::import("Controller","AdminApp");


class VideoUploadController extends AdminAppController {
	
	
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