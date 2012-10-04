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
			
			case "2012-10-03":
				$params['action'] = "cosmic";
			
				break;
			case "2012-10-01":
				$params['action'] = "dc_felipe";
				$params['pass'][0]=3;
				
				break;
			case "2012-09-18":
					$params['action'] = "lrg_gallo";
					break;
			case '2012-22-22':
				if(time()%2) {
					
					$params['action'] = "dc_felipe";
					$params['pass'][0]=2;
					
				} else {
					
					$params['action'] = "lrg_gallo";
					
				}
				break;
			case "2012-10-04":
			default:
				$pages = array(
					"dc_felipe",
					"cosmic",
					"lrg_gallo",
					"raining_hesh"
				);
				
				$seed = mt_rand(0,3);
				
				$params['action'] = $pages[$seed];
				
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
