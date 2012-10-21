<?php
/* TxtYoselves Test cases generated on: 2011-02-08 16:59:14 : 1297213154*/
App::import('Controller', 'TxtYoselves');

class TestTxtYoselvesController extends TxtYoselvesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TxtYoselvesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.txt_yoself', 'app.user', 'app.user_group', 'app.user_permission', 'app.battle_commander', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.battle_commanders_media_file', 'app.dailyop', 'app.dailyop_section', 'app.dailyops_media_file', 'app.tag', 'app.battle_commanders_tag', 'app.dailyops_tag', 'app.media_files_tag', 'app.reda_wednesday', 'app.media_files_reda_wednesday', 'app.reda_wednesdays_tag', 'app.tags_txt_yoself', 'app.txt_yoselves_media_file');

	function startTest() {
		$this->TxtYoselves =& new TestTxtYoselvesController();
		$this->TxtYoselves->constructClasses();
	}

	function endTest() {
		unset($this->TxtYoselves);
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