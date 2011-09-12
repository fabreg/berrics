<?php
/* MediaFilesRedaWednesday Fixture generated on: 2011-02-08 22:55:21 : 1297234521 */
class MediaFilesRedaWednesdayFixture extends CakeTestFixture {
	var $name = 'MediaFilesRedaWednesday';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'media_file_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reda_wednesday_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'media_file_id_idx' => array('column' => 'media_file_id', 'unique' => 0), 'reda_wednesday_id_idx' => array('column' => 'reda_wednesday_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'media_file_id' => 'Lorem ipsum dolor sit amet',
			'reda_wednesday_id' => 1
		),
	);
}
?>