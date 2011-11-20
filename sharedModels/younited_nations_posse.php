<?php

class YounitedNationsPosse extends AppModel {
	
	public $hasMany = array(
			"YounitedNationsPosseMember"=>array(
					"foreignKey"=>"younited_nations_posse_id"
			),

			
	);
	
	public $hasOne = array(			"YounitedNationsEventEntry"=>array(
				"foreignKey"=>"younited_nations_posse_id"
			));
	
	
	
}