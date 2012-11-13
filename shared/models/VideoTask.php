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

	public function youtube_upload($VideoTask) {
		
		//mark the task as working
		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			"task_status"=>"working"
		));

		//import and create objects
		$Dailyop = ClassRegistry::init("Dailyop");
		App::import("Vendor","YoutubeApi",array("file"=>"YoutubeApi.php"));
		$yt = new YoutubeApi();

		$post = $Dailyop->returnPost(array(
			"Dailyop.id"=>$VideoTask['VideoTask']['foreign_key']
		),1,1);

		//let's get the video that needs to be uploaded
		// it will be the first mediaFile object marked as a bcove media type
		$videoFile = Set::extract("/DailyopMediaItem/MediaFile[media_type=bcove]",$post);

		if($videoFile[0]['MediaFile']['id']) {

			$videoFile = $videoFile[0];

		}

		$yt->uploadVideo($post,$videoFile);

		//mark the task as not working
		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			"task_status"=>"completed"
		));
	}

	public function youtube_make_private($VideoTask) {
		
		//mark the task as working
		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			"task_status"=>"working"
		));

		$ShareParam = ClassRegistry::init("DailyopsShareParameter");
		App::import("Vendor","YoutubeApi",array("file"=>"YoutubeApi.php"));
		$yt = new YoutubeApi();

		//get the data
		$param = $ShareParam->findById($VideoTask['VideoTask']['foreign_key']);

		$data = unserialize($param['DailyopsShareParameter']['parameters']);

		$yt->updatePrivacy($param['DailyopsShareParameter']['foreign_key'],true,$data);

		//mark the task as completed
		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			"task_status"=>"completed"
		));


	}

	public function youtube_make_public($VideoTask) {
		
		//mark the task as working
		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			"task_status"=>"working"
		));

		$ShareParam = ClassRegistry::init("DailyopsShareParameter");
		App::import("Vendor","YoutubeApi",array("file"=>"YoutubeApi.php"));
		$yt = new YoutubeApi();

		//get the data
		$param = $ShareParam->findById($VideoTask['VideoTask']['foreign_key']);

		$data = unserialize($param['DailyopsShareParameter']['parameters']);
		
		$yt->updatePrivacy($param['DailyopsShareParameter']['foreign_key'],false,$data);

		//mark the task as completed
		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			"task_status"=>"completed"
		));


	}
	



}
