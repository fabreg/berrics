<?php
/* BannerPlacement Test cases generated on: 2011-02-10 08:42:11 : 1297356131*/
App::import('Model', 'BannerPlacement');

class BannerPlacementTestCase extends CakeTestCase {
	var $fixtures = array('app.banner_placement', 'app.banner_type', 'app.banner_impression', 'app.banner');

	function startTest() {
		$this->BannerPlacement =& ClassRegistry::init('BannerPlacement');
	}

	function endTest() {
		unset($this->BannerPlacement);
		ClassRegistry::flush();
	}

}
?>