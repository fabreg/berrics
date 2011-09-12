<?php
/* MediaFiles Test cases generated on: 2011-02-10 08:42:25 : 1297356145*/
App::import('Controller', 'MediaFiles');

class TestMediaFilesController extends MediaFilesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class MediaFilesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.media_file', 'app.user', 'app.user_group', 'app.user_permission', 'app.banner', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click', 'app.tag', 'app.banners_tag', 'app.dailyop_section', 'app.dailyop', 'app.dailyops_media_file', 'app.dailyops_tag', 'app.dailyop_sections_tag', 'app.media_files_tag', 'app.trikipedia_trick', 'app.tags_trikipedia_trick', 'app.media_file_user', 'app.media_file_view');

	function startTest() {
		$this->MediaFiles =& new TestMediaFilesController();
		$this->MediaFiles->constructClasses();
	}

	function endTest() {
		unset($this->MediaFiles);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>