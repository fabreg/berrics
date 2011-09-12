<?php
/* RedaWednesdaysTag Fixture generated on: 2011-02-08 22:55:22 : 1297234522 */
class RedaWednesdaysTagFixture extends CakeTestFixture {
	var $name = 'RedaWednesdaysTag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'reda_wednesday_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'tag_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'reda_wednesday_id_idx' => array('column' => 'reda_wednesday_id', 'unique' => 0), 'tag_id_idx' => array('column' => 'tag_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'reda_wednesday_id' => 1,
			'tag_id' => 1
		),
	);
}
?>