<?php
/* MediaFileView Fixture generated on: 2011-02-10 08:42:13 : 1297356133 */
class MediaFileViewFixture extends CakeTestFixture {
	var $name = 'MediaFileView';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'media_file_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'media_file_id_idxfk_3' => array('column' => 'media_file_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2011-02-10 08:42:13',
			'modified' => '2011-02-10 08:42:13',
			'media_file_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>