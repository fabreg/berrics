<?php
/* MediaFile Test cases generated on: 2011-02-10 08:42:13 : 1297356133*/
App::import('Model', 'MediaFile');

class MediaFileTestCase extends CakeTestCase {
	var $fixtures = array('app.media_file', 'app.user', 'app.media_file_user', 'app.media_file_view', 'app.trikipedia_trick', 'app.dailyop', 'app.dailyop_section', 'app.tag', 'app.dailyop_sections_tag', 'app.dailyops_media_file', 'app.dailyops_tag', 'app.media_files_tag');

	function startTest() {
		$this->MediaFile =& ClassRegistry::init('MediaFile');
	}

	function endTest() {
		unset($this->MediaFile);
		ClassRegistry::flush();
	}

}
?>