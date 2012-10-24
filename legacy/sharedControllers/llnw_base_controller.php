<?php

class LlnwBaseController extends AppController {
	
	
	public $uses = array("User","MediaFile");
	
	
	private $secret_key = '';
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();

		
		
	}
	
	public function request_media_vault_file() {
		
		
		
	}
	
	
}