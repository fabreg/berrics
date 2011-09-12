<?php
/* UserPermissions Test cases generated on: 2011-02-10 08:42:25 : 1297356145*/
App::import('Controller', 'UserPermissions');

class TestUserPermissionsController extends UserPermissionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class UserPermissionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.user_permission', 'app.user_group', 'app.user', 'app.banner', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click', 'app.tag', 'app.banners_tag', 'app.dailyop_section', 'app.dailyop', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.trikipedia_trick', 'app.tags_trikipedia_trick', 'app.dailyops_media_file', 'app.media_files_tag', 'app.dailyops_tag', 'app.dailyop_sections_tag');

	function startTest() {
		$this->UserPermissions =& new TestUserPermissionsController();
		$this->UserPermissions->constructClasses();
	}

	function endTest() {
		unset($this->UserPermissions);
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