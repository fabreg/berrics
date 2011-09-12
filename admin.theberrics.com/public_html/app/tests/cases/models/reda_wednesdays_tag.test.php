<?php
/* RedaWednesdaysTag Test cases generated on: 2011-02-08 22:55:22 : 1297234522*/
App::import('Model', 'RedaWednesdaysTag');

class RedaWednesdaysTagTestCase extends CakeTestCase {
	var $fixtures = array('app.reda_wednesdays_tag', 'app.reda_wednesday', 'app.user', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.battle_commander', 'app.battle_commanders_media_file', 'app.tag', 'app.battle_commanders_tag', 'app.dailyop', 'app.dailyop_section', 'app.dailyops_media_file', 'app.dailyops_tag', 'app.media_files_reda_wednesday', 'app.media_files_tag', 'app.txt_yoself', 'app.txt_yoselves_media_file');

	function startTest() {
		$this->RedaWednesdaysTag =& ClassRegistry::init('RedaWednesdaysTag');
	}

	function endTest() {
		unset($this->RedaWednesdaysTag);
		ClassRegistry::flush();
	}

}
?>