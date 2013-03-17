<?php
App::uses("CakeRoute","Routing/Route");
class HomeRoute extends CakeRoute {
	
	public function parse($url) {
		
		$params = parent::parse($url);

		if(empty($params)) {
			
			return false;
			
		}
		
		$date_in = date("Y-m-d");
		
		if(
		isset($params['year']) && 
		isset($params['month']) &&
		isset($params['day']) &&
		(strtotime("{$params['year']}-{$params['month']}-{$params['day']}")<time())
		) {
			
			$date_in = "{$params['year']}-{$params['month']}-{$params['day']}";
			
		}
		
		
		switch($date_in) {
					

					
		}
		

		
		
		
		return $params;
	}
	
}