<?php
App::uses('AppModel', 'Model');
/**
 * VideoTask Model
 *
 */
class VideoTask extends AppModel {

	public $belongsTo = array(
		"User"
	);

	public function queueTask($data) {
		
		$this->create();

		if(!isset($data['task_status'])) $data['task_status'] = "pending";
		if(!isset($data['user_id'])) $data['user_id'] = CakeSession::read("Auth.User.id");

		$this->save($data);

		return $this->id;

	}

	public function cancelTask($id) {

		$task = $this->find("first",array(

			"conditions"=>array(
				"VideoTask.id"=>$id
			)

		));

		if(!$task['VideoTask']['id']) throw new Exception("Video Task Not Found");

		if($task['VideoTask']['working']) throw new Exception("Video Taks Is Currently Working and cannot be modified");


	}
	



}
