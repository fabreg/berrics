<?php

App::uses("CakeRoute","Router/Route");
class NewsRoute extends CakeRoute {

	public function parse($url) {
	
		$params = parent::parse($url);

		App::import("Model","Dailyop");

		$Dailyop = new Dailyop();
		
		if(count($params['pass'])<=0 && !isset($params['named']['datein'])) {

			$params['named']['datein'] = $Dailyop->getNewsDate();

			return $params;

		}

	}

}