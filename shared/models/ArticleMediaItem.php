<?php


class ArticleMediaItem extends AppModel {
	
	
	
	public $belongsTo = array(
		"Article",
		"MediaFile"
	);
	
	
	
	
}
