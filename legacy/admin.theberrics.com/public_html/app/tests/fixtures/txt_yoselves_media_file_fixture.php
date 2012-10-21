<?php
/* TxtYoselvesMediaFile Fixture generated on: 2011-02-08 22:55:23 : 1297234523 */
class TxtYoselvesMediaFileFixture extends CakeTestFixture {
	var $name = 'TxtYoselvesMediaFile';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'media_file_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'txt_yoself_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'media_file_id_idx' => array('column' => 'media_file_id', 'unique' => 0), 'txt_yoself_id_idx' => array('column' => 'txt_yoself_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'media_file_id' => 'Lorem ipsum dolor sit amet',
			'txt_yoself_id' => 1
		),
	);
}
?>