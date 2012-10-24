<?php
/* BattleCommander Test cases generated on: 2011-02-08 23:10:02 : 1297235402*/
App::import('Model', 'BattleCommander');

class BattleCommanderTestCase extends CakeTestCase {
	var $fixtures = array('app.battle_commander', 'app.user', 'app.media_file', 'app.battle_commanders_media_file', 'app.tag', 'app.battle_commanders_tag');

	function startTest() {
		$this->BattleCommander =& ClassRegistry::init('BattleCommander');
	}

	function endTest() {
		unset($this->BattleCommander);
		ClassRegistry::flush();
	}

}
?>