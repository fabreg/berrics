<?php

class DailyopsRoute extends CakeRoute {
	
	
	public function parse($url) {
		
		$params = parent::parse($url);

		if(empty($params)) {
			
			return false;
			
		}
	
	
		App::import("Model","DailyopSection");
		
		$sec = new DailyopSection();
		
		$sections = $sec->returnSections();

		
		$token = Set::extract("/DailyopSection[uri=".$params['section']."]",$sections);
		
		if(isset($token[0]['DailyopSection']['uri'])) {
			
			//check to see if we can find the post, and if so, then cache that shit so we can posible use it in the dailyops controller and change the action to view

			if(!empty($params['uri'])) {

				//load up the daily ops model
				 
				App::import("Model","Dailyop");
				
				$dop = new Dailyop();
			
				$slug = md5($_SERVER['REQUEST_URI']);
				
				$post = $dop->returnPost(array(
					
					"Dailyop.uri"=>$params['uri'],
					"DailyopSection.uri"=>$params['section']
				
				),$_SERVER['DEVSERVER']);
				
				if(isset($post['Dailyop']['id'])) {
					
					$params['action'] = "view";
					
				} else if(!empty($params['uri'])) {
					
					$params['action'] = $params['uri'];
					
				}
				
				
			} 
			
			
			
							
			//check the directive
			if(!empty($token[0]['DailyopSection']['directive'])) {
				
				$params['controller'] = $token[0]['DailyopSection']['directive'];
				
				
			} else{
				
				$paras['controller'] = "dailyops";
				
			}
			
			
			return $params;
	
		}
		
		return false;
	
		
	}
	
	
	public function match() {
		
		
		
		
		
	}
	
	
}

?>