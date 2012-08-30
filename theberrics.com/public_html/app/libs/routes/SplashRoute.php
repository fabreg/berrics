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
			case "2012-07-16":
			case "2012-07-17":
				$params['action'] = "adidas_lucas";
				
			break;
			case "2012-07-21": //ronald creager
				$params['action'] = "index";
			break;
			case "2012-07-27": //nike prod
				$params['action'] = "nike_prod";
				break;
			case "2012-08-01":
			case "2012-08-02":
				$params['action'] = "index";
				break;
			case "2012-08-03":
			case "2012-08-04":
					$params['action'] = "levis";
					break;
			case "2012-08-21":
				$params['action'] = "raining_hesh";
				break;
			case '2012-08-26':
				$params['action'] = "sls_championship";
				$news = false;
				break;
			case '2012-08-27':
					$params['action'] = "index";
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
