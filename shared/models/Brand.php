<?php

class Brand extends AppModel {
	
	
	public $hasAndBelongsToMany = array(
	
		"Tag",
		"OndemandTitle"
	
	);
	
}