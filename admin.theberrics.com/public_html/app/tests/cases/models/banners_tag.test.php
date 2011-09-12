<?php
/* BannersTag Test cases generated on: 2011-02-10 08:42:12 : 1297356132*/
App::import('Model', 'BannersTag');

class BannersTagTestCase extends CakeTestCase {
	var $fixtures = array('app.banners_tag', 'app.banner', 'app.user', 'app.banner_type', 'app.banner_impression', 'app.banner_placement', 'app.banner_click', 'app.tag');

	function startTest() {
		$this->BannersTag =& ClassRegistry::init('BannersTag');
	}

	function endTest() {
		unset($this->BannersTag);
		ClassRegistry::flush();
	}

}
?>