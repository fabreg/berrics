<?php
/* UserPermission Fixture generated on: 2011-02-10 08:42:14 : 1297356134 */
class UserPermissionFixture extends CakeTestFixture {
	var $name = 'UserPermission';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'app_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'controller' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_group_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'app_name_idx' => array('column' => 'app_name', 'unique' => 0), 'controller_idx' => array('column' => 'controller', 'unique' => 0), 'action_idx' => array('column' => 'action', 'unique' => 0), 'user_group_id_idx' => array('column' => 'user_group_id', 'unique' => 0), 'user_id_idx' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2011-02-10 08:42:14',
			'modified' => '2011-02-10 08:42:14',
			'app_name' => 'Lorem ipsum dolor sit amet',
			'controller' => 'Lorem ipsum dolor sit amet',
			'action' => 'Lorem ipsum dolor sit amet',
			'user_group_id' => 1,
			'user_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>