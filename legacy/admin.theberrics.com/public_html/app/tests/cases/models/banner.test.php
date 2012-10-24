<?php
/* Banner Test cases generated on: 2011-02-10 08:42:11 : 1297356131*/
App::import('Model', 'Banner');

class BannerTestCase extends CakeTestCase {
	var $fixtures = array('app.banner', 'app.user', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click', 'app.tag', 'app.banners_tag');

	function startTest() {
		$this->Banner =& ClassRegistry::init('Banner');
	}

	function endTest() {
		unset($this->Banner);
		ClassRegistry::flush();
	}

}
?>