<?php 

class UserAssignedPost extends AppModel {
	
	public $belongsTo = array(
		"Dailyop",
		"User"		
	);
	
	
}

