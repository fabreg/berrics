<?php
/* Banners Test cases generated on: 2011-02-10 08:42:25 : 1297356145*/
App::import('Controller', 'Banners');

class TestBannersController extends BannersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class BannersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.banner', 'app.user', 'app.user_group', 'app.user_permission', 'app.dailyop', 'app.dailyop_section', 'app.tag', 'app.banners_tag', 'app.dailyop_sections_tag', 'app.dailyops_tag', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.trikipedia_trick', 'app.tags_trikipedia_trick', 'app.dailyops_media_file', 'app.media_files_tag', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click');

	function startTest() {
		$this->Banners =& new TestBannersController();
		$this->Banners->constructClasses();
	}

	function endTest() {
		unset($this->Banners);
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