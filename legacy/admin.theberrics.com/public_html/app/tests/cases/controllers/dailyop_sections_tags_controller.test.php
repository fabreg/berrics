<?php
/* DailyopSectionsTags Test cases generated on: 2011-02-10 08:42:25 : 1297356145*/
App::import('Controller', 'DailyopSectionsTags');

class TestDailyopSectionsTagsController extends DailyopSectionsTagsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DailyopSectionsTagsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyop_sections_tag', 'app.tag', 'app.banner', 'app.user', 'app.user_group', 'app.user_permission', 'app.dailyop', 'app.dailyop_section', 'app.media_file', 'app.media_file_user', 'app.media_file_view', 'app.trikipedia_trick', 'app.tags_trikipedia_trick', 'app.dailyops_media_file', 'app.media_files_tag', 'app.dailyops_tag', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click', 'app.banners_tag');

	function startTest() {
		$this->DailyopSectionsTags =& new TestDailyopSectionsTagsController();
		$this->DailyopSectionsTags->constructClasses();
	}

	function endTest() {
		unset($this->DailyopSectionsTags);
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