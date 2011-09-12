<?php
/* UserGroup Test cases generated on: 2011-02-10 08:42:14 : 1297356134*/
App::import('Model', 'UserGroup');

class UserGroupTestCase extends CakeTestCase {
	var $fixtures = array('app.user_group', 'app.user_permission', 'app.user');

	function startTest() {
		$this->UserGroup =& ClassRegistry::init('UserGroup');
	}

	function endTest() {
		unset($this->UserGroup);
		ClassRegistry::flush();
	}

}
?>