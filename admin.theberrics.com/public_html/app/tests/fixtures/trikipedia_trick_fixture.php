<?php
/* TrikipediaTrick Fixture generated on: 2011-02-10 08:42:14 : 1297356134 */
class TrikipediaTrickFixture extends CakeTestFixture {
	var $name = 'TrikipediaTrick';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'media_file_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'id' => array('column' => 'id', 'unique' => 1), 'media_file_id_idxfk' => array('column' => 'media_file_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d541566-e638-4bd1-9774-14c87f000001',
			'created' => '2011-02-10 08:42:14',
			'modified' => '2011-02-10 08:42:14',
			'name' => 'Lorem ipsum dolor sit amet',
			'media_file_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>