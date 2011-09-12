<?php
/* DailyopSectionsTag Test cases generated on: 2011-02-10 08:42:12 : 1297356132*/
App::import('Model', 'DailyopSectionsTag');

class DailyopSectionsTagTestCase extends CakeTestCase {
	var $fixtures = array('app.dailyop_sections_tag', 'app.tag', 'app.dailyop_section', 'app.dailyop');

	function startTest() {
		$this->DailyopSectionsTag =& ClassRegistry::init('DailyopSectionsTag');
	}

	function endTest() {
		unset($this->DailyopSectionsTag);
		ClassRegistry::flush();
	}

}
?>