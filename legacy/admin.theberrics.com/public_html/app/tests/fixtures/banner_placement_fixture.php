<?php
/* BannerPlacement Fixture generated on: 2011-02-10 08:42:11 : 1297356131 */
class BannerPlacementFixture extends CakeTestFixture {
	var $name = 'BannerPlacement';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'banner_type_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'banner_type_id_idxfk' => array('column' => 'banner_type_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2011-02-10 08:42:11',
			'modified' => '2011-02-10 08:42:11',
			'name' => 'Lorem ipsum dolor sit amet',
			'banner_type_id' => 1,
			'active' => 1
		),
	);
}
?>