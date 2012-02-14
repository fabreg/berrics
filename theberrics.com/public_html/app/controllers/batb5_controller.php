<?php

App::import("Controller","Dailyops");


class Batb5Controller extends DailyopsController {
	
	
	public $uses = array();
	
	private $event_id = 50018;
	//private $event_id = 50016;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
		//set the theme
		
		$this->theme = "battle-at-the-berrics-5";
		
		if($this->params['action'] == "view")  {
			
			$this->params['action'] = "section";
			
		}
		
	}
	
	
	public function section() {
		
		//page title
		$this->set("title_for_layout","DC Shoes Presents: Battle at the Berrics 5");
		
		if(count($this->data)>0) $this->handleVoteSubmit();
		
		//clear out the right columnd
		$this->set("right_column","");
		
		//load the events model
		$this->loadModel("BatbEvent");
		
		//get and set the event
		$event = $this->BatbEvent->returnEvent($this->event_id);
		$this->set(compact("event"));
		
		//set the featured matches attached to the event
		$this->setFeaturedMatches($event);
		
		//get and set the users profile
		if($this->Session->check("Auth.User.id")) {
			
				
				$this->loadModel("UserProfile");
				$profile = $this->UserProfile->find("first",array(
							
								"conditions"=>array(
									"UserProfile.user_id"=>$this->Session->read("Auth.User.id")
								),
								"contain"=>array()
							
							));
				$this->set(compact("profile"));
			
			
		}
		
		//set the posts
		$this->setPosts($event);
					
	}
	
	public function setPosts($event) {
		
		$posts = array();
		
		$this->loadModel("Dailyop");
		
		//check to see if this was a bracket click	
		if(isset($this->params['named']['battle']) && !empty($this->params['named']['battle'])) {
				
			//match id
			$match_id = base64_decode($this->params['named']['battle']);
			
			$this->loadModel("BatbMatch");
			
			$match = $this->BatbMatch->find("first",array(

				"conditions"=>array(
					"BatbMatch.id"=>$match_id
				)
				
			));
			
			if(empty($match['BatbMatch']['id'])) {
				
				return $this->cakeError("error404");
				
			}
			
			//check for pregame
			
			if(!empty($match['BatbMatch']['pregame_dailyop_id'])) $posts[] = $this->Dailyop->returnPost(array("Dailyop.id"=>$match['BatbMatch']['pregame_dailyop_id']));
						
			//check for battle
			
			if(!empty($match['BatbMatch']['battle_dailyop_id'])) $posts[] = $this->Dailyop->returnPost(array("Dailyop.id"=>$match['BatbMatch']['battle_dailyop_id']));
			
			//check postgame
			
			if(!empty($match['BatbMatch']['postgame_dailyop_id'])) $posts[] = $this->Dailyop->returnPost(array("Dailyop.id"=>$match['BatbMatch']['postgame_dailyop_id']));
			
			
		} else if(!empty($this->params['uri'])) {
			
			
			$posts[] = $this->Dailyop->returnPost(array(
					
					"DailyopSection.uri"=>$this->params['section'],
					"Dailyop.uri"=>$this->params['uri'],
					"Dailyop.active"=>1
			
			),$this->isAdmin());
			
			//die(print_r($posts));
		}
		
		$this->set(compact("posts"));
		
	}
	
	
	private function setFeaturedMatches($event) {
		
		$featured[] = $this->returnFeaturedMatch($event['BatbEvent']['featured_match1_id']);
		
		$featured[] = $this->returnFeaturedMatch($event['BatbEvent']['featured_match2_id']);
		
		$this->set(compact("featured"));
		
	}
	
	private function returnFeaturedMatch($match_id = false) {

		$this->loadModel("BatbMatch");
		$this->loadModel("BatbVote");
		
		$match = $this->BatbMatch->find("first",array(
			"conditions"=>array(
				"BatbMatch.id"=>$match_id
			),
			"contain"=>array(
				"Player1User",
				"Player2User"
			)
		));
		
		//check to see if there has been a vote placed
		$match['BatbVote'] = array();
		
		if($this->Session->check("Auth.User.id")) {
			
			$vote = $this->BatbVote->find("first",array(
				"conditions"=>array(
					"BatbVote.batb_match_id"=>$match['BatbMatch']['id'],
					"BatbVote.user_id"=>$this->user_id_scope
				),
				"contain"=>array(
				)
			));

			$match['BatbVote'] = $vote['BatbVote'];
			
		}
		
		return $match;
		
		
	}
	
	private function handleVoteSubmit() {
		
		$this->loadModel("BatbScore");
		$this->loadModel("BatbVote");
		
		if(!$this->Session->check("Auth.User.id")) return $this->cakeError("error404");
		
		if(count($this->data)>0) {
			
			//ensure the user has a score row for this event
			$this->BatbScore->ensureScoreRow($this->Auth->user("id"),$this->event_id);
			
			//insert the vote
			$this->data['BatbVote']['user_id'] = $this->Session->read("Auth.User.id");
			$this->data['BatbVote']['batb_event_id'] = $this->event_id;
			
			if($this->BatbVote->save($this->data)) {
				
				return $this->flash("Thanks for voting!","/battle-at-the-berrics-5?".microtime());
				
			}
			
		}
		
	}
	
	public function view() {
		
		
		
	}

	
	
}