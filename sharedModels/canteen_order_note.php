<?php
class CanteenOrderNote extends AppModel {
	var $name = 'CanteenOrderNote';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentCanteenOrderNote' => array(
			'className' => 'CanteenOrderNote',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CanteenOrder' => array(
			'className' => 'CanteenOrder',
			'foreignKey' => 'canteen_order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'ChildCanteenOrderNote' => array(
			'className' => 'CanteenOrderNote',
			'foreignKey' => 'parent_id',
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
	
	public function addNote($data) {
		
		$this->create();
		
		return $this->save($data);
		
	}
	
	public function addCustomerNote($data = array()) {
		
		$this->create();
		
		$data['CanteenOrderNote']['feedback_required'] = 1;
		
		$data['CanteenOrderNote']['note_type'] = "question";
		
		$data['CanteenOrderNote']['note_status'] = "pending";
		
		$this->save($data);
		
		return $this->id;
		
	}
	
	public function setCustomerNoteValidation() {
		
		$this->validate = array(
			"message"=>array(
				"rule"=>array("minLength",10),
				"message"=>"Your message must be at least 10 characters"
			)
		);
		
	}
	
	public function updateNoteStatus($id = false,$status = "") {
		
		$this->create();
		
		$this->id = $id;
		
		return $this->save(array(
			"note_status"=>$status
		));
		
	}

}
