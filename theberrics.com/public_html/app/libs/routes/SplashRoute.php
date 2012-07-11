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
			
			case "2012-07-09":
				$params['action'] = "cons_kenny";
				break;

			case "2012-07-10":
				$params['action'] = "quik";
				break;
			case "2012-07-11":
			case "2012-07-12":
			case "2012-07-13":
			case "2012-07-14":
			case "2012-07-15":
				$params['action'] = "sls_12_az";	
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
