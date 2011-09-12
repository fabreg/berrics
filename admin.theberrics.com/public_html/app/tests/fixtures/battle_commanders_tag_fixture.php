<?php
/* BattleCommandersTag Fixture generated on: 2011-02-08 23:10:02 : 1297235402 */
class BattleCommandersTagFixture extends CakeTestFixture {
	var $name = 'BattleCommandersTag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'battle_commander_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'tag_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'battle_commander_id_idx' => array('column' => 'battle_commander_id', 'unique' => 0), 'tag_id_idx' => array('column' => 'tag_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'battle_commander_id' => 1,
			'tag_id' => 1
		),
	);
}
?>