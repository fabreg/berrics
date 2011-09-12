<?php
/* TxtYoself Test cases generated on: 2011-02-08 22:55:23 : 1297234523*/
App::import('Model', 'TxtYoself');

class TxtYoselfTestCase extends CakeTestCase {
	var $fixtures = array('app.txt_yoself', 'app.user', 'app.tag', 'app.battle_commander', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.battle_commanders_media_file', 'app.dailyop', 'app.dailyop_section', 'app.dailyops_media_file', 'app.dailyops_tag', 'app.reda_wednesday', 'app.media_files_reda_wednesday', 'app.reda_wednesdays_tag', 'app.media_files_tag', 'app.txt_yoselves_media_file', 'app.battle_commanders_tag', 'app.tags_txt_yoself');

	function startTest() {
		$this->TxtYoself =& ClassRegistry::init('TxtYoself');
	}

	function endTest() {
		unset($this->TxtYoself);
		ClassRegistry::flush();
	}

}
?>