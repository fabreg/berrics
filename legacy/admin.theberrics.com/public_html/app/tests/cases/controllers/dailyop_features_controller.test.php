<?php
/* DailyopFeatures Test cases generated on: 2011-02-08 16:44:48 : 1297212288*/
App::import('Controller', 'DailyopFeatures');

class TestDailyopFeaturesController extends DailyopFeaturesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DailyopFeaturesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyop_feature', 'app.dailyop', 'app.user', 'app.user_group', 'app.user_permission', 'app.battle_commander', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.battle_commanders_media_file', 'app.dailyops_media_file', 'app.reda_wednesday', 'app.media_files_reda_wednesday', 'app.tag', 'app.battle_commanders_tag', 'app.dailyops_tag', 'app.media_files_tag', 'app.reda_wednesdays_tag', 'app.txt_yoself', 'app.tags_txt_yoself', 'app.txt_yoselves_media_file');

	function startTest() {
		$this->DailyopFeatures =& new TestDailyopFeaturesController();
		$this->DailyopFeatures->constructClasses();
	}

	function endTest() {
		unset($this->DailyopFeatures);
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