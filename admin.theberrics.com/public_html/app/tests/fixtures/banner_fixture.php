<?php
/* Banner Fixture generated on: 2011-02-10 08:42:11 : 1297356131 */
class BannerFixture extends CakeTestFixture {
	var $name = 'Banner';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'file_name' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'description' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'continent_code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'country_code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'province_code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'banner_type_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'destination_url' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'id' => array('column' => 'id', 'unique' => 1), 'banner_type_id_idxfk_1' => array('column' => 'banner_type_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d541563-73dc-48b1-a4e2-14c87f000001',
			'created' => '2011-02-10 08:42:11',
			'modified' => '2011-02-10 08:42:11',
			'file_name' => 1,
			'user_id' => 1,
			'description' => 1,
			'continent_code' => 'L',
			'country_code' => 'L',
			'province_code' => 'Lorem ipsum dolor sit amet',
			'banner_type_id' => 1,
			'active' => 1,
			'destination_url' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>