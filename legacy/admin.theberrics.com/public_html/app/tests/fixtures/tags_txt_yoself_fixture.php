<?php
/* TagsTxtYoself Fixture generated on: 2011-02-08 22:55:22 : 1297234522 */
class TagsTxtYoselfFixture extends CakeTestFixture {
	var $name = 'TagsTxtYoself';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'txt_yoself_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'tag_id_idx' => array('column' => 'tag_id', 'unique' => 0), 'txt_yoself_id_idx' => array('column' => 'txt_yoself_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'tag_id' => 1,
			'txt_yoself_id' => 1
		),
	);
}
?>