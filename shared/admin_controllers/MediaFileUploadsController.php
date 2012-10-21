<?php

App::import("Controller","LocalApp");
App::import("Vendor","UploadServer",array("file"=>"UploadServer.php"));

class MediaFileUploadsController extends LocalAppController {
	
	
	public $uses = array("MediaFileUpload");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->set("upload_server","50.57.104.64");
		
	}
	
	public function index() {
		
		$this->Paginator->settings = array();

		$this->Paginator->settings['MediaFileUpload'] = array(
			"limit"=>100,
			"order"=>array("MediaFileUpload.id"=>"DESC"),
			"contain"=>array(
				"User"
			)
		);
		
		$data = $this->paginate("MediaFileUpload");
		
		$this->set(compact("data"));
		
	}
	
	public function edit() {
		
		
		
	}
	
	public function test() {
		
		if(count($this->request->data)>0) {
			
			$us = new UploadServer();
			
			$file = $this->request->data['MediaFileUpload']['test'];
			
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
	
	public function dashboard() {
		
		$now = date('Y-m-d');
		$this_month = date("m");
		$this_year = date("Y");
		$past_seven = date("Y-m-d",strtotime("-7 Days"));
		
		//get todays
		$today = $this->MediaFileUpload->find('count',array(
					"conditions"=>array(
						"DATE(MediaFileUpload.created) ='{$now}'"		
					)
				));
		
		$past_seven = $this->MediaFileUpload->find('count',array(
						"conditions"=>array(
								"DATE(MediaFileUpload.created) ='{$past_seven}'"
							)
						));
		
		//get all this month
		$month = $this->MediaFileUpload->find('count',array(
					"conditions"=>array(
						"YEAR(MediaFileUpload.created) = '{$this_year}'",
						"MONTH(MediaFileUpload.created) = '{$this_month}'"		
					)
				));
		
		$this->set(compact("today","month","past_seven"));
		
	}
	
	
	
	
}