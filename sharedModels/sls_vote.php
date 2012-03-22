<?php

class SlsVote extends AppModel {
	
	public $belongsTo = array(
		"SlsEntry",
		"User"
	);
	
	public function place_vote($user_id = false,$entry_id = false) {
		
		if(!$user_id || !$entry_id) return false;
		
		$check = $this->find("count",array(
			"conditions"=>array(
				"SlsVote.user_id"=>$user_id,
				"SlsVote.sls_entry_id"=>$entry_id
			),
			"contain"=>array()
		));
		
		if($check === 0) {
			
			$this->create();
			return $this->save(array(
				"user_id"=>$user_id,
				"sls_entry_id"=>$entry_id
			));
			
		}
		
		return false;
		
	}
	
	public function getVoteStats($cached = false) {
		
		$token = "sls-qualifying-stats";
		
		$data = $this->find("all",array(
		
			"fields"=>array(
				"COUNT(*) AS `total_votes`","SlsEntry.*"
			),
			"joins"=>array(
				"INNER JOIN sls_entries AS `SlsEntry` ON (SlsEntry.id = SlsVote.sls_entry_id)"
			),
			"group"=>array(
				"SlsEntry.id"
			),
			"order"=>array(
				"total_votes"=>"DESC"
			),
			"contain"=>array()
		
		));
		
		//get all the posts and grand total
		$grand_total = 0;
		
		foreach($data as $k=>$v) {
			
			$post = $this->SlsEntry->Dailyop->returnPost(array("Dailyop.id"=>$v['SlsEntry']['dailyop_id']),1);
			
			$data[$k]['Post'] = $post;
			
			$grand_total += $v[0]['total_votes'];
			
		}
		
		foreach($data as $k=>$v) {
			
			$data[$k]['Percentage'] = round(($v[0]['total_votes']/$grand_total)*100,2);
			
		}
		
		$data = array("Stats"=>$data,"GrandTotal"=>$grand_total);
		
		return $data;
		
		
	}
	
	
}