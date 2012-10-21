<?php

class YounitedNationsPosseMember extends AppModel {

	public $belongsTo = array(
					"YounitedNationsPosse"=>array(
						"class"=>"YounitedNationsPosse",
						"foreignKey"=>"younited_nations_posse_id"
					)
	);
	public $hasOne = array("User");
		
}