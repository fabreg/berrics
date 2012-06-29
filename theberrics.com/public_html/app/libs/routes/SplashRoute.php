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
		
		//$news = false;
		
		//$news = true;
		
		$params['controller'] = "splash";
		$params['action'] = "dc_kalis";
		
		if($news) {
			
			$params['controller'] = "newsv2";
			$params['action'] = "section";
			$params['pass'][] = date("Y");
			$params['pass'][] = date("m");
			$params['pass'][] = date("d");
			
		}
		
		if(in_array(date('Y-m-d'),array('2012-06-29'))) {
			
			$params['controller'] = "splash";
			$params['action'] = "cons_kenny";
			
		} 
		
		switch(date("Y-m-d")) {
			
			case "2012-07-03":
			case "2012-07-16":
			case "2012-07-17":
				$params['controller'] = "splash";
				$params['action'] = "adidas_lucas";
			break;
			
		}
		
		return $params;
		
	}
	
}
