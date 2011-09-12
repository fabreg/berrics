<?php
/* DailyopSectionsTag Fixture generated on: 2011-02-10 08:42:12 : 1297356132 */
class DailyopSectionsTagFixture extends CakeTestFixture {
	var $name = 'DailyopSectionsTag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tag_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'dailyop_section_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'tag_id_idxfk_3' => array('column' => 'tag_id', 'unique' => 0), 'dailyop_section_id_idxfk' => array('column' => 'dailyop_section_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'tag_id' => 1,
			'dailyop_section_id' => 1
		),
	);
}
?>