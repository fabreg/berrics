<?php

App::uses("BatbMatch","Model");

class BatbEvent extends AppModel {
	
	public $name = "BatbEvent";
	
	public $hasMany = array(
	
		"BatbMatch"=>array(
	
			"className"=>"BatbMatch"
	
		)
	
	);
	
	
	public function createEvent($data) {
		
		$this->save($data);
	
	}
	
	
	public static function numPlayersDrop() {
		
		$a = array();
		
		$a[4]="4 Players | Brackets: ".BatbMatch::totalBrackets(4);
		$a[8]="8 Players | Brackets: ".BatbMatch::totalBrackets(8);
		$a[16]="16 Players | Brackets: ".BatbMatch::totalBrackets(16);
		$a[32]="32 Players | Brackets: ".BatbMatch::totalBrackets(32);
		$a[64]="64 Players | Brackets: ".BatbMatch::totalBrackets(64);
		
		return $a;
		
	}
	
	public function returnEvent($id,$videos = false,$posts = false) {
		
		
		$token = "batb_".$id."_".$videos."_".$posts;
		
		if(($event = Cache::read($token,"1min")) === false || isset($_SERVER['DEVSERVER'])) {
			
			//lets get the general event deatils
			$event = $this->find("first",array(
				
				"conditions"=>array("BatbEvent.id"=>$id),
				"contain"=>array()
			
			));
			
			
			//lets grab all the matches
			
			$players = $event['BatbEvent']['num_players'];
			
			$num_brackets = BatbMatch::totalBrackets($players);
			
			$brackets = array();
			
			$contain = array(
				"Player1User",
				"Player2User"
			);
			
			if($videos) {
				
					$contain[]="PreGameVideo";
					$contain[]="BattleVideo";
					$contain[]="PostGameVideo";
				
			} else if($posts) {
				
				$contain = array(
					"BattlePost"=>array(
				
						"DailyopMediaItem"=>array("MediaFile","order"=>array(
			
							"DailyopMediaItem.display_weight"=>"ASC"
			
						))
					
					),
					"PreGamePost"=>array(
				
						"DailyopMediaItem"=>array("MediaFile","order"=>array(
			
							"DailyopMediaItem.display_weight"=>"ASC"
			
						))
					
					),
					"PostGamePost"=>array(
				
						"DailyopMediaItem"=>array("MediaFile","order"=>array(
			
							"DailyopMediaItem.display_weight"=>"ASC"
			
						))
					
					),
					"Player1User",
					"Player2User"
				);
				
				//$contain = array();
				
			}
			
			for($num_brackets;$num_brackets >= 0; $num_brackets--) {
				
				$matches = $this->BatbMatch->find("all",array(
				
					"conditions"=>array(
						"BatbMatch.batb_event_id"=>$event['BatbEvent']['id'],
						"BatbMatch.bracket_num"=>$num_brackets
					),
					"order"=>array("BatbMatch.match_num"=>"ASC"),
					"contain"=>$contain
				));
				
				if($posts) {
						
					
					App::import("Model","Dailyop");
					$dailyop = new Dailyop();
					foreach($matches as $k=>$v) {
						
						
						if(!empty($v['BatbMatch']['pregame_dailyop_id'])) {
							
							$matches[$k]['PreGamePost'] = $dailyop->returnPost(array(
							
								"Dailyop.id"=>$v['BatbMatch']['pregame_dailyop_id']
							
							));
							
						}
						
						
						if(!empty($v['BatbMatch']['battle_dailyop_id'])) {
							
							
							$matches[$k]['BattlePost'] = $dailyop->returnPost(array(
							
								"Dailyop.id"=>$v['BatbMatch']['battle_dailyop_id']
							
							));
							
						}
						
						if(!empty($v['BatbMatch']['postgame_dailyop_id'])) {
							
							
							$matched[$k]['PostGamePost'] =$dailyop->returnPost(array(
							
								"Dailyop.id"=>$v['BatbMatch']['postgame_dailyop_id']
							
							));
							
						}
						
						
					}
					
				}
				
				
				$brackets[$num_brackets]=$matches;
				
			}

			$event['Brackets'] = $brackets;
			
			Cache::write($token,$event,"1min");
			
		}
		
		return $event;
		
	}
	
