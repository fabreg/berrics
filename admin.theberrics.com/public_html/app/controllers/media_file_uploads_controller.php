<?php

App::import("Controller","AdminApp");
App::import("Vendor","UploadServer",array("file"=>"UploadServer.php"));

class MediaFileUploadsController extends AdminAppController {
	
	
	public $uses = array("MediaFileUpload");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		$this->paginate['MediaFileUpload'] = array(
			"limit"=>100,
			"order"=>array("MediaFileUpload.id"=>"DESC")
		);
		
		$data = $this->paginate("MediaFileUpload");
		
		$this->set(compact("data"));
		
	}
	
	public function edit() {
		
		
		
	}
	
	public function test() {
		
		if(count($this->data)>0) {
			
			$us = new UploadServer();
			
			$file = $this->data['MediaFileUpload']['test'];
			
			$tmp_path = $us->moveUpload($file);
			
			if(!$tmp_path) {
				
				return $this->cakeError("error500","No temp file brosky");
				
			}
			
			$file_name = String::uuid().".".pathinfo($file['name'],PATHINFO_EXTENSION);
			
			if(!$us->pushUpload($tmp_path,$file_name)) {
				
				return $this->cakeError("error500","Could Not SFTP to UPLAOD server");
				
			}
			
			//save the new file
			$this->loadModel("MediaFileUpload");
			
			$this->MediaFileUpload->create();
			
			$this->MediaFileUpload->save(array(
				"file_name"=>$file_name,
				"user_id"=>$this->Auth->user("id"),
				"model"=>"YounitedNationsEntry",
				"foreign_key"=>2
			));
			
		}
		
		
	}
	
	
	
	
}