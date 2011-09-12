<?php

class StaticRoute extends CakeRoute {
	
	
	
	public function parse($url) {
		
		$params = parent::parse($url);
		return false;
		die(print_r($params));
		
		
	}
	
}

?>