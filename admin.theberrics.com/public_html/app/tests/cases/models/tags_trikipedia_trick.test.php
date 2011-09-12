<?php
/* TagsTrikipediaTrick Test cases generated on: 2011-02-10 08:42:13 : 1297356133*/
App::import('Model', 'TagsTrikipediaTrick');

class TagsTrikipediaTrickTestCase extends CakeTestCase {
	var $fixtures = array('app.tags_trikipedia_trick', 'app.trikipedia_trick', 'app.tag', 'app.banner', 'app.user', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click', 'app.banners_tag', 'app.dailyop_section', 'app.dailyop', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.dailyops_media_file', 'app.media_files_tag', 'app.dailyops_tag', 'app.dailyop_sections_tag');

	function startTest() {
		$this->TagsTrikipediaTrick =& ClassRegistry::init('TagsTrikipediaTrick');
	}

	function endTest() {
		unset($this->TagsTrikipediaTrick);
		ClassRegistry::flush();
	}

}
?>