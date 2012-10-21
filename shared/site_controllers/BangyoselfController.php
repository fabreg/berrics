<?php 

App::import("Controller","Dailyops");

class BangyoselfController extends DailyopsController {
	
	
	public $uses = array(
		"BangyoselfEvent",
		"BangyoselfEntry",
		"Dailyop"
	);
	
	public $event_id = 1; //bang yoself 3 is default

	private $valid_ext = array("mov","mpeg","mp4","avi");
	
	
	public function beforeFilter() {
		
		if($this->request->params['action'] == "handle_upload") {
			
			$this->Session->id($this->request->params['pass'][0]);
			$this->Session->start();
		}
		
		parent::beforeFilter();
		
		$this->initPermissions();

		$this->Auth->allow("*");
		
		
		if(isset($_SERVER['DEVSERVER'])) { 
			
			$this->request->params['action'] = "voting";
			$this->view = "voting";
			
		} else {
			
			if($this->request->params['action'] == "section") { 
				
				$this->request->params['action'] = "view";
				$this->view = "view";
				
			}
			
		}
		$this->request->params['action'] = "voting";
		$this->view = "voting";
		$this->theme = 'bang-yoself-3';
		//update
		$this->set("title_for_layout","LRG Presents: BANG YOSELF! 3");
		
	}
	
	public function view() {
		
		//grab the event
		$event = $this->BangyoselfEvent->find("first",array(
			
			"conditions"=>array(
				"BangyoselfEvent.id"=>$this->event_id
			),
			"contain"=>array()
		
		));
		
		$entry_check = $this->checkForEntry();
		
		$this->set(compact("event","entry_check"));
		
	}
	
	private function checkForEntry() {
		
		if(!$this->Auth->user('id')) {
			
			return false;
			
		}
		
		$check = $this->BangyoselfEntry->find("first",array(
		
			"conditions"=>array(
				"BangyoselfEntry.user_id"=>$this->Auth->user("id")
			),
			"contain"=>array()
		
		));
		
		if(isset($check['BangyoselfEntry']['id']) && !empty($check['BangyoselfEntry']['id'])) {
			
			return true;
			
		}
		
		return false;
		
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
	
	public function voting() {

		//get the bangyoself dataset
		
		$token = "bang_yoself_3_entries";
		
		if(($posts = Cache::read($token,"1min")) === false) {
			
			$posts = $this->BangyoselfEntry->find("all",array(
				"conditions"=>array(
					"BangyoselfEntry.dailyop_id >"=>0
				),
				"contain"=>array(),
				"order"=>"RAND()"
			));
			
			//get the dop's
			foreach($posts as $k=>$v) { 
				
				$d = $this->BangyoselfEntry->Dailyop->returnPost(array(
								"Dailyop.id"=>$v['BangyoselfEntry']['dailyop_id']
							),$this->isAdmin());
				$posts[$k]['Post'] = $d;
				
				
			}
			
			Cache::write($token,$posts,"1min");
			
		}
		
		$this->set(compact("posts"));
		
		//do we have an incoming post?
		if(isset($this->request->params['uri'])) {
			
			$viewing = $this->BangyoselfEntry->Dailyop->returnPost(array(
				"DailyopSection.uri"=>$this->request->params['section'],
				"Dailyop.uri"=>$this->request->params['uri']
			),$this->isAdmin());
			
			if(isset($viewing['Dailyop']['id'])) {
				
				$this->set(compact("viewing"));
				
			}
			
			$this->setFacebookMetaImg($viewing['DailyopMediaItem'][1]['MediaFile']);
			
		}
		
	
	}
	
	
	public function facebook() {
		
		
		
	}
	
	
	
	
}