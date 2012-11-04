<?php


App::import("Controller","LocalApp");

class BrandsController extends LocalAppController {

	var $name = 'Brands';
	
	public function beforeFilter() {
		
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

				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
		
		return $this->redirect($url);
		
		
	}
	
	function index() {
		
		$this->Brand->recursive = 0;
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['Brand'] = array(
		
			"order"=>array(
				"Brand.name"=>"ASC"
			)
		
		);
		
		if(isset($this->request->params['named']['search'])) {
			
			//Brand name
			if(isset($this->request->params['named']['Brand.name'])) {
				
				$this->Paginator->settings['Brand']['conditions']['Brand.name LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['Brand.name'])."%";
				
				$this->request->data['Brand']['name'] = $this->request->params['named']['Brand.name'];
				
			}
			
			
		}
		
		
		$this->set('brands', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid brand'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('brand', $this->Brand->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			
			
			$this->Brand->create();
			
			$this->request->data['Tag'] = $this->Brand->Tag->parseTags($this->request->data['Brand']['tags']);
			
			$this->request->data['Brand']['established_date'] = $this->request->data['Brand']['est_date'];
			
			$this->uploadLogo();
			
			
			if ($this->Brand->save($this->request->data)) {
				$this->Session->setFlash(__('The brand has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The brand could not be saved. Please, try again.'));
			}
		} else {
			
			
			$this->request->data['Brand']['est_date'] = date("Y-m-d");
			
		}
		
		$this->render("edit");
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid brand'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			$this->request->data['Tag'] = $this->Brand->Tag->parseTags($this->request->data['Brand']['tags']);
			
			$this->request->data['Brand']['established_date'] = $this->request->data['Brand']['est_date'];
			
			$this->uploadLogo();
		
			if(isset($this->request->data['CanteenLogo'])) {
				
				$this->handleCanteenLogoUpload();
				
			}
			
			if ($this->Brand->save($this->request->data)) {
				$this->Session->setFlash(__('The brand has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The brand could not be saved. Please, try again.'));
			}
		} 
		if (empty($this->request->data)) {
			$this->request->data = $this->Brand->read(null, $id);
			
			$this->request->data['Brand']['est_date']  = date("Y-m-d",strtotime($this->request->data['Brand']['established_date']));
			
			
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for brand'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Brand->delete($id)) {
			$this->Session->setFlash(__('Brand deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Brand was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	private function uploadLogo() {
		
		if(is_uploaded_file($this->request->data['Brand']['image_logo']['tmp_name'])) {
			
			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
			
			$file = $this->request->data['Brand']['image_logo'];
			
			$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
			
			$fileName = time().".".$ext;
			
			//move the file to the tmp dir
			
			move_uploaded_file($file['tmp_name'],TMP."upload/".$fileName);
			
			ImgServer::instance()->upload_brand_logo($fileName,TMP."upload/".$fileName);
			
			$this->request->data['Brand']['image_logo'] = $fileName;
			
		} else {
			
			unset($this->request->data['Brand']['image_logo']);
						
		}
		
	}
	
	public function handleCanteenLogoUpload() {
		
		$file = $this->request->data['Brand']['new_canteen_logo'];
		
		if(!is_uploaded_file($file['tmp_name'])) return false;
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$fileName = md5(time().mt_rand(1,100)).".".$ext;
		
		move_uploaded_file($file['tmp_name'],TMP."upload/".$fileName);
		
		App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
		
		ImgServer::instance()->upload_canteen_brand_logo($fileName,TMP."upload/".$fileName);
			
		$this->request->data['Brand']['canteen_logo'] = $fileName;
		
		unlink(TMP."upload/".$fileName);
		
	}
}
?>