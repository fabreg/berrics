<?php

App::import("Controller","BatbApp");

class VotingController extends BatbAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		
		
		$this->initPermissions();
		
		if(isset($_SERVER['DEVSERVER'])) {
			
			//$this->Auth->allow("*");
			
		}
		
		
		
	}
	
	public function place_vote($match_id = false) {
		
		$this->loadModel("BatbVote");
		$this->loadModel("BatbEvent");
		$this->loadModel("BatbMatch");
		$this->loadModel("BatbScore");
		
		//check to see if the user has voted
		$user_id = $this->Auth->user("id");
		
		$batb_event_id = $this->batb_event_id;
		
		$event = $this->BatbEvent->find("first",array(
		
			"conditions"=>array(
				"BatbEvent.id"=>$this->batb_event_id
			),
			"contain"=>array()
		
		));
		

		//make sure the user has not voted on these matches
		$check = $this->BatbVote->find("all",array(
		
			"conditions"=>array(
				"BatbVote.batb_match_id"=>array($event['BatbEvent']['featured_match1_id'],$event['BatbEvent']['featured_match2_id']),
				"BatbVote.user_id"=>$user_id
			),
			"contain"=>array()
		
		));
		


		
		if(count($check) >0) {
			
			
			$this->Session->setFlash("You're only allowed one vote per battle.");
			
			return $this->redirect("/");
			
		}
		
		
		if($this->data) {
			
			$this->BatbScore->ensureScoreRow($this->Auth->user("id"),$batb_event_id);
			
			for($i=1;$i<=2;$i++) {
				
				
				$data = array(
				
					"match_winner_user_id"=>$this->data['BatbVote']['match_winner_user_id-'.$i],
					"rps_winner_user_id"=>$this->data['BatbVote']['rps_winner_user_id-'.$i],
					"winner_letters"=>$this->data['BatbVote']['winner_letters-'.$i],
					"batb_match_id"=>$this->data['BatbVote']['batb_match_id-'.$i],
					"user_id"=>$this->Auth->user("id")
				
				);
				$this->BatbVote->create();
				$this->BatbVote->save($data);
				
			}
			
			$this->Session->setFlash("Thank you for voting. Check back frequently for the results of the battles and to check the leaderboard.");
			
			return $this->redirect("/");
			
			
		}
		
		
				
		//get the matches
		$featured1 = $this->BatbMatch->find("first",array(
		
			"conditions"=>array(
				"BatbMatch.id"=>$event['BatbEvent']['featured_match1_id']
			)
		
		));
		
		$featured2 = $this->BatbMatch->find("first",array(
		
			"conditions"=>array(
				"BatbMatch.id"=>$event['BatbEvent']['featured_match2_id']
			)
		
		));
		
		
		//check to see if there are videos set, if so then block'em!!!
		
		if(!empty($featured1['BatbMatch']['legacy_video_link']) || !empty($featured2['BatbMatch']['legacy_video_link'])) {
			
			
			return $this->invalidUrl("/");
			
		}
		
		
		$this->set(compact("event","featured1","featured2"));
		
		$title = "BATTLE PREDICTIONS: ";
		
		$title .= $featured1['Player1User']['first_name']." ".$featured1['Player1User']['last_name'];
		
		$title .=" VS. ";
		
		$title .=$featured1['Player2User']['first_name']." ".$featured1['Player2User']['last_name'];
		
		$title .= " & ";
		
				
		$title .= $featured2['Player1User']['first_name']." ".$featured2['Player1User']['last_name'];
		
		$title .=" VS. ";
		
		$title .=$featured2['Player2User']['first_name']." ".$featured2['Player2User']['last_name'];
		
		
		$this->set("title_for_layout",$title);
		
	}
	
	
	public function confirm_vote() {
		
		
	}
	
	public function force($id) {
		$this->loadModel("User");
		$user = $this->User->find("first",array(
			"conditions"=>array("User.id"=>$id),
			"contain"=>array()
		));
		
		//die(print_r($user));
		
		$this->Session->write("Auth.User",$user['User']);
		
		$this->redirect("/");
		
	}
	
}

?>