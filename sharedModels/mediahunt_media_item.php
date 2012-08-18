<?php
class MediahuntMediaItem extends AppModel {
	var $name = 'MediahuntMediaItem';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'MediahuntTask' => array(
			'className' => 'MediahuntTask',
			'foreignKey' => 'mediahunt_task_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function beforeSave() {
	
		$data = $this->data;
	
		if(isset($data['MediahuntMediaItem'])) $data = $data['MediahuntMediaItem'];
	
		if(empty($this->id)) { 
			
			$data['id'] = $this->genId(); 
			$data['rank'] = 99999;
		}
	
		$this->data['MediahuntMediaItem'] = $data;
	
		return true;
	
	}
	
	private function genId() {
	
		$id = mt_rand(10000000,99999999);
	
		$chk = $this->find("count",array("conditions"=>array("MediahuntMediaItem.id"=>$id)));
	
		if($chk>0) {
	
			return $this->genId();
	
		}
	
		return $id;
	
	}
	
	
}
