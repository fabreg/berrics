<?php

class SplashDate extends AppModel {
	
	public $belongsTo = array(

		"SplashCreative"
				
	);

	public function getTodaysPages($date_in = false) {
		
		if(!$date_in)   { 
			
			$date_in = date("Y-m-d");
			
		} else {
			
			//$date_in = strtotime("-1 Day",strtotime($date_in));
			
		}
		
		$token = "splash-date-".$date_in;
		
		
		if(($pages = Cache::read($token,"1min")) === false) {
			
			$pages = $this->find("all",array(
						
					"conditions"=>array(
							"SplashDate.publish_date"=>$date_in
					),
					"contain"=>array("SplashCreative")
			
			));
			
			Cache::write($token,$pages,"1min");
			
		}
		
		if(count($pages)<=0) {
			
			return $this->getTodaysPages(date("Y-m-d",strtotime("-1 Day",strtotime($date_in))));
			
		} else {
			
			return $pages;
			
		}
		
		
		
	}
	
}