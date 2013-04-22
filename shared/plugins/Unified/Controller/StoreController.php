<?php

App::uses("UnifiedAppController","Unified.Controller");

class StoreController extends UnifiedAppController {

	public $uses = array("UnifiedStore");

	public $helpers = array("Unified.Unified");

	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->deny();

		$this->initPermissions();

	}
public function search() {

		if($this->request->is("post") || $this->request->is("put")) {
			
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

	}

	function index() {
		
		$this->UnifiedStore->recursive = 0;


		$this->Paginator->settings = array();

		$this->Paginator->settings['limit'] = 50;

		if(isset($this->request->params['named']['search'])) {


			if (isset($this->request->params['named']['UnifiedStore.shop_name'])) {
				
				$this->Paginator->settings['conditions']['UnifiedStore.shop_name LIKE'] = 
					"%".str_replace(" ","%",urldecode($this->request->params['named']['UnifiedStore.shop_name']))."%";

				$this->request->data['UnifiedStore']['shop_name'] = ($this->request->params['named']['UnifiedStore.shop_name']);

			}

		}

		$this->set('unifiedStores', $this->paginate());
		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid unified store'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('unifiedStore', $this->UnifiedStore->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->UnifiedStore->create();
			if ($this->UnifiedStore->save($this->request->data)) {
				$this->Session->setFlash(__('The unified store has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The unified store could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {

		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid unified store'));
			$this->redirect(array('action' => 'index'));
		}
		
		if($this->request->is("post") || $this->request->is("put")) {


			//set validation
			$this->UnifiedStore->setValidation($this->request->data);
			
			if($this->UnifiedStore->saveAssociated($this->request->data)) {

					foreach($this->request->data['submit-btn'] as $k=>$v) {

						switch($k) {

							case "delete-employee":
								$this->UnifiedStore->UnifiedStoreEmployee->delete($this->request->data['submit-btn']['delete-employee']);
							break;
							case 'delete-store-hour-label':
								$this->UnifiedStore->UnifiedStoreHour->delete($this->request->data['submit-btn']['delete-store-hour-label']);
							break;
							case 'remove-brand':
								$this->UnifiedStore->UnifiedStoreBrand->delete($this->request->data['submit-btn']['remove-brand']);
							break;
							default:
							break;

						}

					}

				$this->Session->setFlash("Store updated successfuly");

				$this->redirect($this->here."?tab=".$this->request->data['tab']);

			} else {



			}
		
		}

		if (empty($this->request->data)) {
			$this->request->data = $this->UnifiedStore->returnAdminStore($id);
		}
	}

	public function add_new_employee($store_id = false) {
		
		$store = $this->UnifiedStore->returnAdminStore($store_id);

		$this->UnifiedStore->UnifiedStoreEmployee->setEmployeeValidation($this->request->data);

		if($this->request->is("post") || $this->request->is("put")) {
		
			if($this->UnifiedStore->UnifiedStoreEmployee->validates()) {

				$this->UnifiedStore->UnifiedStoreEmployee->addNew($this->request->data);

				die("<script> $('#UnifiedStoreForm').trigger('submit'); </script>");

			} else {

				

			}

			
		
		} else {

			$this->request->data = $store;

		}

		
		$this->view = "/Elements/unified/admin/employee-edit";
		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for unified store'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UnifiedStore->delete($id)) {
			$this->Session->setFlash(__('Unified store deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Unified store was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	private function uploadImageLogo() {
		
		if(is_uploaded_file($this->request->data['UnifiedStore']['image_logo']['tmp_name'])) {
			
			$ext = pathInfo($this->request->data['UnifiedStore']['image_logo']['name'],PATHINFO_EXTENSION);
			
			$fileName = md5(time()).".".$ext;
			
			move_uploaded_file($this->request->data['UnifiedStore']['image_logo']['tmp_name'],TMP."upload/".$fileName);
			
			ImgServer::instance()->upload_unified_logo($fileName,TMP."upload/".$fileName);
			
			unlink(TMP."upload/".$fileName);
			
			$this->request->data['UnifiedStore']['image_logo'] = $fileName;
			
		}
		
	}

}