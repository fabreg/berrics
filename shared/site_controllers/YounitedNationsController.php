<?php 

App::import("Controller","Dailyops");

class YounitedNationsController extends DailyopsController {
	
	public $uses = array("YounitedNationsEvent");
	
	public $event_id = false;
	
	private $cache_token = "yn3-geo-cache";
	
	public function beforeFilter() {

		if($this->request->params['action'] == "handle_upload") {
			
			$this->Session->id($this->request->params['pass'][0]);
			$this->Session->start();
		}
		
		parent::beforeFilter();
	
		$this->Auth->allowedActions = array();

		$this->Auth->allow("*");

		$this->initPermissions();
		
		//set the theme up
		
		$this->theme = "younited-nations-3";
		
		switch($this->theme) {
			
			case "younited-nations-3":
			
				if($this->request->params['action'] == "section") {
			
					$this->request->params['action'] = "crews";
					
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
		
		if(count($this->request->data)>0) {
			
			
			
		} else {
			
			
			$this->request->data['YounitedNationsPosse']['country'] = $_SERVER['GEOIP_COUNTRY_CODE'];
			
		}
		
		$entry = false;
		
		if($this->Session->check("Auth.User.id")) {
			
			$posse = $this->YounitedNationsPosse->find("first",array(
				"conditions"=>array(
					"YounitedNationsPosse.user_id"=>$this->Session->read("Auth.User.id")
				),
				"contain"=>array(
					"YounitedNationsPosseMember",
					"YounitedNationsEventEntry"
				),
				
			));
			
			if(!isset($posse['YounitedNationsPosse']['id'])) $posse = false;
			
			$entry = $posse;
			
		}
		
		if($entry) $this->request->data = $entry;
		
	}
	
	public function ajax_update_entry() {
		
		if(!$this->request->params['isAjax'] || !$this->Session->check("Auth.User.id")) {
			
			return false;
			
		}
		
		$this->request->data['YounitedNationsPosse']['user_id'] = $this->Auth->user("id");
		
		$this->request->data = $this->YounitedNationsEvent->YounitedNationsEventEntry->updateEntry($this->request->data);
		
		
		
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
				"notes"=>$this->request->params['pass'][1],
				"model"=>"YounitedNationsEventEntry",
				"foreign_key"=>$this->request->params['pass'][2],
				"user_id"=>$this->user_id_scope
			
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
		
		//get all the entries and the posses
		$this->loadModel("YounitedNationsEventEntry");
		
		$this->setEvent();
		
		if($_SERVER['REQUEST_URI'] == "/dailyops") {
			
			$this->get_full_date_nav();
			
		}
		
	}
	
	private function setEvent() {
		
		$c = Arr::countries();
		
		if($this->request->params['isAjax']) $this->skip_page_view = true;
		
		$token = $this->theme."-event-entries";
		
		if(($entries = Cache::read($token,"1min")) === false) {
			
			
			$this->loadModel("YounitedNationsEventEntry");
			
			$entries = $this->YounitedNationsEventEntry->find("all",array(
			
				"conditions"=>array(
					"YounitedNationsEventEntry.younited_nations_event_id"=>$this->event_id,
					"YounitedNationsEventEntry.active"=>1
				),
				"contain"=>array(
					"YounitedNationsPosse"
				)
			
			));
			
			$countries = array();
			
			foreach($entries as $e) $countries[$e['YounitedNationsPosse']['country']][] = $e;
			
			foreach($countries as $k=>$v) $countries[$k] = count($v);
			
			arsort($countries);
			
			$entries = array(
				"entries"=>$entries,
				"countries"=>$countries
			);
			
			Cache::write($token,$entries,"1min");
			
		}
		
		
			
		$this->set(compact("entries"));
		
	}
	
	public function get_geo_cache() {
		
		$key = $this->request->data['key'];
		
		if(!$this->request->params['isAjax'] || empty($key)) {
			
			throw new NotFoundException();
			
		} else {
			
			
			$key = md5($key);
			
		}
		
		//get the cache
		$cache = Cache::read($this->cache_token,"max");
		
		//check to see if we have the key
		if(array_key_exists($key,$cache)) return die(json_encode($cache[$key]));
		
		die(json_encode(array()));
		
	}
	
	public function set_geo_cache() {
		
		if(!$this->request->params['isAjax']) {
			
			throw new NotFoundException();
			
		}
		
		$key = md5($this->request->data['key']);
		
		$val = $this->request->data['val'];
		
		$cache = Cache::read($this->cache_token,"max");
		
		$cache[$key] = $val;
		
		Cache::write($this->cache_token,$cache,"max");
		
		die(print_r($val));
		
	}
	
	public function ajax_get_crews() {
		
		$this->setEvent();
		
	}
	
	public function ajax_get_crew($id = false) {
		
		$this->loadModel("YounitedNationsPosse");
		
		$token = 'yn3-posse-'.$id;
		
		if(!$id) throw new NotFoundException();
		
		if(($posse = Cache::read($token,"1min")) === false) {
			
			$posse = $this->YounitedNationsPosse->find("first",array(
			
				"conditions"=>array(
					"YounitedNationsPosse.id"=>$id
				),
				"contain"=>array(
					"YounitedNationsPosseMember"=>array(
						"limit"=>10,
						"order"=>array(
							"YounitedNationsPosseMember.id"=>"ASC"
						)
					)
				)
			
			));
			
			Cache::write($token,$posse,"1min");
			
		}
		
		$this->set(compact("posse"));
		
	}
	
	public function ajax_top_banner() {
		
		$this->loadModel("YounitedNationsEventEntry");
		
		$token = "yn3-crew-total";
		
		if(($data = Cache::read($token,"1min")) === false) {
			
			$data = $this->YounitedNationsEventEntry->find("count",array(
			
				"conditions"=>array(
					"YounitedNationsEventEntry.younited_nations_event_id"=>$this->event_id
				),
				"contain"=>array()
			
			));
			
		}
		
		$this->set(compact("data"));
		
	}

	
}