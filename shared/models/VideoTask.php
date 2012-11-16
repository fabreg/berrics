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
		if(!isset($data['priority'])) $data['priority'] = 0;

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

	public function flv_to_mp4($VideoTask) {

		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			
			"task_status"=>"working"
		));

		//import objects
		$MediaFile = ClassRegistry::init("MediaFile");
		App::import("Vendor","LLFTP",array("LLFTP.php"));
		App::import("Vendor","getid3",array("file"=>"getid3/getid3.php"));

		$video = $MediaFile->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$VideoTask['VideoTask']['foreign_key']
			),
			"contain"=>array()
		));

		$llftp = new LLFTP();

		$id3 = new getid3();

		//let's download the video to tmp
		$tmp_file = $MediaFile->downloadVideoToTmp($VideoTask['VideoTask']['foreign_key']);

		//let's get the size of the FLV file

		$flvInfo = $id3->analyze($tmp_file);
		$height = $flvInfo['video']['resolution_y'];
		$width = $flvInfo['video']['resolution_x'];
		$newFileName = str_replace(".flv",".mp4",$video['MediaFile']['limelight_file']);
		$newFilePath = "/home/sites/tmpfiles/".$newFileName;

		if($height&1) $height++;
		if($width&1) $width++;
		
		$cmd = "/usr/local/bin/ffmpeg -y -i {$tmp_file} -vcodec libx264 -vf 'scale={$width}:{$height}' {$newFilePath}";
		SysMsg::add(array(
						"category"=>"FlvToMp4",
						"from"=>"VideoTask",
						"crontab"=>1,
						"title"=>$cmd
				));
		
		$output = `$cmd`;

		$this->getDatasource()->reconnect();
		//ftp the file
		$llftp->ftpFile($newFileName,$newFilePath);

		//update the video file
		$MediaFile->getDatasource()->reconnect();
		$MediaFile->create();
		$MediaFile->id = $video['MediaFile']['id'];
		$MediaFile->save(array(
			"limelight_file"=>$newFileName
		));

		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			"task_status"=>"completed"
		));

	}

	public function mp4_to_ogv($VideoTask) {
		
		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			
			"task_status"=>"working"
		));

		//import objects
		$MediaFile = ClassRegistry::init("MediaFile");
		App::import("Vendor","LLFTP",array("LLFTP.php"));

		$video = $MediaFile->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$VideoTask['VideoTask']['foreign_key']
			),
			"contain"=>array()
		));

		$llftp = new LLFTP();

		//let's download the video to tmp
		$tmp_file = $MediaFile->downloadVideoToTmp($VideoTask['VideoTask']['foreign_key']);

		$newFileName = str_replace(".mp4",".ogv",$video['MediaFile']['limelight_file']);
		$newFilePath = "/home/sites/tmpfiles/".$newFileName;

		$cmd = "/usr/bin/ffmpeg2theora {$tmp_file} -o {$newFilePath}";
		SysMsg::add(array(
						"category"=>"Mp4ToOgv",
						"from"=>"VideoTask",
						"crontab"=>1,
						"title"=>$cmd
				));
		
		$output = `$cmd`;

		$this->getDatasource()->reconnect();
		//ftp the file
		$llftp->ftpFile($newFileName,$newFilePath);

		//update the video file
		$MediaFile->getDatasource()->reconnect();
		$MediaFile->create();
		$MediaFile->id = $video['MediaFile']['id'];
		$MediaFile->save(array(
			"limelight_file_ogv"=>$newFileName
		));

		$this->create();
		$this->id = $VideoTask['VideoTask']['id'];
		$this->save(array(
			"task_status"=>"completed"
		));


	}
	



}
