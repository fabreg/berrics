<?php

class CoverPage extends AppModel {
	
	
	public $belongsTo = array(
	
		"Article",
		"MediaFile",
		"AberricaCategory"
		
	);
	
	
	
}
