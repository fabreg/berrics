<?php

class MediaFileUpload extends AppModel {
	
	
	public $belongsTo = array(
		"User",
		"BerricsRecord"=>array(
			"className"=>"BerricsRecord",
			"foreignKey"=>"foreign_key",
			"conditions"=>array("MediaFileUpload.model"=>"BerricsRecord")
		)
	);
	
	
}