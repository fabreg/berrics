<?php
/* TrikipediaTrick Test cases generated on: 2011-02-10 08:42:14 : 1297356134*/
App::import('Model', 'TrikipediaTrick');

class TrikipediaTrickTestCase extends CakeTestCase {
	var $fixtures = array('app.trikipedia_trick', 'app.media_file', 'app.user', 'app.media_file_user', 'app.media_file_view', 'app.dailyop', 'app.dailyop_section', 'app.tag', 'app.banner', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click', 'app.banners_tag', 'app.dailyop_sections_tag', 'app.dailyops_tag', 'app.media_files_tag', 'app.tags_trikipedia_trick', 'app.dailyops_media_file');

	function startTest() {
		$this->TrikipediaTrick =& ClassRegistry::init('TrikipediaTrick');
	}

	function endTest() {
		unset($this->TrikipediaTrick);
		ClassRegistry::flush();
	}

}
?>