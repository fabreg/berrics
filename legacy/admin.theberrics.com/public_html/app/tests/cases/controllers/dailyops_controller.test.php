<?php
/* Dailyops Test cases generated on: 2011-02-10 08:42:25 : 1297356145*/
App::import('Controller', 'Dailyops');

class TestDailyopsController extends DailyopsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DailyopsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyop', 'app.user', 'app.user_group', 'app.user_permission', 'app.banner', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click', 'app.tag', 'app.banners_tag', 'app.dailyop_section', 'app.dailyop_sections_tag', 'app.dailyops_tag', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.trikipedia_trick', 'app.tags_trikipedia_trick', 'app.dailyops_media_file', 'app.media_files_tag');

	function startTest() {
		$this->Dailyops =& new TestDailyopsController();
		$this->Dailyops->constructClasses();
	}

	function endTest() {
		unset($this->Dailyops);
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