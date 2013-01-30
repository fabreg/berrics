<?php

class UserContestEntry extends AppModel {
		
	public $belongsTo = array("UserContest","User");
	
}