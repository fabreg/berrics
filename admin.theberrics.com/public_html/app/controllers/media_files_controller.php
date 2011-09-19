<?php

App::import("Controller","AdminApp");
App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
class MediaFilesController extends AdminAppController {

	var $name = 'MediaFiles';
	
	public $validImageExt = array("png","jpg","jpeg","gif");
	
	public $validVideoExt = array("mp4");
	
	public $components = array("Getid3");
	
	public function beforeFilter() {
		
		//lets fix the fucked up swfupload session thing
		
		if(in_array($this->params['action'],array("handle_video_file_upload","handle_image_upload","handle_video_still_upload"))) {
			
			$this->Session->id($this->params['pass'][0]);
			$this->Session->start();
			
		}
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	public function search() {
		
		$url = array(
		
			"action"=>"index",
			"search"=>true
		);
		
		
		foreach($this->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
		
		return $this->redirect($url);
		
		
	}
	function index() {
		$this->MediaFile->recursive = 0;
		
		$this->paginate = array(
			"order"=>array("MediaFile.created"=>"DESC"),
			"contain"=>array(
				"Website"
			)
		);
		
		//build searching arguments
		if(isset($this->params['named']['search'])) {
			
			//check for mediaFile name
			if(isset($this->params['named']['MediaFile.name'])) {
				
				$this->paginate['conditions'][]['MediaFile.name LIKE'] = "%".str_replace(" ","%",$this->params['named']['MediaFile.name'])."%"; 
				$this->data['MediaFile']['name'] = $this->data['MediaFile']['named'] = $this->params['named']['MediaFile.name'];
				
			}
			
			//filter the websites
			if(isset($this->params['named']['MediaFile.website_id'])) {
				
				$this->paginate['conditions'][]['MediaFile.website_id'] = $this->params['named']['MediaFile.website_id'];
				$this->data['MediaFile']['website_id'] = $this->params['named']['MediaFile.website_id'];
				
			}
			
			//filter the media type
			if(isset($this->params['named']['MediaFile.media_type'])) {
				
				$this->paginate['conditions'][]['MediaFile.media_type'] = $this->params['named']['MediaFile.media_type'];
				$this->data['MediaFile']['media_type'] = $this->params['named']['MediaFile.media_type'];
				
			}
			
			if(isset($this->params['named']['MediaFile.limelight_not_active']) && $this->params['named']['MediaFile.limelight_not_active'] == 1) {
				
				$this->paginate['conditions']['MediaFile.limelight_active'] = 0;
				$this->paginate['conditions']['MediaFile.limelight_transfer_status'] = 0;
				
				$this->data['MediaFile']['limelight_not_active'] = 1;
				
			}
			
		}
		
		//get some select lists
		
		$websites = $this->MediaFile->Website->find("list");
		
		$this->set(compact("websites"));
		
		$this->set('mediaFiles', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid media file', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('mediaFile', $this->MediaFile->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->MediaFile->create();
			if ($this->MediaFile->save($this->data)) {
				$this->Session->setFlash(__('The media file has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media file could not be saved. Please, try again.', true));
			}
		}
		$users = $this->MediaFile->User->userSelectList();
		$dailyops = $this->MediaFile->Dailyop->find('list');
		$tags = $this->MediaFile->Tag->find('list');
		$this->set(compact('users', 'dailyops', 'tags'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid media file', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$this->data['Tag'] = $this->MediaFile->Tag->parseTags($this->data['MediaFile']['tags']);
			
			if ($this->MediaFile->save($this->data)) {
				
				$this->Session->setFlash(__('The media file has been saved', true));
				
				if(isset($this->data['MediaFile']['postback'])) {
					
					return $this->redirect(base64_decode($this->data['MediaFile']['postback']));
					
				}
				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media file could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->MediaFile->find("first",array("conditions"=>array("MediaFile.id"=>$id),"contain"=>array()));
		}
		$users = $this->MediaFile->User->premiumSelectList();
		
		$this->set(compact('users', 'dailyops', 'tags'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for media file', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->MediaFile->delete($id,false)) {
			$this->Session->setFlash(__('Media file deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Media file was not deleted', true));
		
		$this->render();
		$this->redirect(array('action' => 'index'));
	}
	
	public function ajax_browse() {
		
		$this->MediaFile->recursive = 0;
		
		$this->paginate= array(
		
			"limit"=>100,
			"contain"=>array("User"),
			"order"=>array("MediaFile.created"=>"DESC")
		
		);
		
		$this->set("files",$this->paginate());
		
	}
	
	
	
	/*
	 * IMAGE METHODS
	 * 
	 */
	
	public function add_images($num_images = false) {
					
			$this->Session->write("image_upload_session",time());
		
	}
	
	public function handle_image_upload() {
		
		$file = $_FILES['Filedata'];
		
		mkdir(TMP."upload/".$this->Session->read("image_upload_session"));
		
		$tmpDir = TMP."upload/".$this->Session->read("image_upload_session");
		
		//is this a zip file or an image file?

		$ext = $this->getExt($file['name']);
		
		$out = '<div style="color:green;"><strong>Uploaded Files<strong></div>';
		
		if($ext == "zip") {
			
			$zip = new ZipArchive();
			
			if($zip->open($file['tmp_name']) === true) {
				
				//extract the files to the temp dir
				
				$zip->extractTo(TMP."upload/".$this->Session->read("image_upload_session"));
				
				//lets read through the files and just build a string of the valid images that we have uploaded
				
				$imgs = scandir(TMP."upload/".$this->Session->read("image_upload_session"));
				
				$i = 1;
				
				foreach($imgs as $img) {
					
					
					if(in_array($this->getExt($img),$this->validImageExt)) {
						
						$out .= "<div>{$i} : {$img}</div>";
						$i++;
					}
					
				}
				
				
			}
			
		} else {
			
			//move the image file
			
			move_uploaded_file($file['tmp_name'],$tmpDir."/".$file['name']);
			
			$out .="Image 1: ".$file['name'];
			
		}
		
		//fix EXIF Image fuckups
		
		$this->fixExifImages($tmpDir);
	
		
		$link = "<div style='font-size:150%; font-weight:bold; margin-bottom:10px;'><a href='/media_files/process_image_queue/".$this->Session->read("image_upload_session")."'> >> Process Uploaded Images >> </a></div>";
		
		die($link.$out.$link);
		
	}
	
	
	private function fixExifImages($path = false) {
		/*
		$dir = scandir($path);
		
		foreach($dir as $file) {
			
			if(in_array(strtolower($this->getExt($file)),array("jpg","jpeg"))) {
				
					$exif = exif_read_data($path."/".$file);
					
				//	die(pr($exif));
					$ort = $exif['IFD0']['Orientation'];
					$source = $path."/".$file;
					    switch($ort)
					    {
					        case 1: // nothing
					        break;
					
					        case 2: // horizontal flip
					            $image->flipImage($source,1);
					        break;
					                                
					        case 3: // 180 rotate left
					            $image->rotateImage($source,180);
					        break;
					                    
					        case 4: // vertical flip
					            $image->flipImage($source,2);
					        break;
					                
					        case 5: // vertical flip + 90 rotate right
					            $image->flipImage($source, 2);
					                $image->rotateImage($source, -90);
					        break;
					                
					        case 6: // 90 rotate right
					            $image->rotateImage($source, -90);
					        break;
					                
					        case 7: // horizontal flip + 90 rotate right
					            $image->flipImage($source,1);    
					            $image->rotateImage($source, -90);
					        break;
					                
					        case 8:    // 90 rotate left
					            $image->rotateImage($source, 90);
					        break;
					    }
				
				
			}
			
			
		}
		
		*/
	}
	
	
	
	

	public function process_image_queue($dir_name = false) {
		
		
		//what's the temp dir>?
		$dir = TMP."upload/".$this->Session->read("image_upload_session");
		
		$files = scandir($dir);
		
		$fileData = array();
		
		foreach($files as $file) {
			
			if(in_array($this->getExt($file),$this->validImageExt)) {
				
				$fileData[] = array(
				
					"fullPath"=>$dir."/".$file,
					"fileName"=>$file
				
				);
				
				
			}
			
			
		}
		
		$websites = $this->MediaFile->Website->find("list");
		
		$this->set(compact("websites"));
		
		$this->set("fileData",$fileData);
		
	}
	

	public function ajax_process_image_queue_post() {
		
		if(count($this->data)) {
			
			//save the data
			
			$this->MediaFile->create();
			
			$this->data['Tag'] = $this->MediaFile->Tag->parseTags($this->data['MediaFile']['tags']);
			$this->data['MediaFile']['media_type'] = "img";
			
			$this->MediaFile->save($this->data);
			
			$id = $this->MediaFile->id;
			
			//move the uploaded file to the img.berrics folder
			
			$ext = $this->getExt($this->data['MediaFile']['file']);
			
			$newName = $id.".".$ext;
			
			//rename(,"/home/sites/berrics/img.theberrics.com/public_html/images/".$newName);
			
			$srv = ImgServer::instance();
			
			$srv->upload_image_file($newName,$this->data['MediaFile']['fullPath']);
			
			unlink($this->data['MediaFile']['fullPath']);
			
			//update the media record with the new filename
			
			$this->MediaFile->create();
			
			$this->MediaFile->id = $id;
			
			$this->MediaFile->save(array(
				"file"=>$newName
			));
			
			die("Image Processed Successfully!");
			
		} else {
			
			die("WTF just happened :-O");
			
		}
		
	}
	
	/*
	 * 
	 * 
	 * VIDEO METHODS
	 * 
	 * 
	 */
	
	public function update_limelight_video($id = false) {
		
		
		if(count($this->data)>0) {
			
			//check to see if we have a file upload
			$file = $this->data['MediaFile']['new_file'];
			
			$ext = $this->getExt($file['name']);
			
			if(is_uploaded_file($file['tmp_name']) && in_array(strtolower($ext),array("mp4","flv"))) {
				
				$fileName = $this->data['MediaFile']['id'].".".$ext;
				
				//move to the tmp dir
				move_uploaded_file($file['tmp_name'],TMP.$fileName);
				
				
				//upload the file to limelight
				
				if($this->sendToLimelight($fileName,TMP.$fileName)) {
					
					$this->MediaFile->create();
					$this->MediaFile->id = $this->data['MediaFile']['id'];
					$this->MediaFile->save(array(
						"limelight_transfer_status"=>1,
						"limelight_active"=>1,
						"limelight_file"=>$fileName
					));
					
					$this->Session->setFlash("Media File Uploaded To Limelight Successfully");
					
					$url = "/media_files";
					
					if(isset($this->data['MediaFile']['postback'])) {
						
						$url = base64_decode($this->data['MediaFile']['postback']);
						
						
					}
					
					
					return $this->redirect($url);
					
					
				}
				
				
				
			}
			
			$this->Session->setFlash("Something went wrong, try again");
			
		}
		
		
		$video = $this->MediaFile->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$id
			),
			"contain"=>array()
		));
		
		
		$this->data = $video;
		
	}
	
	
	
	public function add_video() {
		
		$this->Session->write("video_upload_session",time());
		
	}
	
	public function add_video_form () {
		
		$tmpDir = TMP."upload/".$this->Session->read("video_upload_session");
		
		if(count($this->data)>0) {
			
			set_time_limit(0);
			
			$this->data['Tag'] = $this->MediaFile->Tag->parseTags($this->data['Tag']['tags']);
			
			$filePath = $tmpDir."/".$this->data['MediaFile']['file'];
			////get the ID3 Info for the video
			$id3 = $this->videoId3($filePath);
			
			$this->data['MediaFile']['width'] = $id3['width'];
			$this->data['MediaFile']['height'] = $id3['height'];
			
			$ext = $this->getExt($this->data['MediaFile']['file']);
			
			//save the file
			$this->MediaFile->save($this->data);
			
			$media_file_id = $this->MediaFile->id;
			
			$fileName = $media_file_id.".".$ext;
	
			//do we send this file to brightcove?
			if($this->data['MediaFile']['send_to_brightcove'] == 1) {
				
				
				$filePath = $tmpDir."/".$this->data['MediaFile']['file'];
				
				$opt = array(
				
					
					"H264NoProcessing"=>TRUE,
					"preserve_source_rendition"=>TRUE
				
				);
				
				$meta = array(
				
					"name"=>$this->data['MediaFile']['name'],
					"H264NoProcessing"=>TRUE
				
				);
					
				$bc_id = $this->sendVideoToBrightcove($filePath,$meta,$opt);
				
				$this->MediaFile->create();
				
				$this->MediaFile->id = $media_file_id;
				
				$this->MediaFile->save(array(
				
					"brightcove_id"=>$bc_id,
					"media_type"=>"bcove"
				
				));
				
			} else if($this->data['MediaFile']['send_to_limelight'] == 1) {
				
				if($this->sendToLimelight($fileName,$filePath,$this->data['MediaFile']['limelight_mediavault_active'])) {
					
					$this->MediaFile->create();
					
					$this->MediaFile->id = $media_file_id;
					
					$this->MediaFile->save(array(
						"limelight_transfer_status"=>1,
						"limelight_file"=>$fileName,
						"limelight_active"=>1,
						"media_type"=>"bcove"
					));
					
				}
				
				
				
			}
			
			//move the video still to the img.thberrics.com
			if(!empty($this->data['MediaFile']['file_video_still']) && $this->data['MediaFile']['file_video_still']!="true") {
				
				$stillExt = $this->getExt($this->data['MediaFile']['file_video_still']);
			
				//rename($tmpDir."/".$this->data['MediaFile']['file_video_still'],"/home/sites/berrics/img.theberrics.com/public_html/video/stills/".$media_file_id.".".$stillExt);
			
				//upload the image to the image server
				ImgServer::instance()->upload_video_still($media_file_id.".".$stillExt,$tmpDir."/".$this->data['MediaFile']['file_video_still']);
			
			
				$this->MediaFile->id = $media_file_id;
				
				$this->MediaFile->save(array(
				
					"file_video_still"=>$media_file_id.".".$stillExt
				
				));
			}
			return $this->flash("Media File Added Successfully",array("controller"=>"media_files","action"=>"index"));
			
		}
		
		
		$video_file = $this->params['named']['video_file'];
		
		$video_still = $this->params['named']['video_still'];
		
		$this->data['MediaFile']['file'] = $video_file;
		
		$this->data['MediaFile']['file_video_still'] =$video_still;
		
		$this->data['MediaFile']['user_id'] = $this->Auth->user("id");
		
		$this->data['MediaFile']['video_upload_session'] = $this->Session->read("video_upload_session");
		
		
		
	}
	
	private function sendToLimelight($file,$file_path,$secure = false) {
		
		
		$ftp = ftp_connect("berrics.upload.llnw.net");
		
		ftp_login($ftp,"berrics-ht","yteem8");
		
		ftp_pasv($ftp, true);
		
		if($secure) {
			
			ftp_chdir($ftp,"s");
			
		}
		
		$upload = ftp_put($ftp,$file,$file_path,FTP_BINARY);
		ftp_close($ftp);
		if($upload) {
			
			unlink($file_path);
			
			return true;
			
		} else {
			
			return false;
			
		}
		
		
		
	}
	
	private function sendVideoToBrightcove($file,$meta = array(), $options = array()) {
		
		$bc = BCAPI::instance();
		
		try {
			
			$bc_id = $bc->bc->createMedia("video",$file,$meta,$options);
			
		}
		catch(BCMAPIException $e) {
			
			die(print_r($e));
			
		}
		
		return $bc_id;
		
	}
	
	public function handle_video_file_upload() {
		
		$file = $_FILES['Filedata'];
		
		$tmpDir = TMP."upload/".$this->Session->read("video_upload_session");
		
		$ext = $this->getExt($file['name']);
		
		if(!is_dir($tmpDir)) {
			
			mkdir($tmpDir);
			
		}
		
		//check to see if the file format is valid (at least the extension)
		
		if(!in_array($ext,$this->validVideoExt)) {
			
			die("Invalid Video Extension");
			
		}
		
		
		//move the file into the tmpDir
		
		move_uploaded_file($file['tmp_name'],$tmpDir."/".$file['name']);
		
		die("<script></script>Video uploaded successfully ..... ");
		
	}
	
	
	public function handle_video_still_upload() {
		
		
		$file = $_FILES['Filedata'];
		
		$ext = $this->getExt($file['name']);
		
		$tmpDir = TMP."upload/".$this->Session->read("video_upload_session");
		
		if(!is_dir($tmpDir)) {
			
			mkdir($tmpDir);
			
		}
		
		//check to see if the file format is valid (at least the extension)
		
		if(!in_array($ext,$this->validImageExt)) {

			die("image file is an invalid format");
			
		}
		
		//move the image file
		
		move_uploaded_file($file['tmp_name'],$tmpDir."/".$file['name']);
		
		
		die("<script></script>Video Still Uploaded Successfully .......");
		
	}
	
	
	/*
	 * 
	 * UTILITY METHODS
	 * 
	 * 
	 */
	
	private function getExt($path = false) {
		
		$ext = pathinfo($path,PATHINFO_EXTENSION);
		
		return strtolower($ext);
		
	}
	

	private function videoId3($file,$tmp=false) {
		
		
		$info=$this->Getid3->info($file);
		
		$a=array();
		
		$a['playtime_seconds']=$info['playtime_seconds'];
		$a['width']=$info['video']['resolution_x'];
		$a['height']=$info['video']['resolution_y'];
		$a['codec']=$info['video']['codec'];
		$a['file_size_bytes']=$info['filesize'];
		
		return $a;
		
	}
	
	
	public function preview_video($id) {
		
		$m = $this->MediaFile->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$id
			),
			"contain"=>array()
		));
		
		
		$this->set("m",$m['MediaFile']);
		
	}
	
	
	public function attach_media($model,$key,$val,$post_back) {
		
		
		if(count($this->data)) {
				
			$m = $this->data['AttachMedia']['model'];
			
			$this->loadModel($m);
			
			foreach($this->data['AttachMedia']['id'] as $item) {
				
				$this->{$m}->create();
				
				if($m == "BatbMatch") {

					$this->{$m}->id = $this->data['AttachMedia']['val'];
					
					$this->{$m}->save(array(
					
						$this->data['AttachMedia']['key'] => $item
					
					));
						
				} else if($m == "DailyopTextItem") {

					$this->{$m}->id = $this->data['AttachMedia']['val'];
					
					$this->{$m}->save(array(
					
						$this->data['AttachMedia']['key'] => $item
					
					));
					
				} else {
					
					$this->{$m}->save(array(
				
						$this->data['AttachMedia']['key'] => $this->data['AttachMedia']['val'],
						"media_file_id"=>$item
					
					));
					
				}
				
				
				
				
			}
			
			return $this->redirect($this->data['AttachMedia']['post_back']);
			
		}
		
		$this->data['model'] = $model;
		$this->data['key'] = $key;
		$this->data['val'] = $val;
		$this->data['post_back'] = base64_decode($post_back);
		
		
	}
	
