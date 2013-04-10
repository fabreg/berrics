<?php

App::import("Controller","LocalApp");
App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
class MediaFilesController extends LocalAppController {

	var $name = 'MediaFiles';
	
	public $validImageExt = array("png","jpg","jpeg","gif");
	
	public $validVideoExt = array("mp4");
	
	//public $components = array("Getid3");
	
	public function beforeFilter() {
		
		//lets fix the fucked up swfupload session thing
		
		if(in_array($this->request->params['action'],array("handle_video_file_upload",
													"handle_image_upload",
													"handle_video_still_upload",
													"handle_ajax_media_file_upload",
													"handle_ajax_video_still_upload",
													"handle_ajax_image_upload"))) {
			
			$this->Session->id($this->request->params['pass'][0]);
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
		
		
		foreach($this->request->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				if(empty($vv)) continue;

				$url[$k.".".$kk]=($vv);
				
			}
			
		}
		
		return $this->redirect($url);
		
		
	}
	function index() {
		$this->MediaFile->recursive = 0;
		
		$this->Paginator->settings = array();

		$this->paginate = array(
			"order"=>array("MediaFile.created"=>"DESC"),
			"contain"=>array(
				"Website"
			)
		);
		
		//build searching arguments
		if(isset($this->request->params['named']['search'])) {
			


			//check for mediaFile name
			if(isset($this->request->params['named']['MediaFile.name'])) {
				
				$this->Paginator->settings['conditions'][]['MediaFile.name LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['MediaFile.name'])."%"; 
				$this->request->data['MediaFile']['name'] = $this->request->data['MediaFile']['named'] = $this->request->params['named']['MediaFile.name'];
				
			}
			
			//filter the websites
			if(isset($this->request->params['named']['MediaFile.website_id'])) {
				
				$this->Paginator->settings['conditions'][]['MediaFile.website_id'] = $this->request->params['named']['MediaFile.website_id'];
				$this->request->data['MediaFile']['website_id'] = $this->request->params['named']['MediaFile.website_id'];
				
			}
			
			//filter the media type
			if(isset($this->request->params['named']['MediaFile.media_type'])) {
				
				$this->Paginator->settings['conditions'][]['MediaFile.media_type'] = $this->request->params['named']['MediaFile.media_type'];
				$this->request->data['MediaFile']['media_type'] = $this->request->params['named']['MediaFile.media_type'];
				
			}
			

		}
		
		//get some select lists
		
		$websites = $this->MediaFile->Website->find("list");
		
		$this->set(compact("websites"));
		
		$this->set('mediaFiles', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid media file'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('mediaFile', $this->MediaFile->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->MediaFile->create();
			if ($this->MediaFile->save($this->request->data)) {
				$this->Session->setFlash(__('The media file has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media file could not be saved. Please, try again.'));
			}
		}
		$users = $this->MediaFile->User->userSelectList();
		$dailyops = $this->MediaFile->Dailyop->find('list');
		$tags = $this->MediaFile->Tag->find('list');
		$this->set(compact('users', 'dailyops', 'tags'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid media file'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			$this->request->data['Tag'] = $this->MediaFile->Tag->parseTags($this->request->data['MediaFile']['tags']);
			
			if ($this->MediaFile->save($this->request->data)) {
				
				$this->Session->setFlash(__('The media file has been saved'));
				
				if(isset($this->request->data['MediaFile']['postback'])) {
					
					return $this->redirect(base64_decode($this->request->data['MediaFile']['postback']));
					
				}
				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media file could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->MediaFile->find("first",array("conditions"=>array("MediaFile.id"=>$id),"contain"=>array()));
		}
		$users = $this->MediaFile->User->premiumSelectList();
		
		$this->set(compact('users', 'dailyops', 'tags'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for media file'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->MediaFile->delete($id,false)) {
			$this->Session->setFlash(__('Media file deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Media file was not deleted'));
		
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
		
		if(count($this->request->data)) {
			
			//save the data
			
			$this->MediaFile->create();
			
			$this->request->data['Tag'] = $this->MediaFile->Tag->parseTags($this->request->data['MediaFile']['tags']);
			$this->request->data['MediaFile']['media_type'] = "img";
			
			$this->MediaFile->save($this->request->data);
			
			$id = $this->MediaFile->id;
			
			//move the uploaded file to the img.berrics folder
			
			$ext = $this->getExt($this->request->data['MediaFile']['file']);
			
			$newName = $id.".".$ext;
			
			//rename(,"/home/sites/berrics/img.theberrics.com/public_html/images/".$newName);
			
			$srv = ImgServer::instance();
			
			$srv->upload_image_file($newName,$this->request->data['MediaFile']['fullPath']);
			
			unlink($this->request->data['MediaFile']['fullPath']);
			
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
		
		
		if(count($this->request->data)>0) {
			
			//check to see if we have a file upload
			$file = $this->request->data['MediaFile']['new_file'];
			
			$ext = $this->getExt($file['name']);
			
			if(is_uploaded_file($file['tmp_name']) && in_array(strtolower($ext),array("mp4","flv"))) {
				
				$fileName = $this->request->data['MediaFile']['id'].".".$ext;
				
				//move to the tmp dir
				move_uploaded_file($file['tmp_name'],TMP.$fileName);
				
				
				//upload the file to limelight
				
				if($this->sendToLimelight($fileName,TMP.$fileName)) {
					
					$this->MediaFile->create();
					$this->MediaFile->id = $this->request->data['MediaFile']['id'];
					$this->MediaFile->save(array(
						"limelight_transfer_status"=>1,
						"limelight_active"=>1,
						"limelight_file"=>$fileName
					));
					
					$this->Session->setFlash("Media File Uploaded To Limelight Successfully");
					
					$url = "/media_files";
					
					if(isset($this->request->data['MediaFile']['postback'])) {
						
						$url = base64_decode($this->request->data['MediaFile']['postback']);
						
						
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
		
		
		$this->request->data = $video;
		
	}
	
	
	
	public function add_video() {
		
		$this->Session->write("video_upload_session",time());
		
	}
	
	public function add_video_form () {
		
		$tmpDir = TMP."upload/".$this->Session->read("video_upload_session");
		
		if(count($this->request->data)>0) {
			
			set_time_limit(0);
			
			$this->request->data['Tag'] = $this->MediaFile->Tag->parseTags($this->request->data['Tag']['tags']);
			
			$filePath = $tmpDir."/".$this->request->data['MediaFile']['file'];
			////get the ID3 Info for the video
			//$id3 = $this->videoId3($filePath);
			
			$this->request->data['MediaFile']['width'] = $id3['width'];
			$this->request->data['MediaFile']['height'] = $id3['height'];
			
			$ext = $this->getExt($this->request->data['MediaFile']['file']);
			
			//save the file
			$this->MediaFile->save($this->request->data);
			
			$media_file_id = $this->MediaFile->id;
			
			$fileName = $media_file_id.".".$ext;
	
			//do we send this file to brightcove?
			if($this->request->data['MediaFile']['send_to_brightcove'] == 1) {
				
				
				$filePath = $tmpDir."/".$this->request->data['MediaFile']['file'];
				
				$opt = array(
				
					
					"H264NoProcessing"=>TRUE,
					"preserve_source_rendition"=>TRUE
				
				);
				
				$meta = array(
				
					"name"=>$this->request->data['MediaFile']['name'],
					"H264NoProcessing"=>TRUE
				
				);
					
				$bc_id = $this->sendVideoToBrightcove($filePath,$meta,$opt);
				
				$this->MediaFile->create();
				
				$this->MediaFile->id = $media_file_id;
				
				$this->MediaFile->save(array(
				
					"brightcove_id"=>$bc_id,
					"media_type"=>"bcove"
				
				));
				
			} else if($this->request->data['MediaFile']['send_to_limelight'] == 1) {
				
				if($this->sendToLimelight($fileName,$filePath,$this->request->data['MediaFile']['limelight_mediavault_active'])) {
					
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
			if(!empty($this->request->data['MediaFile']['file_video_still']) && $this->request->data['MediaFile']['file_video_still']!="true") {
				
				$stillExt = $this->getExt($this->request->data['MediaFile']['file_video_still']);
			
				//rename($tmpDir."/".$this->request->data['MediaFile']['file_video_still'],"/home/sites/berrics/img.theberrics.com/public_html/video/stills/".$media_file_id.".".$stillExt);
			
				//upload the image to the image server
				ImgServer::instance()->upload_video_still($media_file_id.".".$stillExt,$tmpDir."/".$this->request->data['MediaFile']['file_video_still']);
			
			
				$this->MediaFile->id = $media_file_id;
				
				$this->MediaFile->save(array(
				
					"file_video_still"=>$media_file_id.".".$stillExt
				
				));
			}
			return $this->flash("Media File Added Successfully",array("controller"=>"media_files","action"=>"index"));
			
		}
		
		
		$video_file = $this->request->params['named']['video_file'];
		
		$video_still = $this->request->params['named']['video_still'];
		
		$this->request->data['MediaFile']['file'] = $video_file;
		
		$this->request->data['MediaFile']['file_video_still'] =$video_still;
		
		$this->request->data['MediaFile']['user_id'] = $this->Auth->user("id");
		
		$this->request->data['MediaFile']['video_upload_session'] = $this->Session->read("video_upload_session");
		
		
		
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
		
		
		if(count($this->request->data)) {
				
			$m = $this->request->data['AttachMedia']['model'];
			
			$this->loadModel($m);
			
			foreach($this->request->data['AttachMedia']['id'] as $item) {
				
				$this->{$m}->create();
				
				if($m == "BatbMatch") {

					$this->{$m}->id = $this->request->data['AttachMedia']['val'];
					
					$this->{$m}->save(array(
					
						$this->request->data['AttachMedia']['key'] => $item
					
					));
						
				} else if($m == "DailyopTextItem") {

					$this->{$m}->id = $this->request->data['AttachMedia']['val'];
					
					$this->{$m}->save(array(
					
						$this->request->data['AttachMedia']['key'] => $item
					
					));
					
				} else if($m == "CanteenDoormat") {

					$this->{$m}->id = $this->request->data['AttachMedia']['val'];
					
					$this->{$m}->save(array(
					
						"media_file_id"=>$item
					
					));
					
				} else {
					
					$this->{$m}->save(array(
				
						$this->request->data['AttachMedia']['key'] => $this->request->data['AttachMedia']['val'],
						"media_file_id"=>$item
					
					));
					
				}
				
				
				
				
			}
			
			return $this->redirect($this->request->data['AttachMedia']['post_back']);
			
		}
		
		$this->request->data['model'] = $model;
		$this->request->data['key'] = $key;
		$this->request->data['val'] = $val;
		$this->request->data['post_back'] = base64_decode($post_back);
		
		
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
		
		
		if(count($this->request->data)) {
			
			$upload = $this->request->data['MediaFile']['file_video_still'];
			
			//die(pr($this->request->data['MediaFile']['file_video_still']));
			
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
			
			$this->MediaFile->id = $this->request->data['MediaFile']['id'];
			
			$this->MediaFile->save(array(

				"file_video_still"=>$fileName
				
			));
			
			$this->Session->setFlash("Video Still Uploaded Successfully"); 
			
			return $this->redirect(base64_decode($this->request->data['MediaFile']['postback']));
			
		} else {
					
			$this->request->data = $this->MediaFile->find("first",array(
			
				"conditions"=>array(
					"MediaFile.id"=>$id
				),
				"contain"=>array()
			
			));
			
		}

		
	}
	
	
	
	public function manual_add() {
		
		if(count($this->request->data)) {
			
			$this->MediaFile->create();
			
			$this->request->data['Tag'] = $this->MediaFile->Tag->parseTags($this->request->data['MediaFile']['tags']);
			
			if($this->MediaFile->save($this->request->data)) {
				
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
		
		 if(!in_array($videos,$id)) {

		 	$videos[] = $id;
		
			$this->Session->write("MediaFileReportQueue",$videos);

		 }

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

	public function clear_report_queue($post_back) {
		
		$post_back = base64_decode($post_back);

		CakeSession::delete('MediaFileReportQueue');

		return $this->redirect($post_back);

	}
	
	
	/*
	 * 
	 * NEW METHODS
	 * 
	 */
	
	public function inspect($id = false) {
		
		if(!$id) throw new NotFoundException();
		
		//check for an update
		if(count($this->request->data)) {
			
			$this->request->data['Tag'] = $this->MediaFile->Tag->parseTags($this->request->data['MediaFile']['tags']);
			
			$this->MediaFile->id = $this->request->data['MediaFile']['id'];
			
			$this->MediaFile->save($this->request->data);
			
			$this->redirect($this->request->here);
			
		} else {
			
			$this->request->data = $this->MediaFile->find("first",array(
				"conditions"=>array("MediaFile.id"=>$id)
			));
			
			if($this->request->data['MediaFile']['media_type'] == "bcove") {

				//get the video tasks
				$this->loadModel('VideoTask');
				$videoTasks = $this->VideoTask->find("all",array(
					"conditions"=>array(
						"VideoTask.model"=>"MediaFile",
						"VideoTask.foreign_key"=>$this->request->data["MediaFile"]['id']
					)
				));

				$this->set(compact("videoTasks"));

			}
			
			
		}
		
	}
	
	public function ajax_media_file_upload($id = false) {
		
		if(!$id) throw new NotFoundException();
		
		$this->request->data = $this->MediaFile->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$id
			)
		));
		
		
	}
	
	public function handle_ajax_media_file_upload() {

		$file = $_FILES['Filedata'];

		$ext = $this->getExt($file['name']);
		
		$file_name = $this->request->params['pass'][1].".".$ext;
		
		$tmp_path = TMP."upload/".$file_name;
		
		if(move_uploaded_file($file['tmp_name'],$tmp_path)) {
			
			App::import("Vendor","LLFTP",array("file"=>"LLFTP.php"));
			
			$ll = new LLFTP();
			
			//transfer file to limelight
			
			$result = $ll->ftpFile($file_name,$tmp_path);
			
			if($result) {
				
				$this->loadModel("MediaFile");
				
				$this->MediaFile->create();
				
				$this->MediaFile->id = $this->request->params['pass'][1];
				
				$udata = array(
					"limelight_file"=>$file_name
				);
				
				$this->MediaFile->save($udata);
				
				$this->Session->setFlash("Video file uploaded to Limelight Successfully");
				
				unlink($tmp_path);
				
				die(json_encode($this->MediaFile->read()));
				
			} else {
				
				die("Failed");
				
			}
			
		}
		
		die(":)");
	}
	
	public function add_blank_file() {
		
		
	
		
		if(count($this->request->data)>0) {
			
			if($this->MediaFile->save($this->request->data)) {
			
					if(isset($this->request->data['MediaFile']['dailyop_id'])) {
						
						//create a dailyop media item
						$this->loadModel("DailyopMediaItem");
						
						$this->DailyopMediaItem->create();
						
						$mi = array(
							"dailyop_id"=>$this->request->data['MediaFile']['dailyop_id'],
							"media_file_id"=>$this->MediaFile->id
						);
						
						$this->DailyopMediaItem->save($mi);
						
					}
					
					//check for a url callback
					
					$this->Session->setFlash("New Media File Added Successfully");
					
					if(isset($this->request->data['MediaFile']['callback'])) {
						
						return $this->redirect(base64_decode($this->request->data['MediaFile']['callback']));
						
					} else {
						
						return $this->redirect("/media_files");
						
					}
					

			}
			
		}
		
		if(isset($this->request->params['named']['dailyop_id'])) {
			
			$this->loadModel("Dailyop");
			
			$post = $this->Dailyop->returnPost(array(
				"Dailyop.id"=>$this->request->params['named']['dailyop_id']
			),$this->isAdmin());
			
			$this->set(compact("post"));
			
		}
		
	}
	
	
	public function ajax_video_still_upload($id= false) {
		
		

	}
	
	public function handle_ajax_video_still_upload() {
		
		$file = $_FILES['Filedata'];

		$ext = $this->getExt($file['name']);
		
		$file_name = md5($this->request->params['pass'][1].time()).".".$ext;
		
		$tmp_path = TMP."upload/".$file_name;
		
		
		if(move_uploaded_file($file['tmp_name'],$tmp_path)) {
			
			App::import('Vendor','ImgServer',array("file"=>"ImgServer.php"));
			
			$img = ImgServer::instance();
			
			$img->upload_video_still($file_name,$tmp_path);
				
			unlink($tmp_path);
			
			$this->loadModel("MediaFile");
			
			$this->MediaFile->create();
			
			$this->MediaFile->id = $this->request->params['pass'][1];
			
			$udata = array(
				"file_video_still"=>$file_name
			);
			
			$this->MediaFile->save($udata);
			
			$this->Session->setFlash("Video Still Updated Successfully");
			
			die(json_encode($this->MediaFile->read()));
				
			
			
		}
		
		die(";)");
		
	}
	
	public function ajax_image_upload($id = false) {
		
		
	}
	
	public function handle_ajax_image_upload() {
		
		$file = $_FILES['Filedata'];

		$ext = $this->getExt($file['name']);
		
		$file_name = md5($this->request->params['pass'][1].time()).".".$ext;
		
		$tmp_path = TMP."upload/".$file_name;
		
		
		if(move_uploaded_file($file['tmp_name'],$tmp_path)) {
			
			App::import('Vendor','ImgServer',array("file"=>"ImgServer.php"));
			
			$img = ImgServer::instance();
			
			$img->upload_image_file($file_name,$tmp_path);
			
			unlink($tmp_path);
			
			$this->loadModel("MediaFile");
			
			$this->MediaFile->create();
			
			$this->MediaFile->id = $this->request->params['pass'][1];
			
			$udata = array(
				"file"=>$file_name
			);
			
			$this->MediaFile->save($udata);
			
			$this->Session->setFlash("Image file uploaded successfully");
			
			die(json_encode($this->MediaFile->read()));
			
		}
		
		die(";-)");
		
	}
	
	public function upload_video_modal() {
		
		if(isset($this->request->query['id'])) {
			
			$video = $this->MediaFile->find("first",array(

				"conditions"=>array(
					"MediaFile.id"=>$this->request->query['id']	
				),
				"contain"=>array()
					
			));
			
			$this->request->data = $video;
		}

		//set the dropdown
		$websites = $this->MediaFile->Website->dropdown();

		$this->set(compact("websites"));
		
	}
	
	public function handle_upload_video_modal() {
		
		if(!is_uploaded_file($this->request->data['MediaFile']['video_file']['tmp_name'])) 
			throw new BadRequestException("Nothing posting in!");
		
		$file = $this->request->data['MediaFile']['video_file'];
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$tmp_name = md5(time()).".".$ext;
		
		if(move_uploaded_file($file['tmp_name'], TMP."uploads/".$tmp_name)) {
			
			$udata = array();
			
			$this->MediaFile->create();
			
			if(isset($this->request->data['MediaFile']['id'])) {
					
				$this->MediaFile->id = $this->request->data['MediaFile']['id'];
					
			} else {
				
				$udata['media_type'] = "bcove";
				$this->MediaFile->save($udata);
				
				
			}
			
			$id = $this->MediaFile->id;
			
			$file_name = $id.".".$ext;

			//run qt fast start
			$full_tmp_path = TMP."uploads/".$tmp_name;
			`qtfaststart $full_tmp_path`;

			App::import("Vendor","LLFTP",array("file"=>"LLFTP.php"));
				
			$ll = new LLFTP();
				


			//transfer file to limelight
				
			$result = $ll->ftpFile($file_name,TMP."uploads/".$tmp_name);
			
			unlink(TMP."uploads/".$tmp_name);
			
			$udata['limelight_file'] = $file_name;
			
			if($this->request->data['MediaFile']['name']) $udata['name'] = $this->request->data['MediaFile']['name'];
			$udata['website_id'] = $this->request->data['MediaFile']['website_id'];
			$this->MediaFile->create();
			$this->MediaFile->id = $id;
			$this->MediaFile->save($udata);
			
			$this->encode_ogv($id);
			//$this->queue_mobile($id);

			$this->Session->setFlash('File uploaded successfully');
			
			die(json_encode($this->MediaFile->read()));
			
		}
		
	}
	
	public function video_image_modal($id = false) {
		
		$video = $this->MediaFile->find("first",array(
					"conditions"=>array(
						"MediaFile.id"=>$id		
					),
					"contain"=>array()
				));
		
		$this->request->data = $video;
		
	}
	
	public function handle_video_image_modal() {

		App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));

		$img = ImgServer::instance();

		$msg = "";

		$file = $this->request->data['MediaFile']['image_file'];
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$tmp_name = md5(time().mt_rand(999,9999)).".".$ext;

		if(
			is_uploaded_file($file['tmp_name']) && 
			move_uploaded_file($file['tmp_name'],TMP."uploads/".$tmp_name)
		) {
			
			$img->upload_video_still($tmp_name,TMP."uploads/".$tmp_name,false);
			
			unlink(TMP."uploads/".$tmp_name);
			
			$this->MediaFile->create();
			
			$this->MediaFile->id = $this->request->data['MediaFile']['id'];
			
			$this->MediaFile->save(array(
						"file_video_still"=>$tmp_name
					));
			
			$msg .= "Primary image updated successfully";
			
			
			
		}

		$file = $this->request->data['MediaFile']['image_file_slim'];
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$tmp_name = md5(time().mt_rand(999,9999)).".".$ext;

		if(
			is_uploaded_file($file['tmp_name']) && 
			move_uploaded_file($file['tmp_name'],TMP."uploads/".$tmp_name)
		) {
			
			$img->upload_video_still_slim($tmp_name,TMP."uploads/".$tmp_name,false);
			
			unlink(TMP."uploads/".$tmp_name);
			
			$this->MediaFile->create();
			
			$this->MediaFile->id = $this->request->data['MediaFile']['id'];
			
			$this->MediaFile->save(array(
						"file_video_still_slim"=>$tmp_name
					));
			
			$msg .= "Slim image updated successfully";
			
			
			
		}


		$file = $this->request->data['MediaFile']['image_file_large'];
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$tmp_name = md5(time().mt_rand(999,9999)).".".$ext;

		if(
			is_uploaded_file($file['tmp_name']) && 
			move_uploaded_file($file['tmp_name'],TMP."uploads/".$tmp_name)
		) {
			
			$img->upload_video_still_large($tmp_name,TMP."uploads/".$tmp_name,false);
			
			unlink(TMP."uploads/".$tmp_name);
			
			$this->MediaFile->create();
			
			$this->MediaFile->id = $this->request->data['MediaFile']['id'];
			
			$this->MediaFile->save(array(
						"file_video_still_large"=>$tmp_name
					));
			
			$msg .= "Large image updated successfully";
			
			
			
		}


		$this->Session->setFlash($msg);
		die(1);
		
	}
	
	public function upload_images_modal() {
		
		
		
	}
	
	public function handle_image_upload_modal() {
		
		$file = $this->request->data['MediaFile']['image_file'];
		
		if(!is_uploaded_file($file['tmp_name']))
			throw new BadRequestException("Nothing posting in!");
		
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$valid = array("jpg","jpeg","gif","png","zip");
		
		if(!in_array($ext,$valid)) throw new BadRequestException("Invalid File Extension");
		
		if(strtoupper($ext)=="ZIP") {
			
			$zip = new ZipArchive;
			
			
			
			if($zip->open($file['tmp_name'])===true) {
				
				
				for($i = 0; $i < $zip->numFiles; $i++) {
					$filename = $zip->getNameIndex($i);
					$t_ext = pathinfo($filename,PATHINFO_EXTENSION);
					
					if(in_array($t_ext,$valid) && !preg_match("/(__MACOSX)/",$filename)) {
						
						$t_name = uniqid($this->Auth->user("id")."-",true).".".$t_ext;
						
						copy("zip://".$file['tmp_name']."#".$filename, TMP."uploads/".$t_name);
						
					}
					
					
				}
				
				$zip->close();
				
			}
			
			
		} else {
			
			$t_name = uniqid($this->Auth->user("id")."-",true).".".$ext;
			
			move_uploaded_file($file['tmp_name'], TMP."uploads/".$t_name);
			
		}
		die();
		$this->redirect(array("action"=>"pending_images"));
		
		
	}
	
	private function user_upload_dir() {

			$udir = TMP."uploads/image-upload-".$this->Auth->user("id");
			
			$old = umask(0);
			if(!is_dir($udir)) mkdir($udir,0777);
			umask($old);
			
			return $udir."/";
		
	}
	
	
	public function pending_images() {
		
		$uid = $this->Auth->user("id");
		
		$scan = scandir(TMP."uploads");
		
		$files = array();
		
		foreach($scan as $v) {
			
			if(preg_match("/^({$uid})/i",$v)) $files[]=$v;
			
		}

		$websites = $this->MediaFile->Website->dropdown();

		$this->set(compact("files","websites"));
		
	}
	
	public function commit_pending_image() {
		
		if($this->request->is("post")) {
			
			if(!empty($this->request->data['MediaFile']['tags'])) {
				
				$this->request->data['Tag'] = $this->MediaFile->Tag->parseTags($this->request->data['MediaFile']['tags']);
				 
			} else {
				
				$this->request->data['Tag'] = array();
				
			}
			
			$ext = pathinfo($this->request->data['MediaFile']['tmp_image'],PATHINFO_EXTENSION);
			
			$file_name = md5(time().mt_rand(999,9999)).".".$ext;
			
			$tmp_file = TMP."uploads/".$this->request->data['MediaFile']['tmp_image'];
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$img = ImgServer::instance();
			
			$img->upload_image_file($file_name,$tmp_file);
			
			$this->request->data['MediaFile']['media_type'] = "img";
			$this->request->data['MediaFile']['file'] = $file_name;
			
			$this->MediaFile->create();
			
			if($this->MediaFile->saveAll($this->request->data)) {
				
				unlink($tmp_file);
				
			}
			
			die(json_encode($this->request->data));
				
		}
		
		die();
		
	}
	
	public function reject_image() {
		
		
		if($this->request->is("post")) {
			
			$img = $this->request->data['tmp_image'];
			
			unlink(TMP."uploads/".$img);
			
		}
		
		die();
		
	}
	
	public function tmp_image($file) {

		$path = TMP."uploads/".$file;
		
		$type = getimagesize($path);
		
		header('Content-type:'.$type['mime']);
		
		readfile($path);
		
		die();
		
	}


	public function run_report($media_file_id = false) {
		
		if(!$media_file_id) throw new NotFoundException("Invalid media file!");


		//get the file
		$file = $this->MediaFile->find('first',array(
				"conditions"=>array(
					"MediaFile.id"=>$media_file_id
				),
				"contain"=>array()
			));
		$this->loadModel('Report');
		
		//the begining
		$start = "2011-06-17";
		//yesterday
		$end = date("Y-m-d",strtotime("-1 Day"));

		//let's run the report
		$this->Report->media_file_report($media_file_id,$file['MediaFile']['name'],$start,$end);

		return $this->redirect(array(
				"controller"=>"reports"
			));

	}
	
	public function queue_ogv($id) {
		
		$this->encode_ogv($id);

		$this->Session->setFlash("Video queued for OGV conversion");

		$cb = base64_decode($this->request->params['named']['cb']);

		$this->redirect($cb);
	}

	public function queue_mobile($id) {
		
		//$this->encode_ogv($id);
		$this->loadModel('VideoTask');
		
		$this->VideoTask->queueTask(array(

			"model"=>"MediaFile",
			"foreign_key"=>$id,
			"task"=>"mobile_mp4",
			"priority"=>1

		));


	}

	private function encode_ogv($id) {
		
		$this->loadModel('VideoTask');
		
		$this->VideoTask->queueTask(array(

			"model"=>"MediaFile",
			"foreign_key"=>$id,
			"task"=>"mp4_to_ogv",
			"priority"=>1

		));


	}
	
	
	
	
	
}
?>