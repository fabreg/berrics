<?php

App::import("Controller","AdminApp");

class SystemController extends AdminAppController {
	
	public $uses = array();
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	
	public function index() {
		
	
		

		
	}
	
	
	public function execute($com = false) {
		
		if($com == false) {
			
			die("Epic Fail! Yes, it was epic");
			
		}
		
		$oldPath = set_include_path("/home/sites/berrics.dev/sharedVendors/phpseclib");
		
		App::import("Vendor","SSH2",array("file"=>"phpseclib/Net/SSH2.php"));
		
		set_include_path($oldPath);
		
		$ssh = new Net_SSH2('10.181.67.27');
		
		$login = $ssh->login('root','WEB1MH0r5t7Wn');
		
		$out = '';
		
		switch($com) {
			
			case "sync-berrics-all";
				$out .= $ssh->exec("/home/sites/berrics.shell/sync-berrics-all");
				$out .= $ssh->exec("/home/sites/berrics.shell/clear-cache");
			break;
			case "sync-berrics-all-check";
				$out .= $ssh->exec("/home/sites/berrics.shell/sync-berrics-all-check");
			break;
			case "sync-berrics-splash":
				$out .=$ssh->exec("/home/sites/berrics.shell/sync-berrics-splash");
			break;
			default:
				$out .= "Nothing to do...";
			break;
			
		}
		
		$this->set(compact("out"));
		
		//echo $ssh->exec('/home/sites/berrics.shell/sync-berrics-all-check');
		
		
	}
	
	
}


?>