<?php
/* TxtYoself Fixture generated on: 2011-02-08 22:55:23 : 1297234523 */
class TxtYoselfFixture extends CakeTestFixture {
	var $name = 'TxtYoself';

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
			'created' => '2011-02-08 22:55:23',
			'modified' => '2011-02-08 22:55:23',
			'name' => 1,
			'user_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>