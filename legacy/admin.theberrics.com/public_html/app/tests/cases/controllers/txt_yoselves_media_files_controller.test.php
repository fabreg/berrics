<?php
/* TxtYoselvesMediaFiles Test cases generated on: 2011-02-08 16:59:14 : 1297213154*/
App::import('Controller', 'TxtYoselvesMediaFiles');

class TestTxtYoselvesMediaFilesController extends TxtYoselvesMediaFilesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TxtYoselvesMediaFilesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.txt_yoselves_media_file', 'app.media_file', 'app.user', 'app.user_group', 'app.user_permission', 'app.battle_commander', 'app.battle_commanders_media_file', 'app.tag', 'app.battle_commanders_tag', 'app.dailyop', 'app.dailyop_section', 'app.dailyops_media_file', 'app.dailyops_tag', 'app.media_files_tag', 'app.reda_wednesday', 'app.media_files_reda_wednesday', 'app.reda_wednesdays_tag', 'app.txt_yoself', 'app.tags_txt_yoself', 'app.media_file_user', 'app.media_file_view');

	function startTest() {
		$this->TxtYoselvesMediaFiles =& new TestTxtYoselvesMediaFilesController();
		$this->TxtYoselvesMediaFiles->constructClasses();
	}

	function endTest() {
		unset($this->TxtYoselvesMediaFiles);
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