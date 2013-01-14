<?php 

App::uses("DailyopsController","Controller");

class Batb6Controller extends DailyopsController {


	private $event_id = 50019;

	public $helpers = array("Form");

	public function beforeFilter() {

		parent::beforeFilter();

		$this->theme = "battle-at-the-berrics-6";

		if($this->request->params['action'] == "view") {


			$this->request->params['action'] = "section";
			$this->request->params['view'] = "section";

		}

	}

	public function __section() {

		//set the body element
		$this->set("body_element","layout/body-element");

		$this->loadModel('BatbEvent');
			
		//get the event //batb6 = 50019
		$event = $this->BatbEvent->returnEvent(50019);

		$this->setFeaturedMatches($event);

		$this->set(compact("event"));

		

	}

	public function view() {






	}

	public function section() {
		

		//set the body element
		$this->set("body_element","layout/body-element");

		if($this->request->is("post") || $this->request->is("put")) {
		
			$this->handleVoteSubmit();
		
		}
		
		//clear out the right columnd
		$this->set("right_column","");
		
		//load the events model
		$this->loadModel("BatbEvent");
		
		//get and set the event
		$event = $this->BatbEvent->returnEvent($this->event_id,false,true);
		$this->set(compact("event"));
		
		//set the featured matches attached to the event
		$this->setFeaturedMatches($event);
		
		//$this->setFinalsVoting($event);
		
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
		if(isset($this->request->params['named']['battle']) && !empty($this->request->params['named']['battle'])) {
				
			//match id
			$match_id = base64_decode($this->request->params['named']['battle']);
			
			$this->loadModel("BatbMatch");
			
			$match = $this->BatbMatch->find("first",array(

				"conditions"=>array(
					"BatbMatch.id"=>$match_id
				)
				
			));
			
			if(empty($match['BatbMatch']['id'])) {
				
				throw new NotFoundException();
				
			}
			
			//check for pregame
			
			if(!empty($match['BatbMatch']['pregame_dailyop_id'])) $posts[] = $this->Dailyop->returnPost(array("Dailyop.id"=>$match['BatbMatch']['pregame_dailyop_id']));
						
			//check for battle
			
			if(!empty($match['BatbMatch']['battle_dailyop_id'])) $posts[] = $this->Dailyop->returnPost(array("Dailyop.id"=>$match['BatbMatch']['battle_dailyop_id']));
			
			//check postgame
			
			if(!empty($match['BatbMatch']['postgame_dailyop_id'])) $posts[] = $this->Dailyop->returnPost(array("Dailyop.id"=>$match['BatbMatch']['postgame_dailyop_id']));
			
			
		} else if(!empty($this->request->params['uri'])) {
			
			
			$posts[] = $this->Dailyop->returnPost(array(
					
					"DailyopSection.uri"=>$this->request->params['section'],
					"Dailyop.uri"=>$this->request->params['uri'],
					"Dailyop.active"=>1
			
			),$this->isAdmin());
			
			//die(print_r($posts));
			
			$this->pt .=": ".$posts[0]['Dailyop']['name']." - ".$posts[0]['Dailyop']['sub_title'];
			
			$this->setFacebookMetaData($posts[0]);
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
		
		if(!$this->Session->check("Auth.User.id")) throw new NotFoundException();
		
		if(count($this->request->data)>0) {
			
			//ensure the user has a score row for this event
			$this->BatbScore->ensureScoreRow($this->Auth->user("id"),$this->event_id);
			
			//insert the vote
			$this->request->data['BatbVote']['user_id'] = $this->Session->read("Auth.User.id");
			$this->request->data['BatbVote']['batb_event_id'] = $this->event_id;
			
			if($this->BatbVote->save($this->request->data)) {
				
				return $this->flash("Thanks for voting!","/battle-at-the-berrics-6?".microtime());
				
			}
			
		}
		
	}


	public function ajax_leaderboard($type = "overall") {
		
		$this->skip_page_view = true;
		
		//load the stats
		$this->leaderboard($type);
		
		return $this->render("/Elements/leader-summary");
		
	}
	
	private function leaderboard($stats = "weekly") { 
		
		$this->loadModel("User");
		$this->loadModel("BatbScore");
		$this->loadModel("BatbVote");
		$this->loadModel("BatbEvent");
		
		$event = $this->BatbEvent->find("first",array(
		
			"conditions"=>array(
				"BatbEvent.id"=>$this->event_id
			),
			"contain"=>array()
		
		));
		
		//$stats = "overall";
		
		
		if($stats == "weekly") {
			
			//sum up the weekly stats based on the featured stats match
			$feat1 = $event['BatbEvent']['featured_stats1_id'];
			$feat2 = $event['BatbEvent']['featured_stats2_id'];
			
			
			$leaders = Cache::read("batb6_weekly_stats","5min");
			
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
								"limit"=>50,
								"contain"=>array()
							
							));
							
							
				Cache::write("batb6_weekly_stats",$leaders,"5min");
				
			}
			
			
			
			
			
		} else {
			
			
			$leaders = Cache::read("batb6_overall_stats","5min");

			if($leaders === false) {
				
		
					$leaders = $this->BatbScore->find('all',array(
				
						"fields"=>array("(BatbScore.rps_score+BatbScore.match_score+BatbScore.letters_score) AS `total`,
											User.first_name,User.last_name,User.facebook_account_num,User.id,
											BatbScore.rps_score,BatbScore.match_score,BatbScore.letters_score"),
						"conditions"=>array("BatbScore.batb_event_id"=>$this->event_id),
						"contain"=>array("User"),
						"limit"=>50,
						"order"=>array("total"=>"DESC")
					
					));
					
					Cache::write("batb6_overall_stats",$leaders,"5min");
		
				
			}
			

			
			
		}
		
		
		
		$this->set(compact("leaders"));
		
		
	}


	public function scorecard($user_id = false) {
		
		//set the body element
		$this->set("body_element","layout/body-element");
		
		//
		if(!$user_id && $this->Session->check("Auth.User.id")) return $this->redirect("/battle-at-the-berrics-5/scorecard/".$this->Session->read("Auth.User.id"));
		
		//check the id
		if(!$user_id) throw new NotFoundException();
		
		$this->loadModel("BatbVote");
		$this->loadModel("User");
		$this->loadModel("BatbScore");
		
		$profile = $this->User->returnUserProfile($user_id);
		
		//if user isn't found bounce'em
		if(!isset($profile['User']['id'])) throw new NotFoundException();
		
		//page title
		$title_for_layout = "DC Shoes Presents: Battle At The Berrics 5 - ".$profile['User']['first_name']." ".$profile['User']['last_name'];
		

		//get all the users votes
		$votes = $this->BatbVote->find("all",array(
			"conditions"=>array(
				"BatbVote.batb_event_id"=>$this->event_id,
				"BatbVote.user_id"=>$user_id
			),
			"contain"=>array(
				"BatbMatch"=>array(
					"Player1User",
					"Player2User"
				)
			)
		));
		
		//get the summary row
		$score_total = $this->BatbScore->find("first",array(
			"conditions"=>array(
				"BatbScore.user_id"=>$profile['User']['id'],
				"BatbScore.batb_event_id"=>$this->event_id
			),
			"contain"=>array()
		));
		
		$this->set(compact("profile","votes","title_for_layout","score_total"));
		
		//die(print_r($votes));
		
	}
	
	public function my_scorecard() {
		
		if(!$this->Session->check("Auth.User.id")) {
			
			return $this->redirect("/identity/login/send_to_facebook/".base64_encode($this->request->here));
			
		} else {
			
			return $this->redirect("/battle-at-the-berrics-6/scorecard/".$this->Session->read("Auth.User.id"));
			
		}
		
	}


}
