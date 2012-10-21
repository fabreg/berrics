<?php

class CanteenProductPrice extends AppModel {
	
	
	public $belongsTo = array(
	
		"CanteenProduct",
		"Currency"
	);
	
	
}