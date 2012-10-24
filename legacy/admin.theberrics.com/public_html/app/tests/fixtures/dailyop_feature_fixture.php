<?php
/* DailyopFeature Fixture generated on: 2011-02-08 16:58:17 : 1297213097 */
class DailyopFeatureFixture extends CakeTestFixture {
	var $name = 'DailyopFeature';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2011-02-08 16:58:17',
			'modified' => '2011-02-08 16:58:17',
			'name' => 1
		),
	);
}
?>