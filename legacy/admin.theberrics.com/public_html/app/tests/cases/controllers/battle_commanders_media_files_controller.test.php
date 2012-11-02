<?php
/* BattleCommandersMediaFiles Test cases generated on: 2011-02-08 23:10:10 : 1297235410*/
App::import('Controller', 'BattleCommandersMediaFiles');

class TestBattleCommandersMediaFilesController extends BattleCommandersMediaFilesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class BattleCommandersMediaFilesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.battle_commanders_media_file', 'app.media_file', 'app.user', 'app.user_group', 'app.user_permission', 'app.banner', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.tag', 'app.banners_tag', 'app.battle_commander', 'app.battle_commanders_tag', 'app.dailyop', 'app.dailyop_section', 'app.dailyops_media_file', 'app.dailyops_tag', 'app.media_files_tag', 'app.trikipedia_trick', 'app.tags_trikipedia_trick', 'app.media_file_user', 'app.media_file_view');

	function startTest() {
		$this->BattleCommandersMediaFiles =& new TestBattleCommandersMediaFilesController();
		$this->BattleCommandersMediaFiles->constructClasses();
	}

	function endTest() {
		unset($this->BattleCommandersMediaFiles);
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