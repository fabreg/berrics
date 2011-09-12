<?php
/* BannerImpression Test cases generated on: 2011-02-10 08:42:11 : 1297356131*/
App::import('Model', 'BannerImpression');

class BannerImpressionTestCase extends CakeTestCase {
	var $fixtures = array('app.banner_impression', 'app.banner', 'app.banner_type', 'app.banner_placement');

	function startTest() {
		$this->BannerImpression =& ClassRegistry::init('BannerImpression');
	}

	function endTest() {
		unset($this->BannerImpression);
		ClassRegistry::flush();
	}

}
?>