<?php


App::import("Controller","AdminApp");

class BrandsController extends AdminAppController {

	var $name = 'Brands';
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
	
	}
	
	
	function index() {
		$this->Brand->recursive = 0;
		
		$this->paginate['Brand'] = array(
		
			"order"=>array(
				"Brand.name"=>"ASC"
			)
		
		);
		
		$this->set('brands', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid brand', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('brand', $this->Brand->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			
			
			$this->Brand->create();
			
			$this->data['Tag'] = $this->Brand->Tag->parseTags($this->data['Brand']['tags']);
			
			$this->data['Brand']['established_date'] = $this->data['Brand']['est_date'];
			
			$this->uploadLogo();
			
			if ($this->Brand->save($this->data)) {
				$this->Session->setFlash(__('The brand has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The brand could not be saved. Please, try again.', true));
			}
		} else {
			
			
			$this->data['Brand']['est_date'] = date("Y-m-d");
			
		}
		
		$this->render("edit");
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid brand', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$this->data['Tag'] = $this->Brand->Tag->parseTags($this->data['Brand']['tags']);
			
			$this->data['Brand']['established_date'] = $this->data['Brand']['est_date'];
			
			$this->uploadLogo();
			
			if ($this->Brand->save($this->data)) {
				$this->Session->setFlash(__('The brand has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The brand could not be saved. Please, try again.', true));
			}
		} 
		if (empty($this->data)) {
			$this->data = $this->Brand->read(null, $id);
			
			$this->data['Brand']['est_date']  = date("Y-m-d",strtotime($this->data['Brand']['established_date']));
			
			
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for brand', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Brand->delete($id)) {
			$this->Session->setFlash(__('Brand deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Brand was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	private function uploadLogo() {
		
		if(is_uploaded_file($this->data['Brand']['image_logo']['tmp_name'])) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$file = $this->data['Brand']['image_logo'];
			
			$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
			
			$fileName = time().".".$ext;
			
			//move the file to the tmp dir
			
			move_uploaded_file($file['tmp_name'],TMP."upload/".$fileName);
			
			ImgServer::instance()->upload_brand_logo($fileName,TMP."upload/".$fileName);
			
			$this->data['Brand']['image_logo'] = $fileName;
			
		} else {
			
			unset($this->data['Brand']['image_logo']);
						
		}
		
	}
}
?>