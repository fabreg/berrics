<?php

class TesterShell extends Shell {
	
	public $uses = array("YounitedNationsVote","YounitedNationsEventEntry","User");
	
	
	public function run_test() {
		
		//get all the entrie ids
		
		$c = 1;
		
		$entries = $this->YounitedNationsEventEntry->find("all",array(
			"contain"=>array(),
			"conditions"=>array(
				"YounitedNationsEventEntry.finalist"=>1
			)
		));
		
		$e = array();
		
		foreach($entries as $v) $e[] = $v['YounitedNationsEventEntry']['id']; 
		
		for($i = 1;$i<=30;$i++) {
			
			$users = $this->User->find("all",array(
				"contain"=>array(),
				"conditions"=>array(),
				"limit"=>5000,
				"page"=>$i
			)); 
			
			foreach($users as $u) {
				
				for($ii=0;$ii<3;$ii++) {
					
					shuffle($e);
					
					$this->YounitedNationsVote->create();
				
					$this->YounitedNationsVote->save(array(
						"user_id"=>$u['User']['id'],
						"younited_nations_event_entry_id"=>$e[0]
					));
					
					$this->out("Inserted Vote: {$c}");
					
					$c++;
					
				}
				
			}
			
			unset($users);
			
		}
		
	}
	
}