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
			
			
			case "2012-10-15":
				$params['action'] = "dc_youth";
			break;

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
