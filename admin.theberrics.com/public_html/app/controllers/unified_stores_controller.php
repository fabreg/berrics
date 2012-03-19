<?php


App::import("Controller","LocalApp");
App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));

class UnifiedStoresController extends LocalAppController {

	var $name = 'UnifiedStores';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		
		$this->UnifiedStore->recursive = 0;
		$this->set('unifiedStores', $this->paginate());
		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid unified store', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('unifiedStore', $this->UnifiedStore->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->UnifiedStore->create();
			if ($this->UnifiedStore->save($this->data)) {
				$this->Session->setFlash(__('The unified store has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The unified store could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid unified store', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			
			$this->uploadImageLogo();
			
			
			if ($this->UnifiedStore->save($this->data)) {
				$this->Session->setFlash(__('The unified store has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The unified store could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UnifiedStore->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for unified store', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UnifiedStore->delete($id)) {
			$this->Session->setFlash(__('Unified store deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Unified store was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	private function uploadImageLogo() {
		
		if(is_uploaded_file($this->data['UnifiedStore']['image_logo']['tmp_name'])) {
			
			$ext = pathInfo($this->data['UnifiedStore']['image_logo']['name'],PATHINFO_EXTENSION);
			
			$fileName = md5(time()).".".$ext;
			
			move_uploaded_file($this->data['UnifiedStore']['image_logo']['tmp_name'],TMP."upload/".$fileName);
			
			ImgServer::instance()->upload_unified_logo($fileName,TMP."upload/".$fileName);
			
			unlink(TMP."upload/".$fileName);
			
			$this->data['UnifiedStore']['image_logo'] = $fileName;
			
		}
		
	}
}