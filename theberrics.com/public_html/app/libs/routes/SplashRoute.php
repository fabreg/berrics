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
		
		//$news = true;
		
		$params['controller'] = "splash";
		$params['action'] = "index";
		
		if($news) {
			
			$params['controller'] = "newsv2";
			$params['action'] = "section";

		}
		
		if(in_array(date('Y-m-d'),array('2012-04-12'))) {
			
			$params['controller'] = "splash";
			$params['action'] = "dc_apr";
			
		} 

		
		return $params;
		
	}
	
}