	private function flipImage($src,$type) {
		
		  $imgsrc = imagecreatefromjpeg($src);
  		  $width = imagesx($imgsrc);
		  $height = imagesy($imgsrc);
		  $imgdest = imagecreatetruecolor($width, $height);
		  
		  for ($x=0 ; $x<$width ; $x++)
		    {
		      for ($y=0 ; $y<$height ; $y++)
		    {
		      if ($type == MIRROR_HORIZONTAL) imagecopy($imgdest, $imgsrc, $width-$x-1, $y, $x, $y, 1, 1);
		      if ($type == MIRROR_VERTICAL) imagecopy($imgdest, $imgsrc, $x, $height-$y-1, $x, $y, 1, 1);
		      if ($type == MIRROR_BOTH) imagecopy($imgdest, $imgsrc, $width-$x-1, $height-$y-1, $x, $y, 1, 1);
		    }
		    }
		  
		  imagejpeg($imgdest, $src);
		  
		  imagedestroy($imgsrc);
		  imagedestroy($imgdest);
		
	}	
	
	
	public function update_video_still($id) {
		
		
		if(count($this->data)) {
			
			$upload = $this->data['MediaFile']['file_video_still'];
			
			//die(pr($this->data['MediaFile']['file_video_still']));
			
			$ext = $this->getExt($upload['name']);
			
			
			if(!in_array($ext,$this->validImageExt)) {
				
				$this->Session->setFlash("Image file is an invalid format");
				return;
			}
			
			//try and upload the file
			///first let's rename the file to the media file's ID
			$fileName = md5(time().mt_rand(999,9999)).".".$ext;
			
			move_uploaded_file($upload['tmp_name'],TMP."upload/".$fileName);
			
			$srv = ImgServer::instance();
			
			$srv->upload_video_still($fileName,TMP."upload/".$fileName);
			
			unlink(TMP."upload/".$fileName);
			
			//update the video record
			
			$this->MediaFile->id = $this->data['MediaFile']['id'];
			
			$this->MediaFile->save(array(

				"file_video_still"=>$fileName
				
			));
			
			$this->Session->setFlash("Video Still Uploaded Successfully"); 
			
			return $this->redirect(base64_decode($this->data['MediaFile']['postback']));
			
		} else {
					
			$this->data = $this->MediaFile->find("first",array(
			
				"conditions"=>array(
					"MediaFile.id"=>$id
				),
				"contain"=>array()
			
			));
			
		}

		
	}
	
	
	
