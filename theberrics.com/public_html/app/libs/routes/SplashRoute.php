<?php

class SplashRoute extends CakeRoute {
	
	public function parse($url) {
		
		$params = parent::parse($url);

		if(empty($params)) {
			
			return false;
			
		}
		
		$news = false;

		if(time()>=(strtotime("2011-08-14")) && in_array(strtoupper(date("D")),array("SUN"))) {
			
			$news = true;
			
		}
		
		$params['controller'] = "splash";
		

		
		switch(date("Y-m-d")) {
			
			case "2012-09-24":
			case "2012-09-25":
			case "2012-09-26":
				$params['action'] = "dc_felipe";
				$params['pass'][0]=2;
				
				break;
			case "2012-09-18":
					$params['action'] = "lrg_gallo";
					break;
			default:
				$params['action'] = "index";
				break;
			
		}
		
	
		if($news) {
			
			$params['controller'] = "newsv2";
			$params['action'] = "section";
			$params['pass'][] = date("Y");
			$params['pass'][] = date("m");
			$params['pass'][] = date("d");
			
		}
		
		return $params;
		
	}
	
}
