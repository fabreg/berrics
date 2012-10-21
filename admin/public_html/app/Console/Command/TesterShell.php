<?php

class TesterShell extends AppShell {
	
	public $uses = array("YounitedNationsVote","YounitedNationsEventEntry","User");
	
	
	public function run_test() {
		
		//get all the entrie ids
		
		$this->out("Test");
		
	}
	
}