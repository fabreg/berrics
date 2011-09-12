<?php
/* MediaFilesRedaWednesday Test cases generated on: 2011-02-08 22:55:22 : 1297234522*/
App::import('Model', 'MediaFilesRedaWednesday');

class MediaFilesRedaWednesdayTestCase extends CakeTestCase {
	var $fixtures = array('app.media_files_reda_wednesday', 'app.media_file', 'app.user', 'app.media_file_user', 'app.media_file_view', 'app.battle_commander', 'app.battle_commanders_media_file', 'app.tag', 'app.battle_commanders_tag', 'app.dailyop', 'app.dailyop_section', 'app.dailyops_media_file', 'app.dailyops_tag', 'app.reda_wednesday', 'app.media_files_tag', 'app.txt_yoself', 'app.txt_yoselves_media_file');

	function startTest() {
		$this->MediaFilesRedaWednesday =& ClassRegistry::init('MediaFilesRedaWednesday');
	}

	function endTest() {
		unset($this->MediaFilesRedaWednesday);
		ClassRegistry::flush();
	}

}
?>