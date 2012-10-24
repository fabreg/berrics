<?php
/* BattleCommander Fixture generated on: 2011-02-08 23:10:02 : 1297235402 */
class BattleCommanderFixture extends CakeTestFixture {
	var $name = 'BattleCommander';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id_idx' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2011-02-08 23:10:02',
			'modified' => '2011-02-08 23:10:02',
			'name' => 1,
			'user_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>