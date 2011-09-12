<?php
/* DailyopsTag Fixture generated on: 2011-02-10 08:42:12 : 1297356132 */
class DailyopsTagFixture extends CakeTestFixture {
	var $name = 'DailyopsTag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'dailyop_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'tag_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'dailyop_id_idx' => array('column' => 'dailyop_id', 'unique' => 0), 'tag_id_idx' => array('column' => 'tag_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'dailyop_id' => 1,
			'tag_id' => 1
		),
	);
}
?>