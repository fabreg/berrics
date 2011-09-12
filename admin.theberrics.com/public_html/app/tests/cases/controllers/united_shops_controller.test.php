<?php
/* UnitedShops Test cases generated on: 2011-02-10 08:42:25 : 1297356145*/
App::import('Controller', 'UnitedShops');

class TestUnitedShopsController extends UnitedShopsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class UnitedShopsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.united_shop');

	function startTest() {
		$this->UnitedShops =& new TestUnitedShopsController();
		$this->UnitedShops->constructClasses();
	}

	function endTest() {
		unset($this->UnitedShops);
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