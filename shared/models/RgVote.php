<?php

class RgVote extends AppModel {


	public function getUserVotes($user_id = false,$cache = false) {
		
		if(!$user_id) throw new BadRequestException("RgVote::getUserVotes - Invalid User ID Argument");

		$votes = $this->find('all', array(

			"conditions"=>array(
				"RgVote.user_id"=>$user_id
			),
			"contain"=>array()

		));

		return $votes;

	}

	public function getPostAverage($post_id = false) {
		
		if(!$post_id) throw new BadRequestException("RgVote::getPostAverage - Invalid Post ID Argument");

		$total_votes = $this->find('count', array(
			"conditions"=>array(
				"RgVote.dailyop_id"=>$post_id
			)
		));

		$total_score = $this->query("SELECT SUM(score) AS `total` FROM rg_votes WHERE dailyop_id='{$post_id}'");
		
		return array(
			"total_votes"=>$total_votes,
			"total_score"=>$total_score[0][0]['total'],
			"average"=>number_format($total_score[0][0]['total']/$total_votes,1)
		);

	}

	public function placeVote($user_id = false, $post_id = false, $score = 0.0) {
		
		$chk = $this->find('first',array(
				"conditions"=>array(
					"RgVote.user_id"=>$user_id,
					"RgVote.dailyop_id"=>$post_id
				),
				"contain"=>array(),
				"fields"=>array("RgVote.id")
			));

		$this->create();

		if(isset($chk['RgVote']['id']) && !empty($chk['RgVote']['id'])) {

			$this->id = $chk['RgVote']['id'];

		}

		if($score < 10) $score = number_format($score,1);

		$this->save(array(
			"user_id"=>$user_id,
			"dailyop_id"=>$post_id,
			"score"=>$score
		));

	}



}