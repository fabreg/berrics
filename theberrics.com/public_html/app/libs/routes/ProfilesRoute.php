<?php

class ProfilesRoute extends CakeRoute {
	
	public function parse($url) {
		
		$params = parent::parse($url);

		if(empty($params)) {
			
			return false;
			
		}
		
		//break up the url into pieces
		$parsed_url = parse_url($_SERVER['REQUEST_URI']);
		
		$url_p = explode("/",$parsed_url['path']);
		
		die(print_r($params));
		
		return false;
	}
	
	
}