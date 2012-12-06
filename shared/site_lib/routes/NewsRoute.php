<?php

App::uses("CakeRoute","Router/Route");
class NewsRoute extends CakeRoute {

	public function parse($url) {

		$params = parent::parse($url);

		App::import("Model","Dailyop");

		$Dailyop = new Dailyop();
		
		if(count($params['pass'])<=0 && !isset($params['named']['datein'])) {

			//$params['named']['datein'] = $Dailyop->getNewsDate();

			//return $params;

		}

		if(isset($params['named']['datein']) && !preg_match('/([0-9]{4})(\-)([0-9]{2})(\-)([0-9]{2})/',$params['named']['datein'])) {

			throw new NotFoundException("Invalid News Date");

		}

		//validate the date
		//$params['named']['datein'] = $Dailyop->validateNewsDateRoute($params['named']['datein']);

		
		

		return $params;

	}

}