<?php
/* DailyopsTags Test cases generated on: 2011-02-10 08:42:25 : 1297356145*/
App::import('Controller', 'DailyopsTags');

class TestDailyopsTagsController extends DailyopsTagsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DailyopsTagsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyops_tag', 'app.dailyop', 'app.user', 'app.user_group', 'app.user_permission', 'app.banner', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click', 'app.tag', 'app.banners_tag', 'app.dailyop_section', 'app.dailyop_sections_tag', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.trikipedia_trick', 'app.tags_trikipedia_trick', 'app.dailyops_media_file', 'app.media_files_tag');

	function startTest() {
		$this->DailyopsTags =& new TestDailyopsTagsController();
		$this->DailyopsTags->constructClasses();
	}

	function endTest() {
		unset($this->DailyopsTags);
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