<?php

App::import("Controller","BatbApp");
class LeaderboardController extends BatbAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		
	}
	
	public function index($stats = "weekly") { 
		
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
		
		
		if($stats == "weekly") {
			
			//sum up the weekly stats based on the featured stats match
			$feat1 = $event['BatbEvent']['featured_stats1_id'];
			$feat2 = $event['BatbEvent']['featured_stats2_id'];
			
			
			$leaders = Cache::read("weekly_stats","stats");
			
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
							
							
				Cache::write("weekly_stats",$leaders,"stats");
				
			}
			
			
			
			
			
		} else {
			
			
			$leaders = Cache::read("overall_stats","stats");

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
					
					Cache::write("overall_stats",$leaders,"stats");
		
				
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
				"BatbMatch"=>array("Player1User","Player2User")
			),
			"order"=>array("BatbVote.created"=>"DESC")
		));
		
		
		
		
		$this->set(compact("user","votes","score"));
		
		
		//page title
		
		$this->set("title_for_layout","Profile: ".$user['User']['first_name']." ".$user['User']['last_name']);
		
		
		
		
	}
	
	
}

?>