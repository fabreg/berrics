<?php
/* BattleCommandersMediaFile Test cases generated on: 2011-02-08 23:10:02 : 1297235402*/
App::import('Model', 'BattleCommandersMediaFile');

class BattleCommandersMediaFileTestCase extends CakeTestCase {
	var $fixtures = array('app.battle_commanders_media_file', 'app.media_file', 'app.battle_commander', 'app.user', 'app.tag', 'app.battle_commanders_tag');

	function startTest() {
		$this->BattleCommandersMediaFile =& ClassRegistry::init('BattleCommandersMediaFile');
	}

	function endTest() {
		unset($this->BattleCommandersMediaFile);
		ClassRegistry::flush();
	}

}
?>