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

		$total_score = $this->query("SELECT SUM(score) FROM rg_votes WHERE dailyop_id='{$dailyop_id}'");

		return array(
			"total_votes"=>$total_votes,
			"total_score"=>$total_score,
			"average"=>number_format($total_votes/$total_score,1);
		);

	}

	public function placeVote($user_id = false, $post_id = false, $score = 0.0) {
		


	}



}