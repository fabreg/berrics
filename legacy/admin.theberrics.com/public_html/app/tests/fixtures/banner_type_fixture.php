<?php
/* BannerType Fixture generated on: 2011-02-10 08:42:11 : 1297356131 */
class BannerTypeFixture extends CakeTestFixture {
	var $name = 'BannerType';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'width' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'height' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2011-02-10 08:42:11',
			'modified' => '2011-02-10 08:42:11',
			'width' => 1,
			'height' => 1,
			'name' => 1
		),
	);
}
?>