<?php

App::import("Controller","AberricanApp");

class HomeController extends AberricanAppController {
	
	public $uses = array("User","AberricanOriginal");
	
	public function beforeFilter() {
		
		if(in_array($this->params['action'],array("handle_upload"))) {
			
			$this->Session->id($this->params['pass'][0]);
			$this->Session->start();
			
		}
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("index","video");
		
		
	}
	
	
	public function index() {
		
		
		$this->loadModel("Dailyop");
		
		
		$ids = array(
					3240,
					3239,
					3238,
					3237,
					3236,
					3235
				);
		
		//get the posts
		
		$posts = $this->Dailyop->find('all',array(
		
		
			"conditions"=>array(
				"Dailyop.id"=>$ids
			),
			"contain"=>array(
		
				"DailyopMediaItem"=>array(
					"MediaFile",
					"order"=>array(
						"DailyopMediaItem.display_weight"=>"ASC"
					)
				),
				"Meta",
				"DailyopSection"
				
			),
			"order"=>array(
			
				"Dailyop.publish_date"=>"ASC"
			
			)
		
		
		));
		
		if(isset($this->params['uri']) && !empty($this->params['uri'])) {
			
			$viewing = $this->Dailyop->returnPost(array(
				
				"Dailyop.id"=>$ids,
				"Dailyop.uri"=>$this->params['uri']
			
			),1);
			
		} 
		
		if(!isset($viewing['Dailyop']['id'])) {
			
			$v_id = $posts[0]['Dailyop']['id'];
			
			$viewing = $this->Dailyop->returnPost(array(
			
				"Dailyop.id"=>$v_id
			
			),1);
			
		}
		
		
		$check = $this->checkForEntry();
		
		$title_for_layout = "Aberrican Originals by Levis";
		
		$this->set(compact("check","title_for_layout","posts","viewing"));
		
	}
	
	public function upload() {
		
		
		
	}
	
	public function handle_upload() {
		
		$file = $_FILES['Filedata'];
		
		if(is_uploaded_file($file['tmp_name'])) {
			
			$u = $this->Session->read("Auth.User");
			
			$ext = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
			
			$name = $u['id'].".".$ext;
			
			move_uploaded_file($file['tmp_name'],WWW_ROOT."files/".$name);
			
			$this->AberricanOriginal->save(array(
			
				"file"=>$name,
				"user_id"=>$u['id']
			
			));
			
			die("Your video has been successfully entered. <br /> Check back soon for the results.");
			
		}
		
		
	}
	
	public function checkForEntry() {
		
		$id = $this->Session->read("Auth.User.id");
		
		if(!$id) {
			
			return false;
			
		}
		
		$check = $this->AberricanOriginal->find("first",array(
		
			"conditions"=>array("AberricanOriginal.user_id"=>$id)
		
		));
		
		if(isset($check['AberricanOriginal']['id'])) {
			
			return true;
			
		}
		
		return false;
		
	}
	
	
	public function video($id) {
		
		$this->layout = 'blank';
		
		$this->set(compact("id"));
		
		$this->render("/elements/video");
		
	}
	
	public function confirmation() {
		
		
		
	}
	
}


?>