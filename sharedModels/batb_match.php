<?php

class BatbMatch extends AppModel {
	
	
	public $name = 'BatbMatch';
	
	
	public $belongsTo = array(
	
		"BatbEvent"=>array(
		
			"className"=>"BatbEvent"
			
		),
		"Player1User"=>array(
			"className"=>"User",
			"foreignKey"=>"player1_user_id"
		),
		"Player2User"=>array(
			"className"=>"User",
			"foreignKey"=>"player2_user_id"
		),
		"PreGameVideo"=>array(
			"className"=>"MediaFile",
			"foreignKey"=>"pregame_media_file_id"
		),
		"BattleVideo"=>array(
			"className"=>"MediaFile",
			"foreignKey"=>"video_media_file_id"
		),
		"PostGameVideo"=>array(
			"className"=>"MediaFile",
			"foreignKey"=>"postgame_media_file_id"
		),
		"PreGamePost"=>array(
			"className"=>"Dailyop",
			"foreignKey"=>"pregame_dailyop_id"
		),
		"BattlePost"=>array(
			"className"=>"Dailyop",
			"foreignKey"=>"battle_dailyop_id"
		),
		"PostGamePost"=>array(
			"className"=>"Dailyop",
			"foreignKey"=>"postgame_dailyop_id"
		)
	);
	
	public $hasOne = array(
		
		
	
	);
	
	public function createMatches($batb_event) {
		
		$event = $batb_event; 
		
		//$this->BatbEvent->findById($batb_event_id);
		
		$total_players = $event['BatbEvent']['num_players'];
		
		$matches_counter = $total_players / 2;
		
		$total_brackets = self::totalBrackets($total_players);
		
		//echo "TOTAL BRACKETS:".$total_brackets;
		
		for($total_brackets; $total_brackets>0; $total_brackets--) {
			
			$i = $matches_counter;
			
			$next_match_counter = ($i/2);
			
			for($i; $i>0; $i--) {
				
				
				if($i%2) {
					
					//echo "not a modulus of 2";
					$next_match_id = $next_match_counter;
					$next_match_counter--;
							
				} else {
					
					//echo "is a modulus of 2";
					$next_match_id = $next_match_counter;
				}
				
				
				$this->create();
				
				$data = array(
				
					"batb_event_id"=>$event['BatbEvent']['id'],
					"bracket_num"=>$total_brackets,
					"next_bracket_num"=>($total_brackets-1),
					"match_num"=>$i,
					"next_match_num"=>$next_match_id
				
				);
				
				$this->save($data);
				
				/*
				echo "<div style='border:1px solid #999999; margin:5px; margin-left:".($total_brackets*5)."px;'>";
				echo "Bracket: ".$total_brackets;
				echo "<br />";
				echo "Match #: ".$i;
				echo "<br />";
				echo "Next Match: M=".$next_match_id."; B=".($total_brackets-1);
				echo "</div>";
				*/	
			}
			
			$matches_counter /= 2 ;
			
		}
		
		//lets create the thrid place match
		$this->create();
		
		$thirdData = array(
		
			"batb_event_id"=>$event['BatbEvent']['id'],
			"bracket_num"=>0,
			"match_num"=>1,
		
		);
		
		$this->save($thirdData);
		
		
	}
	
	
	public static function totalBrackets($total_players) {
			
			$factor = $total_players / 2;
			
			$c = 0;
			
			for($factor;$factor >= 1;$factor /= 2) {
				
				$c++;
				
			}
			
			return $c;
			
	}
	
	public function updateWinners($data) {
		
		
		//ok, we have the winning data so lets update our match
		$this->id = $data['BatbMatch']['id'];
		
		$this->save(array(
		
			"rps_winner_user_id"=>$data['BatbMatch']['rps_winner_user_id'],
			"match_winner_user_id"=>$data['BatbMatch']['match_winner_user_id'],
			"winner_letters"=>$data['BatbMatch']['winner_letters'],
			"week_num"=>$data['BatbMatch']['week_num']
		
		));
		
		$match = $this->read();
		
		
		
		//time to advance the players to the next match
		
		switch($match['BatbMatch']['bracket_num']) {
				
			case 1:
				//FINALS!!!!
				$this->handleFinalMatch($match);
			break;

			break;
			
			case 0:
				//just completed the thrid place match	
				$this->handleConsolationMatch($match);
			break;
			
			default: //normal tournament match, advance the winner to the next bracket
				
				$this->advancePlayers($match);
				
				//if this was bracket two, send the loser to the colsolation match
				
				if($match['BatbMatch']['bracket_num'] == 2) {
					
					$this->handleBracketTwo($match);
					
				}
				
			break;
		}
		

		
		
	}
	
	public function handleFinalMatch($match) {
		
		//whos the winner?
		$win_user_id = $match['BatbMatch']['match_winner_user_id'];
		
		//now that we got the winner let's find the second place guy
		if($match['BatbMatch']['player1_user_id'] == $win_user_id) {
			
			$second_user_id = $match['BatbMatch']['player2_user_id'];
			
		} else {
			
			$second_user_id = $match['BatbMatch']['player1_user_id'];
			
		}
		
		//ok now lets update the event with the first and second place peeps
		$eventData = array(
		
			"first_place_user_id" =>$win_user_id,
			"second_place_user_id"=>$second_user_id
		
		);
		
		$event_id = $match['BatbMatch']['batb_event_id'];
		
		$this->BatbEvent->id = $event_id;
		
		$this->BatbEvent->save($eventData);

		
	}
	
