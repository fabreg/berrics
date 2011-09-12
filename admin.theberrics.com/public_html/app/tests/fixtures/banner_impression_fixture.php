<?php
/* BannerImpression Fixture generated on: 2011-02-10 08:42:11 : 1297356131 */
class BannerImpressionFixture extends CakeTestFixture {
	var $name = 'BannerImpression';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'banner_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'banner_type_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'banner_placement_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'banner_id_idxfk_2' => array('column' => 'banner_id', 'unique' => 0), 'banner_type_id_idxfk_2' => array('column' => 'banner_type_id', 'unique' => 0), 'banner_placement_id_idxfk' => array('column' => 'banner_placement_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2011-02-10 08:42:11',
			'banner_id' => 'Lorem ipsum dolor sit amet',
			'banner_type_id' => 1,
			'banner_placement_id' => 1
		),
	);
}
?>