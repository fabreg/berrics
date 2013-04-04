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
				

			case "2013-04-06":
			case "2013-04-07":
				if(in_array(date("Y-m-d"),array("2013-04-06","2013-04-07"))) {

					$params['controller'] = "progression";
					$params['action'] = "dailyops";

				}
			break;

					
		}
		

		
		
		
		return $params;
	}
	
}