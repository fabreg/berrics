<?php

class BatbVote extends AppModel {
	
	
	public $belongsTo = array(
		
		"User",
		"BatbMatch",
		"MatchWinnerUser"=>array(
			"className"=>"User",
			"foreignKey"=>"match_winner_user_id"
		),
		"RpsWinnerUser"=>array(
			"className"=>"User",
			"foreignKey"=>"rps_winner_user_id"
		),
	
	
	);
	

	public function placeVote($data) {
		
		//get the match
		$match = $this->BatbMatch->find("first",array(
			"conditions"=>array(
				"BatbMatch.id"=>$data['BatbVote']['batb_match_id']
			),
			"contain"=>array()
		));
		
		//double check to see that the user hasn't already voted
		
		//insert the vote;
		return true;
		
	}
	
}

