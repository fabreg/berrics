<?php
/* RedaWednesdays Test cases generated on: 2011-02-08 16:59:13 : 1297213153*/
App::import('Controller', 'RedaWednesdays');

class TestRedaWednesdaysController extends RedaWednesdaysController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RedaWednesdaysControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.reda_wednesday', 'app.user', 'app.user_group', 'app.user_permission', 'app.battle_commander', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.battle_commanders_media_file', 'app.dailyop', 'app.dailyop_section', 'app.dailyops_media_file', 'app.tag', 'app.battle_commanders_tag', 'app.dailyops_tag', 'app.media_files_tag', 'app.reda_wednesdays_tag', 'app.txt_yoself', 'app.tags_txt_yoself', 'app.txt_yoselves_media_file', 'app.media_files_reda_wednesday');

	function startTest() {
		$this->RedaWednesdays =& new TestRedaWednesdaysController();
		$this->RedaWednesdays->constructClasses();
	}

	function endTest() {
		unset($this->RedaWednesdays);
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