<?php
/* DailyopFeature Test cases generated on: 2011-02-08 16:58:17 : 1297213097*/
App::import('Model', 'DailyopFeature');

class DailyopFeatureTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyop_feature', 'app.dailyop');

	function startTest() {
		$this->DailyopFeature =& ClassRegistry::init('DailyopFeature');
	}

	function endTest() {
		unset($this->DailyopFeature);
		ClassRegistry::flush();
	}

}
?>