<?php
/* MediaFilesTag Test cases generated on: 2011-02-10 08:42:13 : 1297356133*/
App::import('Model', 'MediaFilesTag');

class MediaFilesTagTestCase extends CakeTestCase {
	var $fixtures = array('app.media_files_tag', 'app.media_file', 'app.user', 'app.media_file_user', 'app.media_file_view', 'app.trikipedia_trick', 'app.dailyop', 'app.dailyop_section', 'app.tag', 'app.dailyop_sections_tag', 'app.dailyops_media_file', 'app.dailyops_tag');

	function startTest() {
		$this->MediaFilesTag =& ClassRegistry::init('MediaFilesTag');
	}

	function endTest() {
		unset($this->MediaFilesTag);
		ClassRegistry::flush();
	}

}
?>