	public function setFeaturedMatch($match_id,$position) {
		
		//get the match
		$match = $this->BatbMatch->find("first",array(
		
			"conditions"=>array(
				"BatbMatch.id"=>$match_id
			),
			"contain"=>array()
		
		));

		$updateData = array();
		
		switch($position) {
			
			case 1:
				$updateData['featured_match1_id'] = $match_id;
			break;
			case 2:
				$updateData['featured_match2_id'] = $match_id;
			break;
		}
		
		$this->id = $match['BatbMatch']['batb_event_id'];

		$this->save($updateData);
		
	}
	
	public function setFeaturedStats($match_id,$position) {
		
		//get the match
		$match = $this->BatbMatch->find("first",array(
		
			"conditions"=>array(
				"BatbMatch.id"=>$match_id
			),
			"contain"=>array()
		
		));

		$updateData = array();
		
		switch($position) {
			
			case 1:
				$updateData['featured_stats1_id'] = $match_id;
			break;
			case 2:
				$updateData['featured_stats2_id'] = $match_id;
			break;

		}
		
		$this->id = $match['BatbMatch']['batb_event_id'];

		$this->save($updateData);
		
	}

	public function calcUser($user_id = false,$batb_event_id = false) {

		$User = ClassRegistry::init("User");
		$BatbScore = ClassRegistry::init("BatbScore");
		$BatbVote = ClassRegistry::init("BatbVote");

		//$user = $User->returnProfile($user_id);

		//get the users score row
		$score = $BatbScore->ensureScoreRow($user_id,$batb_event_id);

		//get all the votes from the event

		$votes = $BatbVote->find("all",array(
				"conditions"=>array(
					"BatbVote.batb_event_id"=>$batb_event_id,
					"BatbVote.user_id"=>$user_id
				),
				"contain"=>array(
					"BatbMatch"=>array(
						"Player1User",
						"Player2User"
					)
				)
		));

		$scoreData = array(
			"rps_score"=>0,
			"match_score"=>0,
			"letters_score"=>0
		);

		//recalc each vote

		foreach($votes as $vote) {

			//check to see if the attached match has a winner

			if(
				!empty($vote['BatbMatch']['match_winner_user_id']) && 
				!empty($vote['BatbMatch']['rps_winner_user_id']) && 
				!empty($vote['BatbMatch']['winner_letters'])
			) {

				$voteData = array();

				//check rps winner and assign points
				if($vote['BatbVote']['rps_winner_user_id'] == $vote['BatbMatch']['rps_winner_user_id']) {

					$voteData['rps_points'] = 1;

				} else {

					$voteData['rps_points'] = 0;

				}

				//check the match winner and assign points
				if($vote['BatbVote']['match_winner_user_id'] == $vote['BatbMatch']['match_winner_user_id']) { 

					$voteData['match_points'] = 10;

				} else {

					$voteData['match_points'] = 0;

				}

				//check the letters points

				if($vote['BatbVote']['winner_letters'] == $vote['BatbMatch']['winner_letters']) {

					$voteData['letter_points'] = 15;

				} else {

					$voteData['letter_points'] = 0;

				}

				$BatbVote->id = $vote['BatbVote']['id'];
				print_r($voteData);
				//$BatbVote->save($voteData);

				$scoreData['rps_score'] += $voteData['rps_points'];
				$scoreData['match_score'] += $voteData['match_points'];
				$scoreData['letters_score'] += $voteData['letter_points'];


			} else {

				continue;

			}

		}

		print_r($scoreData);


		die(pr($votes));


	}
	
	
}

