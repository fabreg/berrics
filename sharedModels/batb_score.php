<?php

class BatbScore extends AppModel {
	
	
	
	public $belongsTo = array(
	
		"User",
		"BatbEvent"
	);
	
	public function ensureScoreRow($user_id,$batb_event_id) {
		
		
		//check to see if there is a scoring row for the user and event
		$check = $this->find("first",array(
			"conditions"=>array(
				"BatbScore.user_id"=>$user_id,
				"BatbScore.batb_event_id"=>$batb_event_id
			),
			"contain"=>array()
		));
		
		if(!isset($check['BatbScore']['id'])) {
			$this->create();
			
			$this->save(array(
				"user_id"=>$user_id,
				"batb_event_id"=>$batb_event_id
			));
			
		}
		
		
	}
	
	
}
