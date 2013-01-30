<?php
App::import("Controller","LocalApp");
class BatbEventsController extends LocalAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function index() {
		
		$this->BatbEvent->recursive = 0;
		$this->set("events",$this->paginate());
		
	}
	
	
	public function add() {
		
		if(count($this->request->data)>0) {
			
			
			//lets insert the shit
			if($this->BatbEvent->save($this->request->data)) {
				
				$event = $this->BatbEvent->read();
				
				$this->BatbEvent->BatbMatch->createMatches($event);
				
				$this->Session->setFlash("Successfully Created Event: ".$this->request->data['BatbEvent']['name']);
				$this->redirect(array("controller"=>"batb_events","action"=>"view",$this->BatbEvent->id));
				
			} else {
				
				$this->Session->setFlash("Something fucked up, please try again.");
				
			}
			
		}
		
		
	}
	
	public function update_match_stats($match_id) {
		
		
		$this->loadModel("BatbMatch");
		
		
		if(count($this->request->data)) {
			
			$this->BatbMatch->save($this->request->data);
			
			$this->Session->setFlash("Updated!!!");
			
		} 
		
		$match = $this->BatbMatch->find("first",array(
		
			"conditions"=>array(
				"BatbMatch.id"=>$match_id
			),
			"contain"=>array(
				"Player1User",
				"Player2User"
			)
		
		));
		
		$this->request->data = $match;
		
		$this->set("match",$this->request->data);
		
		
		
	}
	
	public function edit() {
		
		
		
	}
	
	public function view($id) {
		
		
		$this->loadModel('User');
		
		$event = $this->BatbEvent->returnEvent($id);
		
		if(count($event)<=0) {
			
			return $this->invalidUrl();
			
		}
		
		$userSelect = $this->User->userSelectList(array(
		
			"OR"=>array(
				"User.pro_skater"=>1,
				"User.am_skater"=>1
			)	
		
		));
		
		$winningLettersDrop = BatbMatch::winningLettersDrop();
		
		$this->set(compact("event","userSelect","winningLettersDrop"));
		
	}
	
	public function update_match_players() {
		
		$id = $this->request->data['BatbMatch']['id'];
		
		if(empty($id)) {
			
			return $this->invalidUrl();
			
		}
		
		//we should be good to go an update the players
		
		$this->loadModel("BatbMatch");
		
		$this->BatbMatch->id = $this->request->data['BatbMatch']['id'];
		
		//die(pr($this->request->data));
		
		if($this->BatbMatch->save($this->request->data)) {
			
			$this->Session->setFlash("Players have been updated successfully!");
			$match = $this->BatbMatch->read();
			//return $this->redirect(array("controller"=>"batb_events","action"=>"view",$match['BatbMatch']['batb_event_id']));
			
			return $this->flash("Players have been updated successfully!",array("controller"=>"batb_events","action"=>"view",$match['BatbMatch']['batb_event_id']),3);
		
		} else {
			
			die("WHoooooops! Something fucked up, hit the back button!");
			
		}
		
	}

	public function attach_user_to_match($match_id = false, $position = 1) {
		
		if($this->request->is("post") || $this->request->is("put")) {
		
			
		
		}

		


	}
	
	public function update_match_winners() {
		
		
		set_time_limit(0);
		
		if(empty($this->request->data)) {
			
			return $this->invalidUrl();
			
		}
		
		
		//uh oh we gonna update the winners!
		$this->loadModel("BatbMatch");

		$this->loadModel("BatbVote");
		
		$this->loadModel("BatbScore");
		
		$this->BatbMatch->updateWinners($this->request->data);
		
		$_SERVER['FORCEMASTER'] = true;
		
		//update the votes
		///rps winners
		$this->BatbVote->updateAll(
		
			array("BatbVote.rps_result"=>1,"BatbVote.rps_points"=>1),
			array("BatbVote.batb_match_id"=>$this->request->data['BatbMatch']['id'],"BatbVote.rps_winner_user_id"=>$this->request->data['BatbMatch']['rps_winner_user_id'])
		
		);
		//update the rps match points
		$this->BatbScore->query(
			"UPDATE batb_scores SET rps_score = rps_score+1
			WHERE user_id IN (SELECT user_id FROM batb_votes WHERE batb_match_id='".$this->request->data['BatbMatch']['id']."'
			AND rps_result=1)"
		);
		
		//update the match winners
		$this->BatbVote->updateAll(
			array("BatbVote.match_result"=>1,"BatbVote.match_points"=>10),
			array("BatbVote.batb_match_id"=>$this->request->data['BatbMatch']['id'],"BatbVote.match_winner_user_id"=>$this->request->data['BatbMatch']['match_winner_user_id'])
		);
		//update the match points
		$this->BatbScore->query(
			"UPDATE batb_scores SET match_score = match_score+10
			WHERE user_id IN (SELECT user_id FROM batb_votes WHERE batb_match_id='".$this->request->data['BatbMatch']['id']."'
			AND match_result=1)"
		);
		
		//update the letters winners
		$this->BatbVote->updateAll(
			array("BatbVote.letters_result"=>1,"BatbVote.letters_points"=>15),
			array("BatbVote.batb_match_id"=>$this->request->data['BatbMatch']['id'],"BatbVote.winner_letters"=>$this->request->data['BatbMatch']['winner_letters'],"BatbVote.match_result"=>1)
		);
		//update the winners letters points
		$this->BatbScore->query(
			"UPDATE batb_scores SET letters_score = letters_score+15
			WHERE user_id IN (SELECT user_id FROM batb_votes WHERE batb_match_id='".$this->request->data['BatbMatch']['id']."'
			AND letters_result=1)"
		);
		
		//update all the votes with total points
		$this->BatbVote->query(
			"UPDATE batb_votes SET total_points=(rps_points+match_points+letters_points) WHERE batb_match_id='".$this->request->data['BatbMatch']['id']."'"
		);
		
		//update all the votes to processed
		$this->BatbVote->updateAll(
			array("BatbVote.processed"=>1),
			array("BatbVote.batb_match_id"=>$this->request->data['BatbMatch']['id'])
		);
		
		//lets hope all went well
		
		
		//calculate the scores
		
		//$this->Session->setFlash("Updated Winners Successfully");
		
		//return $this->render();
		
		//$this->redirect(array("action"=>"view",$this->request->data['BatbMatch']['batb_event_id']));
		
		
		return $this->flash("Updated Winners Successfully",array("action"=>"view",$this->request->data['BatbMatch']['batb_event_id']),3);
		
		//die(pr($this->request->data));
		
		
	}
	
	public function update_videos($match_id) {
		
		if(empty($match_id)) {
			
			return $this->invalidUrl();
			
		}
		
		//load the match model
		$this->loadModel("BatbMatch");
		$this->loadModel("Dailyop");
		
		//check for incoming data
		if(count($this->request->data)>0) {
			
			$this->BatbMatch->id = $this->request->data['BatbMatch']['id'];
			
			if($this->BatbMatch->save($this->request->data)) {
				
				$match = $this->BatbMatch->read();
				$this->Session->setFlash("Videos have been updated successfully");
				$this->redirect(array("action"=>"view",$match['BatbMatch']['batb_event_id']));
				
			} else {
				
				$this->Session->setFlash("Something fucked up, please try again");
				
			}
			
		}
		
		
		//the post select list
		
		$postSelect = $this->Dailyop->batbPostSelect();
		$this->set(compact("postSelect"));
		//get the match
		
		
		$match = $this->BatbMatch->find("first",array(
		
			"conditions"=>array("BatbMatch.id"=>$match_id),
			"contain"=>array("BatbEvent","Player1User","Player2User","PreGameVideo","BattleVideo","PostGameVideo")
		
		));
		
		$this->request->data = $match;
		
		
	}
	
	public function flip_positions($id) {
		
		$match=$this->BatbEvent->BatbMatch->find("first",array(
				
						"conditions"=>array(
							"BatbMatch.id"=>$id
						),
						"contain"=>array()
					
					));
			
		
		$this->BatbEvent->BatbMatch->flipPositions($id);
		
		return $this->flash("Positions have been flipped",array("controller"=>"batb_events","action"=>"view",$match['BatbMatch']['batb_event_id']));
		
	}
	
	public function mark_as_featured($id,$position) {
		
		$match = $this->BatbEvent->BatbMatch->find("first",array(
		
			"conditions"=>array(
				"BatbMatch.id"=>$id
			),
			"contain"=>array()	
		
		));
		
		if(!$match) {
			
			return $this->invalidUrl();
			
		}
		
		$this->BatbEvent->setFeaturedMatch($id,$position);
		
		return $this->flash("Featured match has been set",array("controller"=>"batb_events","action"=>"view",$match['BatbMatch']['batb_event_id']));
		
	}
	
	public function mark_as_featured_stats($id,$position) {
		
		$match = $this->BatbEvent->BatbMatch->find("first",array(
		
			"conditions"=>array(
				"BatbMatch.id"=>$id
			),
			"contain"=>array()	
		
		));
		
		if(!$match) {
			
			return $this->invalidUrl();
			
		}
		
		$this->BatbEvent->setFeaturedStats($id,$position);
		
		return $this->flash("Featured Stats has been set",array("controller"=>"batb_events","action"=>"view",$match['BatbMatch']['batb_event_id']));
		
	}
	
	public function update_user_rankings($event_id) {
		
		$this->loadModel("BatbScore");
		
		//get all the score rows for the event
		$scores = $this->BatbScore->find("all",array(
			"fields"=>array("(BatbScore.rps_score+BatbScore.match_score+BatbScore.letters_score) AS `total`","BatbScore.id"),
			"conditions"=>array("BatbScore.batb_event_id"=>$event_id),
			"order"=>array("total"=>"DESC"),
			"contain"=>array()
		
		));
		
		$pos = 1;
		
		$ids = array();
		
		foreach($scores as $k=>$v) {
			
			$ids[] = $v['BatbScore']['id'];
			$next_score = $scores[($k+1)][0]['total'];
			if($next_score < $v[0]['total']) {

				//update the table with the rank_number
				$this->BatbScore->updateAll(
					array("BatbScore.rank_number"=>$pos),
					array("BatbScore.id"=>$ids)
				);
				
								
				$pos ++;
				$ids = array();
				
				
			}
			
		}
		
		//update the last guys
		$this->BatbScore->updateAll(
					array("BatbScore.rank_number"=>$pos),
					array("BatbScore.id"=>$ids)
				);
		return $this->render();
		return $this->flash("Rankings have been calculated","/batb_events/");
		
		
	}
	
	
}


?>