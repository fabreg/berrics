<?php

class OndemandTitle extends AppModel {
	
	
	public $belongsTo = array(
	
		
		"User"
	);
	
	public $hasAndBelongsToMany = array(
	
		"Tag",
		"Brand"
	
	);
	
	public $hasMany = array(
		"OndemandTitleMediaItem"
	);
	
	
	
	
}