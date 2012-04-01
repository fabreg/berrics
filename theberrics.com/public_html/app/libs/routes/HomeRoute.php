<?php

class HomeRoute extends CakeRoute {
	
	public function parse($url) {
		
		$params = parent::parse($url);

		if(empty($params)) {
			
			return false;
			
		}
		
		
		if($_SERVER['REQUEST_URI'] == "/dailyops") {
			
			
				if(date("Y-m-d")=="2011-12-19") {
					
					$params['controller'] = "younited_nations";
					$params['action'] = "crews";
					
				}
				
				switch(date("Y-m-d")) {
					
					
					case "2012-04-02":
					case "2012-04-03":
					case "2012-04-04":
						$params['controller'] = "sls_voting";
						$params['action'] = "section";
					break;
					
				}
			
		}
		
		
		
		return $params;
	}
	
}