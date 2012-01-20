<?php

class BerricsRecordsItem extends AppModel {
	
	public $belongsTo = array(
		"User",
		"Dailyop",
		"BerricsRecord"
	);
	
	
}