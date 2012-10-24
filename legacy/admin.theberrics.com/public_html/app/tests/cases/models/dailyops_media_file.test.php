<?php
/* DailyopsMediaFile Test cases generated on: 2011-02-10 08:42:12 : 1297356132*/
App::import('Model', 'DailyopsMediaFile');

class DailyopsMediaFileTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyops_media_file', 'app.media_file', 'app.dailyop', 'app.user', 'app.dailyop_section', 'app.tag', 'app.dailyop_sections_tag', 'app.dailyops_tag');

	function startTest() {
		$this->DailyopsMediaFile =& ClassRegistry::init('DailyopsMediaFile');
	}

	function endTest() {
		unset($this->DailyopsMediaFile);
		ClassRegistry::flush();
	}

}
?>