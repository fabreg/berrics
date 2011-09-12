<?php
/* BannerClick Test cases generated on: 2011-02-10 08:42:11 : 1297356131*/
App::import('Model', 'BannerClick');

class BannerClickTestCase extends CakeTestCase {
	var $fixtures = array('app.banner_click', 'app.banner');

	function startTest() {
		$this->BannerClick =& ClassRegistry::init('BannerClick');
	}

	function endTest() {
		unset($this->BannerClick);
		ClassRegistry::flush();
	}

}
?>