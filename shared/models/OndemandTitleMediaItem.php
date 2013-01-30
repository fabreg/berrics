<?php

class OndemandTitleMediaItem extends AppModel {


	public $belongsTo = array(
		"OndemandTitle",
		"MediaFile"
	);
	
	
	
	
}