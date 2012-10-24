<?php
/* MediaFilesTag Fixture generated on: 2011-02-10 08:42:13 : 1297356133 */
class MediaFilesTagFixture extends CakeTestFixture {
	var $name = 'MediaFilesTag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'media_file_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tag_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'media_file_id_idxfk_1' => array('column' => 'media_file_id', 'unique' => 0), 'tag_id_idxfk_1' => array('column' => 'tag_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'media_file_id' => 'Lorem ipsum dolor sit amet',
			'tag_id' => 1
		),
	);
}
?>