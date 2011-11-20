<?php 

App::import("Controller","Dailyops");

class YounitedNationsController extends DailyopsController {
	
	public $uses = array("YounitedNationsEvent");
	
	public $event_id = false;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allowedActions = array();

		$this->Auth->allow("index","view","section","entry_form","ajax_update_entry");

		$this->initPermissions();
		
		//set the theme up
		
		$this->theme = $this->params['section'];
		
		switch($this->theme) {
			
			case "younited-nations-3":
			
				if($this->params['action'] == "section") {
			
					$this->params['action'] = "entry_form";
					
				}
				
				$title_for_layout = "YOUnited Nations 3";
				
				$this->event_id = 4;
				
			break;
			
		}
		
		
		$this->set(compact("title_for_layout"));
		$this->set("event_id",$this->event_id);
		
	}
	
	public function entry_form() {
		
		$this->loadModel("YounitedNationsEventEntry");
		
		$this->loadModel("YounitedNationsPosse");
		
		if(count($this->data)>0) {
			
			
			
		} else {
			
			
			$this->data['YounitedNationsPosse']['country'] = $_SERVER['GEOIP_COUNTRY_CODE'];
			
		}
		
		$entry = false;
		
		if($this->Auth->user("id")) {
			
			$posse = $this->YounitedNationsPosse->find("first",array(
				"conditions"=>array(
					"YounitedNationsPosse.user_id"=>$this->Auth->user("id")
				),
				"contain"=>array(
					"YounitedNationsPosseMember",
					"YounitedNationsEventEntry"
				),
				"___joins"=>array(
					"LEFT JOIN younited_nations_event_entries AS `YounitedNationsEventEntry` ON (YounitedNationsEventEntry.younited_nations_posse_id=YounitedNationsPosse.id)"
				)
			));
			
			if(!isset($posse['YounitedNationsPosse']['id'])) $posse = false;
			
			$entry = $posse;
			
		}
		
		if($entry) $this->data = $entry;
	}
	
	public function ajax_update_entry() {
		
		if(!$this->params['isAjax'] || !$this->Session->check("Auth.User.id")) {
			
			return false;
			
		}
		
		$this->data['YounitedNationsPosse']['user_id'] = $this->Auth->user("id");
		
		$this->data = $this->YounitedNationsEvent->YounitedNationsEventEntry->updateEntry($this->data);
		
		
		
	}

	
public function handle_upload() {
		
		$file = $_FILES['Filedata'];
		
		if(is_uploaded_file($file['tmp_name'])) {
			
			
			$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
			
			$fileName = md5(time()).mt_rand(100,999).".".$ext;
			
			move_uploaded_file($file['tmp_name'],TMP.$fileName);
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			ImgServer::instance()->upload_bangyoself_entry($fileName,TMP.$fileName);
			
			unlink(TMP.$fileName);
			
			//insert the entry
			
			$this->BangyoselfEntry->create();
			
			$this->BangyoselfEntry->save(array(
			
			
				"user_id"=>$this->user_id_scope,
				"file_name"=>$fileName,
				"bangyoself_event_id"=>$this->event_id
			
			
			));
			
			die("1");
			
		} else {
			
			die("0");
			
		} 
		
	}
	public function locatePosse() {
		
		
		
	}
	
	public function index() {
		
		
		
	}
	
	public function section() {
		
		
		
		
	}
	
	public function view() {
		
		
		
	}
	
	public function crews() {
		
		
		
	}
	
	public function setEvent() {
		
		
		
	}
	
}