<?php
/* TagsTxtYoself Test cases generated on: 2011-02-08 22:55:22 : 1297234522*/
App::import('Model', 'TagsTxtYoself');

class TagsTxtYoselfTestCase extends CakeTestCase {
	var $fixtures = array('app.tags_txt_yoself', 'app.tag', 'app.battle_commander', 'app.user', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.battle_commanders_media_file', 'app.dailyop', 'app.dailyop_section', 'app.dailyops_media_file', 'app.dailyops_tag', 'app.reda_wednesday', 'app.media_files_reda_wednesday', 'app.reda_wednesdays_tag', 'app.media_files_tag', 'app.txt_yoself', 'app.txt_yoselves_media_file', 'app.battle_commanders_tag');

	function startTest() {
		$this->TagsTxtYoself =& ClassRegistry::init('TagsTxtYoself');
	}

	function endTest() {
		unset($this->TagsTxtYoself);
		ClassRegistry::flush();
	}

}
?>