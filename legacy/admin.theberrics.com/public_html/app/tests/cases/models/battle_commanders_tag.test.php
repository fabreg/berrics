<?php
/* BattleCommandersTag Test cases generated on: 2011-02-08 23:10:02 : 1297235402*/
App::import('Model', 'BattleCommandersTag');

class BattleCommandersTagTestCase extends CakeTestCase {
	var $fixtures = array('app.battle_commanders_tag', 'app.battle_commander', 'app.user', 'app.media_file', 'app.battle_commanders_media_file', 'app.tag');

	function startTest() {
		$this->BattleCommandersTag =& ClassRegistry::init('BattleCommandersTag');
	}

	function endTest() {
		unset($this->BattleCommandersTag);
		ClassRegistry::flush();
	}

}
?>