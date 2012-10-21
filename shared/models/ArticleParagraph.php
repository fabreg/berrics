<?php

class ArticleParagraph extends AppModel {
	
	public $belongsTo = array(
	
		"Article",
		"MediaFile"
	
	);
	

	
}