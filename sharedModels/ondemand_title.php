<?php

class OndemandTitle extends AppModel {
	
	
	public $belongsTo = array(
	
		"Brand"
	
	);
	
	public $hasAndBelongsToMany = array(
	
		"Tag",
		"Brand"
	
	);
	
	
	
}