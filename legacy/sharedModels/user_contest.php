<?php

class UserContest extends AppModel {
	
	public $hasMany = array("UserContestEntry");
	
	
	/**
	 * 
	 * @param unknown_type $UserContest
	 * @param unknown_type $User
	 * @return unknown_type
	 */
	public function addContestEntry($UserContest,$User) {
		
		
		
	}
	
	
	/**
	 * This Method Will Insert A Contest Entry And Ensure That There Is Only One Per User
	 * @param unknown_type $UserContest
	 * @param unknown_type $User
	 * @return unknown_type
	 */
	public function addContestEntryAtomic($UserContest,$User) {
		
		
		
		
	}
	
	
}