	public function manual_add() {
		
		if(count($this->data)) {
			
			$this->MediaFile->create();
			
			$this->data['Tag'] = $this->MediaFile->Tag->parseTags($this->data['MediaFile']['tags']);
			
			if($this->MediaFile->save($this->data)) {
				
				$this->flash("Media File Added","/media_files/edit/".$this->MediaFile->id);
				
				 
			} else {
				
				$this->Session->setFlash("SOmething fucked up and we didn't save");
				
			}
			
			
		}
		
		
	}
	
	
	private function retotateImage($src,$angle) {
		
		// Load
		$source = imagecreatefromjpeg($src);
				
		// Rotate
		$rotate = imagerotate($source, $angle, 0);
				
				// Output
		imagejpeg($rotate,$src);
		imagedestroy($rotate);
		
	}
	
	
	public function queue_video_for_report($id = false,$post_back = false) {

		$videos = $this->Session->read("MediaFileReportQueue");
		
		$videos[] = $id;
		
		$this->Session->write("MediaFileReportQueue",$videos);
		
		return $this->redirect(base64_decode($post_back));
		
	}
	
	
	public function remove_queue_video_for_report($id = false,$post_back = false) {
		
		if(!$id) {
			
			$this->Session->delete("MediaFileReportQueue");
			return $this->redirect(base64_decode($post_back));
		}
		
		
		$videos = $this->Session->read("MediaFileReportQueue");
		
		foreach($videos as $k=>$v) { 
			
			if($v == $id) {

				unset($videos[$k]);
				
				return $this->redirect(base64_decode($post_back));
				
			}
			
			
		}
		
		
		
	} 
	
	
	
	
}
?>