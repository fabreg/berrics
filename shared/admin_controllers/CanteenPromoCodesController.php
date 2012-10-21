<?php

App::import("Controller","LocalApp");

class CanteenPromoCodesController extends LocalAppController {

	var $name = 'CanteenPromoCodes';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		$this->CanteenPromoCode->recursive = 0;
		$this->set('canteenPromoCodes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid canteen promo code'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('canteenPromoCode', $this->CanteenPromoCode->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->CanteenPromoCode->create();
			
			$this->handleIconUpload();
			
			if ($this->CanteenPromoCode->save($this->request->data)) {
				$this->Session->setFlash(__('The canteen promo code has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen promo code could not be saved. Please, try again.'));
			}
		}
	}
	
	private function handleIconUpload() {
		
		$file = $this->request->data['CanteenPromoCode']['icon_file'];
	
		if(!is_uploaded_file($file['tmp_name'])) {
			
			unset($this->request->data['CanteenPromoCode']['icon_file']);
			
			return;
			
		}
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$fileName = md5(microtime().mt_rand(99,999)).".".$ext;
		
		if(move_uploaded_file($file['tmp_name'],TMP.$fileName)) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			ImgServer::instance()->upload_canteen_promo_icon($fileName,TMP.$fileName);
			
			$this->request->data['CanteenPromoCode']['icon_file'] = $fileName;
			
			unlink(TMP.$fileName);
			
		} else {
			
			unset($this->request->data['CanteenPromoCode']['icon_file']);
			
		}

	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid canteen promo code'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			$this->handleIconUpload();
			
			if ($this->CanteenPromoCode->save($this->request->data)) {
				$this->Session->setFlash(__('The canteen promo code has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen promo code could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CanteenPromoCode->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for canteen promo code'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CanteenPromoCode->delete($id)) {
			$this->Session->setFlash(__('Canteen promo code deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Canteen promo code was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
