<?php
/* MediaFileView Test cases generated on: 2011-02-10 08:42:13 : 1297356133*/
App::import('Model', 'MediaFileView');

class MediaFileViewTestCase extends CakeTestCase {
	var $fixtures = array('app.media_file_view', 'app.media_file');

	function startTest() {
		$this->MediaFileView =& ClassRegistry::init('MediaFileView');
	}

	function endTest() {
		unset($this->MediaFileView);
		ClassRegistry::flush();
	}

}
?>