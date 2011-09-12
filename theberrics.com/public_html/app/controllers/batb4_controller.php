<?php

App::import("Controller","Dailyops");

class Batb4Controller extends DailyopsController {
	
	public $uses = array('Dailyop','BatbMatch');
	public $batb_event_id = 50016;
	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->theme = 'battle-at-the-berrics-4';

		if($this->params['action'] == "section") {
			
			$this->params['action'] = "view";
			
		}
		
	}
	
	public function view() {	
		
		$this->loadModel("BatbEvent");
		$this->loadModel("User");
		$this->loadModel("Dailyop");
		
		$event = $this->BatbEvent->returnEvent($this->batb_event_id,false,true);

		$this->set(compact("event"));
		
		$p1_ids = Set::extract("/BatbMatch/player1_user_id",$event['Brackets']['5']);
		
		$p2_ids = Set::extract("/BatbMatch/player2_user_id",$event['Brackets']['5']);
		
		$ids = array_merge($p2_ids,$p1_ids);
		
		$users = array();
		
		$u = $this->User->find("all",array(
			
			"conditions"=>array(
				"User.id"=>$ids
			),
			"contain"=>array()
		
		));
		
		foreach($u as $v) $users[$v['User']['id']] = $v['User'];
		
		$this->set(compact("users"));
		
		$match_map = $this->buildMatchMap($event,$users);
		
		if(isset($this->params['named']['view'])) {
			
			$key = $this->params['named']['view'];
			
			$match_id = $match_map[$key];
				
			$match = $this->BatbEvent->BatbMatch->returnMatch($match_id,true);

			$this->set(compact("match"));
			
		} else if(isset($this->params['uri'])) {
			
			$uri = $this->params['uri'];
			
			$post = $this->Dailyop->returnPost(array(
			
				"Dailyop.uri"=>$this->params['uri'],
				"DailyopSection.uri"=>$this->params['section']
			
			),$this->isAdmin());
			
			$this->set(compact("post"));
			
		} 

		

		
		

		
		//special stuff for finals voting
		$show_form = false;
		if($this->Session->check("Auth.User.id")) {
			
			$this->setFinalsBattles();
			$show_form = $this->checkVotes($this->Session->read("Auth.User.id"));
		}
		
		
		$this->set(compact("show_form"));
	}
	

	private function buildMatchMap($event = false,$users = false) {
		
		
		$token = "batb4_match_map";
		
		if(($map = Cache::read($token,"1min")) === false) {
			$map = array();
			
			foreach($event['Brackets'] as $bracket) {
				
				foreach($bracket as $match) {
					
					if(!empty($match['BatbMatch']['player1_user_id']) && !empty($match['BatbMatch']['player2_user_id'])) {
						
						$player1 = $users[$match['BatbMatch']['player1_user_id']];
						
						$player2 = $users[$match['BatbMatch']['player2_user_id']];
						
						$match_id = $match['BatbMatch']['id'];
						
						$key = Tools::safeUrl($player1['first_name']." ".$player1['last_name']." vs ".$player2['first_name']." ".$player2['last_name']);
						
						$map[$key] = $match_id;
						
					}
					
				}
				
			}
			
			Cache::write($token,$map,"1min");
			
		}

		return $map;
		
	}
	
	public function leaderboard($stats = "weekly") { 
		
		$this->loadModel("User");
		$this->loadModel("BatbScore");
		$this->loadModel("BatbVote");
		$this->loadModel("BatbEvent");
		
		$event = $this->BatbEvent->find("first",array(
		
			"conditions"=>array(
				"BatbEvent.id"=>$this->batb_event_id
			),
			"contain"=>array()
		
		));
		
		$stats = "overall";
		
		
		if($stats == "weekly") {
			
			//sum up the weekly stats based on the featured stats match
			$feat1 = $event['BatbEvent']['featured_stats1_id'];
			$feat2 = $event['BatbEvent']['featured_stats2_id'];
			
			
			$leaders = Cache::read("batb4_weekly_stats","1min");
			
			if($leaders === false) {
				
				$leaders = $this->BatbVote->find("all",array(
				
								"fields"=>array("SUM( BatbVote.total_points ) AS  `total`" , "User.id, User.first_name", "User.last_name", "User.facebook_account_num","SUM(BatbVote.rps_points) as `rps_points`","SUM(BatbVote.match_points) as `match_points`","SUM(BatbVote.letters_points) as `letters_points`"),
								"joins"=>array(
									"LEFT JOIN users AS `User` ON (User.id = BatbVote.user_id)"
								),
								"conditions"=>array(
									"BatbVote.batb_match_id"=>array($feat1,$feat2)
								),
								"group"=>array("BatbVote.user_id"),
								"order"=>array("total"=>"DESC","User.batb_winner"=>"DESC"),
								"limit"=>150,
								"contain"=>array()
							
							));
							
							
				Cache::write("batb4_weekly_stats",$leaders,"stats");
				
			}
			
			
			
			
			
		} else {
			
			
			$leaders = Cache::read("batb4_overall_stats","1min");

			if($leaders === false) {
				
		
					$leaders = $this->BatbScore->find('all',array(
				
						"fields"=>array("(BatbScore.rps_score+BatbScore.match_score+BatbScore.letters_score) AS `total`,
											User.first_name,User.last_name,User.facebook_account_num,User.id,
											BatbScore.rps_score,BatbScore.match_score,BatbScore.letters_score"),
						"conditions"=>array("BatbScore.batb_event_id"=>$this->batb_event_id),
						"contain"=>array("User"),
						"limit"=>150,
						"order"=>array("total"=>"DESC")
					
					));
					
					Cache::write("batb4_overall_stats",$leaders,"stats");
		
				
			}
			

			
			
		}
		
		
		
		$this->set(compact("leaders"));
		
		
	}
	
	public function score($id = false) {
		
		if(!$id) {
			
			$id = $this->Auth->user("id");
			
		}
		
		if(!$id) {
			
			return $this->redirect(array("controller"=>"login","action"=>"batb_login","plugin"=>"identity"));
			
		}
		
		$this->loadModel("User");
		$this->loadModel("BatbVote");
		$this->loadModel("BatbScore");
		$this->loadModel("BatbMatch");
		
		$user = $this->User->find("first",array(
		
			"conditions"=>array("User.id"=>$id),
			"contain"=>array()
			
		));
		
		
		
		if(!isset($user['User']['id'])) {
			
			return $this->invalidUrl("/");
			
		}
		
		
		$score = $this->BatbScore->find("first",array(
		
			"conditions"=>array("BatbScore.user_id"=>$id,"BatbScore.batb_event_id"=>$this->batb_event_id),
			"contain"=>array()
		
		));
		
		if(!isset($score['BatbScore']['id'])) {
			
			$this->Session->setFlash("You haven't voted on any matches yet!!");
			
			$this->redirect("/leaderboard");
			
		}
		
		
		$votes = $this->BatbVote->find("all",array(
			"conditions"=>array(
				"BatbVote.user_id"=>$id,
				"BatbVote.batb_match_id IN (SELECT id FROM batb_matches WHERE batb_event_id = '{$this->batb_event_id}') "
			),
			"contain"=>array(
				"BatbMatch"=>array("Player1User","Player2User"),
				"MatchWinnerUser",
				"RpsWinnerUser"
			),
			"order"=>array("BatbVote.created"=>"DESC")
		));
		
		
		if(!$this->checkVotes($id)) {
			
			$finals_ids = array(406,407,408,409);
			$finals_battles = array();
			foreach($finals_ids as $i) {
				
				
				$b = $this->BatbMatch->returnMatch($i,false,true);
				
				$finals_battles[$b['BatbMatch']['id']]  =$b; 
				
			}
			
			$this->set(compact("finals_battles"));
		}
		
		$this->set(compact("user","votes","score"));
		
		
		//page title
		
		$this->set("title_for_layout","Profile: ".$user['User']['first_name']." ".$user['User']['last_name']);
		
		
		
		
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
		
		
		//special stuff for finals voting
		$show_form = false;
		if($this->Session->check("Auth.User.id")) {
			
			$this->setFinalsBattles();
			$show_form = $this->checkVotes();
		}
		
		
		$this->set(compact("show_form"));
		
		
	}
	
	private function setFinalsBattles() {

		$match_1 = $this->BatbMatch->returnMatch(407,true,true);
		
		$match_2 = $this->BatbMatch->returnMatch(406,true,true);
		
		$this->set(compact("match_1","match_2"));

	}
	
	
	public function confirm_vote() {
		
		$this->loadModel("BatbScore");
		$this->loadModel("BatbVote");
		if(count($this->data)) {
			
			$batb_event_id = $this->data['batb_event_id'];
			
			$ids = array(406,407,408,409);
			
			if(!$this->checkVotes()) {
				
				return $this->flash("Sorry, you're only allowed one vote for finals night","/battle-at-the-berrics-4",4);
				
			}
			
			$this->BatbScore->ensureScoreRow($this->Auth->user("id"),$batb_event_id);
			
			
			
			//check to see if the person has already voted
			foreach($ids as $id) {
				
				$this->BatbVote->create();

				$this->BatbVote->save(array(
				
					"match_winner_user_id"=>$this->data[$id]['match_winner_user_id'],
					"rps_winner_user_id"=>$this->data[$id]['rps_winner_user_id'],
					"winners_letters"=>$this->data[$id]['winners_letters'],
					"batb_event_id"=>$batb_event_id,
					"user_id"=>$this->Session->read("Auth.User.id"),
					"batb_match_id"=>$id
				
				));
	
			}
			
			return $this->flash("Thanks for voting. Finals Night is This Friday, make sure you're here for the most up to date info","/battle-at-the-berrics-4",4);
			
			
		} else {
			
			
			return $this->cakeError("error404");
			
			
		}
		
		
	}
	
	private function checkVotes($uid) {
		
		$this->loadModel("BatbVote");
		
		$ids = array(406,407,408,409);
		
		
		
		$votes = $this->BatbVote->find("all",array(
		
			"conditions"=>array(
				"BatbVote.batb_match_id"=>$ids,
				"BatbVote.user_id"=>$uid
			),
			"contain"=>array(
				"RpsWinnerUser",
				"MatchWinnerUser"
			)
		
		));
	
		if(count($votes)>0) {
			
			$this->set("finals_batb_votes",$votes);
			return false;
			
		} else {
			
			
			return true;
			
		}
		
		
	}
	
	
	
	
	
}