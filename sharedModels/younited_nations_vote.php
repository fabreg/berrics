<?php

class YounitedNationsVote extends AppModel {
	
	
	public function return_event_stats($event_id = 4) {
		
		
		$votes = $this->find("all",array(
		
			"conditions"=>array(),
			"contain"=>array(),
			"group"=>array(
				"YounitedNationsVote.younited_nations_event_entry_id"
			),
			"fields"=>array(
				"COUNT(*) AS `votes`","YounitedNationsVote.younited_nations_event_entry_id"
			),
			"order"=>array(
				"votes"=>"DESC"
			)
		
		));
		
		return $votes;
		
	}
	
	
	
}