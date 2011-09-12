<?php
/* BannerType Test cases generated on: 2011-02-10 08:42:11 : 1297356131*/
App::import('Model', 'BannerType');

class BannerTypeTestCase extends CakeTestCase {
	var $fixtures = array('app.banner_type', 'app.banner_impression', 'app.banner', 'app.banner_placement');

	function startTest() {
		$this->BannerType =& ClassRegistry::init('BannerType');
	}

	function endTest() {
		unset($this->BannerType);
		ClassRegistry::flush();
	}

}
?>