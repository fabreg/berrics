<?php
/* UserPermission Test cases generated on: 2011-02-10 08:42:14 : 1297356134*/
App::import('Model', 'UserPermission');

class UserPermissionTestCase extends CakeTestCase {
	var $fixtures = array('app.user_permission', 'app.user_group', 'app.user');

	function startTest() {
		$this->UserPermission =& ClassRegistry::init('UserPermission');
	}

	function endTest() {
		unset($this->UserPermission);
		ClassRegistry::flush();
	}

}
?>