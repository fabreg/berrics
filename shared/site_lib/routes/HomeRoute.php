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
				

			case "2013-03-21":
			case "2013-03-22":
				$params['controller'] = "evan_smith_experience";
				$params['action'] = "section";
			break;

					
		}
		

		
		
		
		return $params;
	}
	
}