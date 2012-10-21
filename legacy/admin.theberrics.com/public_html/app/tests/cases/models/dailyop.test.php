<?php
/* Dailyop Test cases generated on: 2011-02-10 08:42:12 : 1297356132*/
App::import('Model', 'Dailyop');

class DailyopTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyop', 'app.user', 'app.dailyop_section', 'app.tag', 'app.dailyop_sections_tag', 'app.media_file', 'app.dailyops_media_file', 'app.dailyops_tag');

	function startTest() {
		$this->Dailyop =& ClassRegistry::init('Dailyop');
	}

	function endTest() {
		unset($this->Dailyop);
		ClassRegistry::flush();
	}

}
?>