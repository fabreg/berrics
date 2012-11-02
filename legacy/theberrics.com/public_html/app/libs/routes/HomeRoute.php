<?php

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
					
			case "2011-12-19":	
					$params['controller'] = "younited_nations";
					$params['action'] = "crews";
			break;
			
			//case "2012-04-01":
			case "2012-04-02":
			case "2012-04-03":
			case "2012-04-04":
				$params['controller'] = "sls_voting";
				$params['action'] = "section";
			break;
			
			case "2012-05-11":
			case "2012-05-12":
			case "2012-05-13":
				$params['controller'] = "yn3_voting";
				$params['action'] = "section";
				break;
					
		}
		

		
		
		
		return $params;
	}
	
}