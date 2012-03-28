<?php

App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));

class InstagramShell extends Shell {
	
	public $uses = array("User","InstagramImageItem");
	
	
	public function make_user_profiles() {
		
		$users = $this->User->find("all",array(
			"conditions"=>array(
				"User.profile_uri"=>"",
				"User.instagram_handle !="=>""
			),
			"contain"=>array()
		));
		
		foreach($users as $u) {
			
			
			$uri = strtolower(trim(preg_replace('/[^\w\d_ -]/si', '', $u['User']['first_name']." ".$u['User']['last_name'])));
			
			$uri = str_replace(" ","-",$uri).".html";
			
			
			$this->User->create();
			$this->User->id = $u['User']['id'];
			$this->User->save(array("uri"=>$uri));
			
			$this->User->updateInstagramDetails($u,true);
			
			$this->out("Processing: {$uri}");
			
		}
		
		
	}
	
	
}