<?php

class DailyLegacy extends Model {
	
	public $useDbConfig = "legacy";
	
	public $useTable = "daily_ops";
	
	
	public $hasMany = array(
	
		"Media"=>array(
	
			"className"=>"Media",
			"foreignKey"=>"entry"
	
		)
	
	);
	
}

?>