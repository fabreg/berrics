<?php
class MediahuntTask extends AppModel {
	var $name = 'MediahuntTask';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'MediahuntEvent' => array(
			'className' => 'MediahuntEvent',
			'foreignKey' => 'mediahunt_event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'MediahuntMediaItem' => array(
			'className' => 'MediahuntMediaItem',
			'foreignKey' => 'mediahunt_task_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function beforeSave() {
		
		$data = $this->data;
		
		if(isset($data['MediahuntTask'])) $data = $data['MediahuntTask'];
		
		if(empty($data['id'])) $data['id'] = $this->genId();
		
		$this->data['MediahuntTask'] = $data;
		
		return true;
		
	}
	
	private function genId() {
	
		$id = mt_rand(10000000,99999999);
	
		$chk = $this->find("count",array("conditions"=>array("MediahuntTask.id"=>$id)));
	
		if($chk>0) {
				
			return $this->genId();
				
		}
	
		return $id;
	
	}
	
	
}
