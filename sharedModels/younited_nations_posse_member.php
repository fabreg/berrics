<?php

class YounitedNationsPosseMember extends AppModel {
	
	
	public $belongsTo = array("YounitedNationsPosse");
	public $hasOne = array("User");
	
}