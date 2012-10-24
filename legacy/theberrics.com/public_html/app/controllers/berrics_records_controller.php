<?php


App::import("Controller","Dailyops");


class BerricsRecordsController extends DailyopsController {
	
	
	public function beforeFilter() {
		
		if(	
			isset($_GET['xid']) && 
			$_GET['xid'] != "undefined" && 
			!empty($_GET['xid']) && 
			$this->params['action'] == "handle_upload"
		) {
			
			$this->Session->id($_GET['xid']);
			
			$this->Session->start();
			
		}
		
		parent::beforeFilter();
		
		$this->Auth->allowedActions = array();
		
		$this->Auth->allow("section","view");
		$this->Auth->deny("challenge","handle_upload");
		
		$this->initPermissions();
		
		
	
		
		//die(print_r($this->Auth));
		
		$this->theme = "for-the-record";
		
		if($this->params['action'] == "view") {
			
			$this->params['action'] = "section";
			
		}
		
	}
	
	
	public function section() {
		
		if(isset($this->params['uri'])) {
			
			$this->setPost();
			
		}
		
		$records = $this->BerricsRecord->getRecords();
		
		$this->set(compact("records"));
		
	}
	
	public function challenge($record_id = false) {
		
		if(!$record_id) return $this->cakeError("error404");
		
		//get the post
		$record_id = base64_decode($record_id);
		
		$record = $this->BerricsRecord->find("first",array(
			"conditions"=>array(
				"BerricsRecord.id"=>$record_id,
				"BerricsRecord.active"=>1,
				"BerricsRecord.publish_date<NOW()"
			),
			"contain"=>array(
				"BerricsRecordsItem"=>array(
					"conditions"=>array(
						"BerricsRecordsItem.current_record"=>1,
						"BerricsRecordsItem.active"=>1,
					),
					"User",
					"Dailyop"
				)
			)
		));
		
		if(!isset($record['BerricsRecord']['id']) || count($record['BerricsRecordsItem'])<=0) {
			
			return $this->cakeError("error404");
			
		}
		
		$this->set(compact("record"));
		
	}
	
	public function handle_upload() {
		
		$file = $_FILES['Filedata'];
		
	
		App::import("Vendor","UploadServer",array("file"=>"UploadServer.php"));
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$u = new UploadServer();
		
		$tmp_file = $u->moveUpload($file);
		
		$file_name = String::uuid().".".$ext;
		
		if($u->pushUpload($tmp_file,$file_name)) {
			
			$this->loadModel("MediaFileUpload");
			
			$this->MediaFileUpload->create();
			
			$this->MediaFileUpload->save(array(
			
				"file_name"=>$file_name,
				"name"=>$file['name'],
				"model"=>"BerricsRecord",
				"foreign_key"=>base64_decode($_POST['berrics_record_id']),
				"user_id"=>$this->user_id_scope
			
			));
			
			die("1");
			
		} else {
			
			die("0");
		}
		
	}
	
	private function setPost() {
		
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array(
			"Dailyop.uri"=>$this->params['uri'],
			"DailyopSection.uri"=>$this->params['section']
		));
		
		$this->setFacebookMetaImg($post['DailyopMediaItem'][0]['MediaFile']);
		
		$this->set(compact("post"));
		
	}
	
}