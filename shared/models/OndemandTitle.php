<?php

class OndemandTitle extends AppModel {
	
	
	public $belongsTo = array(
		"User"
	);
	
	public $hasAndBelongsToMany = array(
		"Tag",
	);
	public $hasMany = array(
				"Dailyop"
			);
	
	
	
}