<?php
App::uses("CakeRoute","Routing/Route");
class HomeRoute extends CakeRoute {
	
	public function parse($url) {
		
		$params = parent::parse($url);

		if(empty($params)) {
			
			return false;
			
		}

		$params['controller'] = "dailyops";
		$params['action'] = "index";
		
		$date_in = date("Y-m-d");
		
		if(
		isset($params['year']) && 
		isset($params['month']) &&
		isset($params['day']) &&
		(strtotime("{$params['year']}-{$params['month']}-{$params['day']}")<time() || (isset($_GET['showall']) && preg_match('/(dev\.|v3\.)/',$_SERVER['HTTP_HOST'])))
		) {
			
			$date_in = $params['dateIn'] = "{$params['year']}-{$params['month']}-{$params['day']}";
			$params['action'] = "archive";

		}

		
		
		switch($date_in) {
				

			case "2013-04-06":
			case "2013-04-07":
				if(in_array(date("Y-m-d"),array("2013-04-06","2013-04-07"))) {

					$params['controller'] = "progression";
					$params['action'] = "dailyops";

				}
			break;
			case "2013-04-30":
				if(in_array(date("Y-m-d"),array("2013-04-30"))) {

					$params['controller'] = "deathwish_video";
					$params['action'] = "section";

				}
			break;


					
		}
		

		
		
		
		return $params;
	}
	
}