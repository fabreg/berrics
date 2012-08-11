<?php


App::import("Controller","Dailyops"); 

class LevisController extends DailyopsController {
	
	public $uses = array("MediahuntEvent","MediahuntTask","MediahuntMediaItem");
	
	private $event_id = 2;
	
	public function beforeFilter() {
		
		if((isset($_GET['xid']) && strlen($_GET['xid'])>10) && in_array($this->params['action'],array("handle_upload"))) {
		
			Configure::write('Session.cookie','berricsupload');
			$this->Session->id($_GET['xid']);
			$this->Session->start();
			
		}
		
		parent::beforeFilter(true);
		
		$this->Auth->allow("*");
		
		$this->Auth->deny("tasks","handle_upload","attach_instagram");
		
		$this->Auth->loginAction['action'] = "form";
		
		$this->initPermissions();
		
		$this->theme = "levis-511-contest";

		//die(print_r($this->Auth));
		
		//force hash pushing shit
		if(
				in_array($this->params['action'],array("tasks")) && !$this->RequestHandler->isAjax()
				 	
		) {
			
			$this->redirect("/".$this->params['section']."#levis=".urlencode(base64_encode("/".$_GET['url'])));
			
		}
		
		//catch an image call, set the data
		if($this->params['action'] == "image") {
			
			$this->setImage($this->params['pass'][0]);
			
		}
		
		//catch the view call, set the data
		if($this->params['action'] == "view") {
			
			$this->setPost();
			
		}
		
		$this->set("title_for_layout","Levis & Nike Present - Picture Perfect: A Photographic Scavenger Hunt ");
		
		
	}
	
	private function setPost() {
		
		$post = $this->Dailyop->returnPost(array("DailyopSection.uri"=>$this->params['section'],"Dailyop.uri"=>$this->params['uri']));
		
		$this->set(compact("post"));
		
		$this->params['action'] = "section";
		
	}
	
	private function setImage($id) {
		
		$this->params['action'] = "section";
		
		$image = $this->MediahuntMediaItem->find("first",array(
				
					"conditions"=>array(
								"MediahuntMediaItem.id"=>$id
							),
					"contain"=>array(
						"User",
						"MediahuntTask"		
					)	
				
				));
		
		$this->set(compact("image"));
		
		//set facebook image
		
		$facebook_img = "http://img.theberrics.com/mediahunt-media/".$image['MediahuntMediaItem']['file_name'];
		
		$this->setFacebookMetaImg(false,$facebook_img);
		
		
	}
	
	public function section() {
		
		$contain = array();
		
		if($this->Session->check("Auth.User.id")) {
				
			//get the uses completed tasks
			$contain = array(
						"MediahuntMediaItem"=>array(
							"conditions"=>array(
								"MediahuntMediaItem.user_id"=>$this->Session->read("Auth.User.id")		
							)		
						)
					);	
			
		}
		
		//get all the tasks
		$tasks = $this->MediahuntTask->find("all",array(
					"conditions"=>array(
						"MediahuntTask.active"=>1,
						"MediahuntTask.mediahunt_event_id"=>$this->event_id
					),
					"contain"=>$contain,
					"order"=>array(
						"MediahuntTask.sort_order"=>"ASC"		
					)
				));
		
		
		
		$this->set(compact("tasks"));
		
	}
	
	public function view() {
		
		
		
	}
	
	public function tasks($id = false) {

		//get the task
		$task = $this->MediahuntTask->find("first",array(
					"conditions"=>array(
						"MediahuntTask.id"=>$id		
					),
					"contain"=>array(
									
					)
				));
		
		$mediaItem = $this->MediahuntMediaItem->find("first",array(
					"conditions"=>array(
								"MediahuntMediaItem.mediahunt_task_id"=>$id,
								"MediahuntMediaItem.user_id"=>$this->Auth->user("id")
							),
					"contain"=>array()
				));
		
		$this->set(compact("task","mediaItem"));
		
		$instagram_token = $this->Auth->user("instagram_oauth_token");
		
		if(!empty($instagram_token)) {
			
			$cache_token = "instagram_feed-".md5($instagram_token);
			
			if(($instagram_images = Cache::read($cache_token,"1min")) === false) {
				
				App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
					
				$i = InstagramApi::userInstance($instagram_token);
					
				$instagram_images = json_decode($i->instagram->getUserRecent($this->Auth->user("instagram_account_num")));
					
				Cache::write($cache_token,$instagram_images,"1min");
				
			}
			
			$this->set(compact("instagram_images"));
			
		}
		
	}
	
	private function instagram_image_request($params) {
		
		
		
		
	}
	
	public function handle_submit() {
		
		if(count($this->data)>0) {
			
			$this->data['MediahuntMediaItem']['user_id'] = $this->Auth->user("id");
			
			$this->data['MediahuntMediaItem']['approved'] = 0;
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
				
				$i = ImgServer::instance();
				
				$i->move_tmp_file($this->data['MediahuntMediaItem']['file_name'],"mediahunt-media");
			
			$this->MediahuntMediaItem->create();
				
			$this->MediahuntMediaItem->save($this->data);
			
			//$this->Session->setFlash("Image has been entered successfully");
				
			$this->redirect(array(
						"controller"=>$this->params['section'],
						"action"=>"image",
						$this->MediahuntMediaItem->id
					
					));
			
		}
		
		
	}
	
	public function handle_upload() {
		
		$file = $_FILES['Filedata'];
		
		$file_name = md5(time().mt_rand(999,9999));
		
		$file_ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$new_file = $file_name.".".$file_ext;
		
		$data = array(
					"error"=>true,
					"file_name"=>$new_file
				);
		
		if(move_uploaded_file($file['tmp_name'],TMP.$new_file)) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$i = ImgServer::instance();
			
			$i->upload_tmp_file($new_file,TMP.$new_file);
			
			$data['error'] = false;
			
		} else {
			
			$data['error'] = true;
			
		}
		
		die(json_encode($data));
		
		
	}
	
	public function handle_add_instagram($instagram_id) {
		
		$instagram_token = $this->Auth->user("instagram_id");
		
		App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
			
		$i = InstagramApi::userInstance($instagram_token);
		
		$image = $i->getMedia($instagram_id);
		
		$s_file = $i->images->standard_resolution;
		
		$file = file_get_contents($s_file->url);
		
		file_put_contents(TMP.$s_file,$file);
		
		
		
	}
	
	public function attach_instagram($id = false) {
		
		$data = array(
			"status"=>false		
		);
		
		$instagram_token = $this->Auth->user("instagram_oauth_token");
		
		if(empty($instagram_token) || !$id) die(json_encode($data));
		
		App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
			
		$i = InstagramApi::userInstance($instagram_token);
		
		$image = $i->instagram->getMedia($id);
		
		$image = json_decode($image,true);
		
		//get the image
		
		$f_image = file_get_contents($image['data']['images']['standard_resolution']['url']);
		
		$image_name = md5(time().mt_rand(999,9999)).".jpg";
		
		file_put_contents(TMP.$image_name, $f_image);
		
		App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
		
		$imgs = ImgServer::instance();
		
		$imgs->upload_tmp_file($image_name,TMP.$image_name);
		
		$data['status'] = true;
		$data['image'] = $image;
		$data['file_name'] = $image_name;
		
		die(json_encode($data));
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}