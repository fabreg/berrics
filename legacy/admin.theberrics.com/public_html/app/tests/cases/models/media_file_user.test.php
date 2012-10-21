<?php
/* MediaFileUser Test cases generated on: 2011-02-10 08:42:13 : 1297356133*/
App::import('Model', 'MediaFileUser');

class MediaFileUserTestCase extends CakeTestCase {
	var $fixtures = array('app.media_file_user', 'app.media_file', 'app.user');

	function startTest() {
		$this->MediaFileUser =& ClassRegistry::init('MediaFileUser');
	}

	function endTest() {
		unset($this->MediaFileUser);
		ClassRegistry::flush();
	}

}
?>