<?php
class MediaFileView extends AppModel {
	var $name = 'MediaFileView';
	
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
	
	
	public function getTopViews($limit = 15) {
		
		
		$data = $this->query(
					"select count(MediaFileView.id) as `total`,MediaFile.id,MediaFile.name,MediaFileView.media_file_id
					FROM media_file_views `MediaFileView`
					LEFT JOIN media_files `MediaFile` ON (MediaFile.id = MediaFileView.media_file_id)
				GROUP BY MediaFileView.media_file_id	
				ORDER BY total DESC
					
					LIMIT {$limit}"
				);
		
		return $data;
		
	}

	public function getTotalViews() {
		
		$views = $this->find('count');

		return $views;

	}
	
}
