<?php

App::uses("CakeRoute","Routing/Route");

class UnifiedRoute extends CakeRoute {


	public function parse($url) {

		$params = parent::parse($url);

		return $params;

	}

}
