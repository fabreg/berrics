<?php

class HomeRoute extends CakeRoute {
	
	public function parse($url) {
		
		$params = parent::parse($url);

		if(empty($params)) {
			
			return false;
			
		}
		
		if(date("Y-m-d")=="2011-12-19" && $_SERVER['REQUEST_URI'] == "/dailyops") {
			
			$params['controller'] = "younited_nations";
			$params['action'] = "crews";
			
		}
		
		return $params;
	}
	
}