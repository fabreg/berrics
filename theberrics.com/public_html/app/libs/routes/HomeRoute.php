<?php

class HomeRoute extends CakeRoute {
	
	public function parse($url) {
		
		$params = parent::parse($url);

		if(empty($params)) {
			
			return false;
			
		}
		
		$news = false;
		
		$ts_in = strtotime($params['year']."-".$params['month']."-".$params['day']);
		
		if($ts_in > 1) {
			
			if(date("N",$ts_in) == 7 && ($ts_in >= strtotime("2011-08-14"))) {
				
				$news = true;
				
			}
			
		} else {
			
			if(time()>=(strtotime("2011-08-14")) && (date("N") == 7)) {
				
				$news = true;
				
			}
			
		}
		
		
		
		
		
		if($news) {
			
			$params['controller'] = "news";
			$params['action'] = "section";
			
			$params['pass'][0] = $params['year'];
			$params['pass'][1] = $params['month'];
			$params['pass'][2] = $params['day'];
		}
		
		
		/*
		 * WOW, GOOD LUCK REMEMBERING WTF THIS IS ALL ABOUT
		 * 
		 * 
		 * FIX BANG YOSELF INDESICIVNESS
		 */
		if(
			$params['year'] == '2011' && 
			$params['month'] == '09' && 
			$params['day'] == '17'
		
		) {
			
			$params['controller'] = "bangyoself";
			$params['action'] = "voting";
			
		}
		
		return $params;
	}
	
}