<?php

App::import("Controller","LocalApp");

class OndemandTitlesController extends LocalAppController {

	var $name = 'OndemandTitles';
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}

	function index() {
		$this->OndemandTitle->recursive = 0;
		$this->set('ondemandTitles', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ondemand title'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ondemandTitle', $this->OndemandTitle->read(null, $id));
	}

	function add() {
		
		if($this->request->is("post") || $this->request->is("put")) {
			
			$this->request->data['OndemanTitle'] = array(
						"publish_date"=>date("Y-m-d 00:00:00")
					);

			if($this->OndemandTitle->save($this->request->data)) {

				$this->Session->setFlash("On Demand Title Updated Successfully");

				$this->redirect(array(
							"action"=>"edit",
							$this->OndemandTitle->id
						));

			} else {

				$this->Session->setFlash("There was an error while adding the title");

			}
		
		}


	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid ondemand title'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			$this->request->data['Tag'] = $this->OndemandTitle->Tag->parseTags($this->request->data['OndemandTitle']['tags']);
			
			$this->uploadCoverImage();
			$this->uploadBackImage();
			$this->fixPublishDate();
			
			if ($this->OndemandTitle->saveAll($this->request->data)) {
				
				$this->Session->setFlash(__('The ondemand title has been saved'));
				
				//attach media files
				if(isset($this->request->data['AddMediaFile'])) {
					
					$this->redirect(array(
					
						"controller"=>"media_files",
						"action"=>"attach_media",
						"OndemandTitleMediaItem",
						"ondemand_title_id",
						$this->request->data['OndemandTitle']['id'],
						base64_encode($this->request->here)
					
					));
					
				}
				
				
				$this->redirect(array('action' => 'index'));
				
			} else {
				$this->Session->setFlash(__('The ondemand title could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->OndemandTitle->find("first",array(
			
				"conditions"=>array("OndemandTitle.id"=>$id),
				"contain"=>array(
					"Brand",
					"Tag",
					"OndemandTitleMediaItem"=>array("MediaFile","order"=>array("OndemandTitleMediaItem.display_weight"=>"ASC")),
					"User"
				)
			
			));
			
			$this->request->data['OndemandTitle']['pub_date'] = date("Y-m-d",strtotime($this->request->data['OndemandTitle']['publish_date']));
			$this->request->data['OndemandTitle']['pub_time'] = date("G:i",strtotime($this->request->data['OndemandTitle']['publish_date']));
			
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ondemand title'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->OndemandTitle->delete($id)) {
			$this->Session->setFlash(__('Ondemand title deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ondemand title was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	private function fixPublishDate() {
		
		if(isset($this->request->data['OndemandTitle']['pub_date']) && isset($this->request->data['OndemandTitle']['pub_time'])) {
			
			$this->request->data['OndemandTitle']['publish_date']  = $this->request->data['OndemandTitle']['pub_date']." ".$this->request->data['OndemandTitle']['pub_time'].":00";
			
		} else {
			
			unset($this->request->data['OndemandTitle']['publish_date']);
			
		}
		
	}
	
	
	
	private function uploadCoverImage() {
		
		$file = $this->request->data['OndemandTitle']['image_cover'];
		
		if(is_uploaded_file($file['tmp_name'])) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
			
			$fileName = md5(microtime()).".".$ext;
			
			//move file to the tmp directory
			
			move_uploaded_file($file['tmp_name'],TMP."upload/".$fileName);
			
			ImgServer::instance()->upload_ondemand_cover($fileName,TMP."upload/".$fileName);
			
			unlink(TMP."upload/".$fileName);
			
			$this->request->data['OndemandTitle']['image_cover'] = $fileName;
			
		} else {
			
			unset($this->request->data['OndemandTitle']['image_cover']);
			
		}
		
	}
	
	private function uploadBackImage() {
		
		
		$file = $this->request->data['OndemandTitle']['image_back'];
		
		if(is_uploaded_file($file['tmp_name'])) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
			
			$fileName = md5(microtime()).".".$ext;
			
			//move file to the tmp directory
			
			move_uploaded_file($file['tmp_name'],TMP."upload/".$fileName);
			
			ImgServer::instance()->upload_ondemand_cover($fileName,TMP."upload/".$fileName);
			
			unlink(TMP."upload/".$fileName);
			
			$this->request->data['OndemandTitle']['image_back'] = $fileName;
			
		} else {
			
			
			unset($this->request->data['OndemandTitle']['image_back']);
			
			
		}
		
		
		
		
	}
	
	
	
}
?>