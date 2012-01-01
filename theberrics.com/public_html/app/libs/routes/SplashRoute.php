<?php

class SplashRoute extends CakeRoute {
	
	public function parse($url) {
		
		$params = parent::parse($url);

		if(empty($params)) {
			
			return false;
			
		}
		
		$news = false;

		if(time()>=(strtotime("2011-08-14")) && in_array(strtoupper(date("D")),array("SUN","MON"))) {
			
			$news = true;
			
		}
		
		//$news = true;
		
		
		$params['controller'] = "splash";
		$params['action'] = "index";
		
		if($news) {
			
			$params['controller'] = "newsv2";
			$params['action'] = "section";

		}
		
		if(date('Y-m-d')=='2012-01-01') {
			
			$params['controller'] = "splash";
			$params['action'] = "ishod";
		
		} else {
			
			$params['controller'] = "splash";
			$params['action'] = "dc_rediscover";
			
		}
	

			
			
	
		return $params;
		
	}
	
}
