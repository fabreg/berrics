<?php

App::import("Controller","AdminApp");

class OndemandTitlesController extends AdminAppController {

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
			$this->Session->setFlash(__('Invalid ondemand title', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ondemandTitle', $this->OndemandTitle->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->OndemandTitle->create();
			
			$this->data['Tag'] = $this->OndemandTitle->Tag->parseTags($this->data['OndemandTitle']['tags']);
			$this->fixPublishDate();
			$this->uploadCoverImage();
			$this->uploadBackImage();
			if ($this->OndemandTitle->save($this->data)) {
				$this->Session->setFlash(__('The ondemand title has been saved', true));
				
				$id = $this->OndemandTitle->id;
				
				$this->redirect(array('action' => 'edit',$id));
			} else {
				$this->Session->setFlash(__('The ondemand title could not be saved. Please, try again.', true));
			}
		}
		
		$this->render("edit");
		
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ondemand title', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$this->data['Tag'] = $this->OndemandTitle->Tag->parseTags($this->data['OndemandTitle']['tags']);
			
			$this->uploadCoverImage();
			$this->uploadBackImage();
			$this->fixPublishDate();
			
			if ($this->OndemandTitle->save($this->data)) {
				$this->Session->setFlash(__('The ondemand title has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ondemand title could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->OndemandTitle->find("first",array(
			
				"conditions"=>array("OndemandTitle.id"=>$id)
			
			));
			
			$this->data['OndemandTitle']['pub_date'] = date("Y-m-d",strtotime($this->data['OndemandTitle']['publish_date']));
			$this->data['OndemandTitle']['pub_time'] = date("G:i",strtotime($this->data['OndemandTitle']['publish_date']));
			
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ondemand title', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->OndemandTitle->delete($id)) {
			$this->Session->setFlash(__('Ondemand title deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ondemand title was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	
	private function fixPublishDate() {
		
		if(isset($this->data['OndemandTitle']['pub_date']) && isset($this->data['OndemandTitle']['pub_time'])) {
			
			$this->data['OndemandTitle']['publish_date']  = $this->data['OndemandTitle']['pub_date']." ".$this->data['OndemandTitle']['pub_time'].":00";
			
		} else {
			
			unset($this->data['OndemandTitle']['publish_date']);
			
		}
		
	}
	
	
	
	private function uploadCoverImage() {
		
		$file = $this->data['OndemandTitle']['image_cover'];
		
		if(is_uploaded_file($file['tmp_name'])) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
			
			$fileName = md5(microtime()).".".$ext;
			
			//move file to the tmp directory
			
			move_uploaded_file($file['tmp_name'],TMP."upload/".$fileName);
			
			ImgServer::instance()->upload_ondemand_cover($fileName,TMP."upload/".$fileName);
			
			unlink(TMP."upload/".$fileName);
			
			$this->data['OndemandTitle']['image_cover'] = $fileName;
			
		} else {
			
			unset($this->data['OndemandTitle']['image_cover']);
			
		}
		
	}
	
	private function uploadBackImage() {
		
		
		$file = $this->data['OndemandTitle']['image_back'];
		
		if(is_uploaded_file($file['tmp_name'])) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
			
			$fileName = md5(microtime()).".".$ext;
			
			//move file to the tmp directory
			
			move_uploaded_file($file['tmp_name'],TMP."upload/".$fileName);
			
			ImgServer::instance()->upload_ondemand_cover($fileName,TMP."upload/".$fileName);
			
			unlink(TMP."upload/".$fileName);
			
			$this->data['OndemandTitle']['image_back'] = $fileName;
			
		} else {
			
			
			unset($this->data['OndemandTitle']['image_back']);
			
			
		}
		
		
		
		
	}
	
	
	
}
?>