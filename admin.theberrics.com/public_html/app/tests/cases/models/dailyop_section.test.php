<?php
/* DailyopSection Test cases generated on: 2011-02-10 08:42:12 : 1297356132*/
App::import('Model', 'DailyopSection');

class DailyopSectionTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyop_section', 'app.dailyop', 'app.tag', 'app.dailyop_sections_tag');

	function startTest() {
		$this->DailyopSection =& ClassRegistry::init('DailyopSection');
	}

	function endTest() {
		unset($this->DailyopSection);
		ClassRegistry::flush();
	}

}
?>