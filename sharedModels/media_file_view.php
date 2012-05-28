<?php
class MediaFileView extends Model {
	var $name = 'MediaFileView';
	public $useDbConfig = "master";
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'MediaFile' => array(
			'className' => 'MediaFile',
			'foreignKey' => 'media_file_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
