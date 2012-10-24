<?php
/* UnitedShop Test cases generated on: 2011-02-10 08:42:14 : 1297356134*/
App::import('Model', 'UnitedShop');

class UnitedShopTestCase extends CakeTestCase {
	var $fixtures = array('app.united_shop');

	function startTest() {
		$this->UnitedShop =& ClassRegistry::init('UnitedShop');
	}

	function endTest() {
		unset($this->UnitedShop);
		ClassRegistry::flush();
	}

}
?>