	public function handleConsolationMatch($match) {
		
		//let's place the winner in the thrid place column of the event
		$winner_user_id = $match['BatbMatch']['match_winner_user_id'];
		
		$event_id = $match['BatbMatch']['batb_event_id'];
		
		$this->BatbEvent->id = $event_id;
		
		$this->BatbEvent->save(array("third_place_user_id"=>$winner_user_id));
		
	}
	
	public function handleBracketTwo($match) {
		
		//lets get the winner of the match
		$winner_user_id = $match['BatbMatch']['match_winner_user_id'];
		
		//now lets determin who lost
		if($winner_user_id == $match['BatbMatch']['player1_user_id']) {
			
			$loser_user_id = $match['BatbMatch']['player2_user_id'];
			
		} else {
			
			$loser_user_id = $match['BatbMatch']['player1_user_id'];	
		
		}
		
		$c_match = $this->find("first",array(
		
			"conditions"=>array(
				"batb_event_id"=>$match['BatbMatch']['batb_event_id'],
				"bracket_num" => 0
			)	
		
		));
		
		$updateData = array();
		
		//which spot does this guy go into?
		if(empty($c_match['BatbMatch']['player1_user_id'])) {
			
			$updateData['player1_user_id'] = $loser_user_id;
			
		} else {
			
			$updateData['player2_user_id'] = $loser_user_id;
			
		}
		
		$this->create();
		
		$this->id = $c_match['BatbMatch']['id'];
		
		$this->save($updateData);
		
	}
	
	public function advancePlayers($match) {
		
		//ok, now lets get the next match
			
			$nextMatch = $this->find("first",array(
				
				"conditions"=>array(
					"BatbMatch.batb_event_id"=>$match['BatbMatch']['batb_event_id'],
					"BatbMatch.bracket_num"=>$match['BatbMatch']['next_bracket_num'],
					"BatbMatch.match_num"=>$match['BatbMatch']['next_match_num']
				),
				"contain"=>array()
			
			));
			
			//die($nextMatch['BatbMatch']['id']);
			
			//we now have the next match, let's see which slot is open and throw the winner in there
			//next_match_num
			//next_bracket_num
			
			$nextData = array();
			
			if(empty($nextMatch['BatbMatch']['player1_user_id'])) {
				
				$nextData['player1_user_id'] = $this->data['BatbMatch']['match_winner_user_id'];
				
			} else {
				
				$nextData['player2_user_id'] = $this->data['BatbMatch']['match_winner_user_id'];
				
			}
			
			$this->create();
			
			$this->id = $nextMatch['BatbMatch']['id'];
			
			$this->save($nextData);
		
	}
	
	public function flipPositions($id) {
		
		$match = $this->find("first",array(
		
					"conditions"=>array(
						"BatbMatch.id"=>$id
					),
					"contain"=>array()
				
				));
		
		$player1 = $match['BatbMatch']['player1_user_id'];
		$player2 = $match['BatbMatch']['player2_user_id'];
		
		//time to save the shit
		$this->create();
		$this->id = $id;
		$this->save(array(
		
			"player1_user_id"=>$player2,
			"player2_user_id"=>$player1	
		
		));
		
		
	}
	
	public function returnMatch($id,$usePosts = false,$users = false) {
		
		$cache_token = "batb_match_".$id."_".$usePosts."_".$users;
		
		$contain = array(
					"PreGameVideo",
					"BattleVideo",
					"PostGameVideo"
				);
				
		if($usePosts) {
			
			$contain = array();
			
		}
		
		if($users) {
			
			$contain[] = "Player1User";
			$contain[] = "Player2User";
			
		}
			
		
		if(($match = Cache::read($cache_token,"1min")) === false) {
			
			$match = $this->find("first",array(
			
				"conditions"=>array(
					"BatbMatch.id"=>$id
				),
				"contain"=>$contain
			
			));
			
			
			if($usePosts) {
				
					App::import("Model","Dailyop");
					$dailyop = new Dailyop();
					
					
					
					if(!empty($match['BatbMatch']['pregame_dailyop_id'])) {
						
						$match['PreGamePost'] = $dailyop->returnPost(array(
						
							"Dailyop.id"=>$match['BatbMatch']['pregame_dailyop_id']
						
						));
						
					}
					
					
					if(!empty($match['BatbMatch']['battle_dailyop_id'])) {
						
						
						$match['BattlePost'] = $dailyop->returnPost(array(
						
							"Dailyop.id"=>$match['BatbMatch']['battle_dailyop_id']
						
						));
						
					}
					
					if(!empty($match['BatbMatch']['postgame_dailyop_id'])) {
						
						
						$match['PostGamePost'] =$dailyop->returnPost(array(
						
							"Dailyop.id"=>$match['BatbMatch']['postgame_dailyop_id']
						
						));
						
					}
					
						
					
				
				
			}
			
			
			Cache::write($cache_token,$match,"1min");
			
		}
		
		
		return $match;
		
		
	}
	
	
	public static function winningLettersDrop() {
		
		$a = array(
			
			0=>"nada",
			1=>"S",
			2=>"S.K",
			3=>"S.K.A",
			4=>"S.K.A.T"
			
		);
		
		return $a;
		
	}
	
	
	
}