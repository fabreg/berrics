<?php
/* DailyopsTag Test cases generated on: 2011-02-10 08:42:12 : 1297356132*/
App::import('Model', 'DailyopsTag');

class DailyopsTagTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyops_tag', 'app.dailyop', 'app.user', 'app.dailyop_section', 'app.tag', 'app.dailyop_sections_tag', 'app.media_file', 'app.dailyops_media_file');

	function startTest() {
		$this->DailyopsTag =& ClassRegistry::init('DailyopsTag');
	}

	function endTest() {
		unset($this->DailyopsTag);
		ClassRegistry::flush();
	}

}
?>