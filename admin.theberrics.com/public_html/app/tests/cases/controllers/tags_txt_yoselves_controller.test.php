<?php
/* TagsTxtYoselves Test cases generated on: 2011-02-08 16:59:14 : 1297213154*/
App::import('Controller', 'TagsTxtYoselves');

class TestTagsTxtYoselvesController extends TagsTxtYoselvesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TagsTxtYoselvesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.tags_txt_yoself', 'app.tag', 'app.battle_commander', 'app.user', 'app.user_group', 'app.user_permission', 'app.dailyop', 'app.dailyop_section', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.battle_commanders_media_file', 'app.dailyops_media_file', 'app.reda_wednesday', 'app.media_files_reda_wednesday', 'app.reda_wednesdays_tag', 'app.media_files_tag', 'app.txt_yoself', 'app.txt_yoselves_media_file', 'app.dailyops_tag', 'app.battle_commanders_tag');

	function startTest() {
		$this->TagsTxtYoselves =& new TestTagsTxtYoselvesController();
		$this->TagsTxtYoselves->constructClasses();
	}

	function endTest() {
		unset($this->TagsTxtYoselves);
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