<?php
App::import("Controller","LocalApp");
App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
class DailyopSectionsController extends LocalAppController {

	var $name = 'DailyopSections';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	function index() {
		$this->DailyopSection->recursive = 0;
		
		$this->Paginator->settings = array('DailyopSection' => array(
		
			"limit"=>100,
			"order"=>array("DailyopSection.name"=>"ASC")
		
		));
		
		$this->set('dailyopSections', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dailyop section'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('dailyopSection', $this->DailyopSection->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->DailyopSection->create();
			
			
			
			$this->request->data['DailyopSection']['uri'] = Tools::safeUrl($this->request->data['DailyopSection']['name']);
			
			if ($this->DailyopSection->save($this->request->data)) {
				$this->Session->setFlash(__('The dailyop section has been saved'));
				$this->redirect(array('action' => 'edit',$this->DailyopSection->id));
			} else {
				$this->Session->setFlash(__('The dailyop section could not be saved. Please, try again.'));
			}
		}
		$tags = $this->DailyopSection->Tag->find('list');
		$this->set(compact('tags'));
	}

	function edit($id = null) {
		
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid dailyop section'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			$this->request->data['Tag'] = $this->DailyopSection->Tag->parseTags($this->request->data['Tag']);

			if(($dark_file = $this->uploadIcon($this->request->data,$this->request->data['DailyopSection']['icon_dark_file']))!=false) {
				
				$this->request->data['DailyopSection']['icon_dark_file'] = $dark_file;
				
			} else {
				
				unset($this->request->data['DailyopSection']['icon_dark_file']);
				
			}
			if(($light_file = $this->uploadIcon($this->request->data,$this->request->data['DailyopSection']['icon_light_file']))!=false) {
				
				$this->request->data['DailyopSection']['icon_light_file'] = $light_file;
				
			} else {
				
				unset($this->request->data['DailyopSection']['icon_light_file']);
				
			}
			if(($color_file = $this->uploadIcon($this->request->data,$this->request->data['DailyopSection']['icon_color_file']))!=false) {
				
				$this->request->data['DailyopSection']['icon_color_file'] = $color_file;
				
			} else {
				
				unset($this->request->data['DailyopSection']['icon_color_file']);
				
			}
			if(($heading_file = $this->uploadHeading($this->request->data,$this->request->data['DailyopSection']['section_heading_file']))!=false) {
				
				$this->request->data['DailyopSection']['section_heading_file'] = $heading_file;
				
			} else {
				
				unset($this->request->data['DailyopSection']['section_heading_file']);
				
			}
			
			$this->request->data['Tag'] = $this->DailyopSection->Tag->parseTags($this->request->data['Tag']['Tag']);
			if ($this->DailyopSection->save($this->request->data)) {
				$this->Session->setFlash(__('The dailyop section has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dailyop section could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->DailyopSection->read(null, $id);
		}
		$tags = $this->DailyopSection->Tag->find('list');
		$this->set(compact('tags'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dailyop section'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->DailyopSection->delete($id)) {
			$this->Session->setFlash(__('Dailyop section deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Dailyop section was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	private function uploadIcon($data,$file) {
		
		if(!is_uploaded_file($file['tmp_name'])) {
			
			return false;
			
		}
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$fileName = md5(mt_rand(999,99999).time()).".".$ext;
		
		move_uploaded_file($file['tmp_name'],TMP."uploads/".$fileName);
		
		ImgServer::instance()->upload_icon_file($fileName,TMP."uploads/".$fileName);
		
		unlink(TMP."upload/".$fileName);
		
		return $fileName;
		
		
	}
	
	private function uploadHeading($data,$file) {
		
		if(!is_uploaded_file($file['tmp_name'])) {
			
			return false;
			
		}
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$fileName = md5(mt_rand(999,99999).time()).".".$ext;
		
		move_uploaded_file($file['tmp_name'],TMP."uploads/".$fileName);
		
		ImgServer::instance()->upload_section_heading($fileName,TMP."uploads/".$fileName);
		
		unlink(TMP."upload/".$fileName);
		
		return $fileName;
		
		
	}

	public function manage_menu() {
		
		if(count($this->request->data)>0) {
			
			
			foreach($this->request->data as $k=>$nav) {
				
				$update = array(
				
					"nav_label"=>$nav['nav_label'],
					"sort_weight"=>$nav['sort_weight']
				
				);
				
				$this->DailyopSection->create();
				$this->DailyopSection->id = $k;
				
				$this->DailyopSection->save($update);
				
			}
			
			return $this->flash("Menu Updated","/dailyop_sections/manage_menu");
			
		}
		
		//get all the menu items in sort weight order
		$items = $this->DailyopSection->find("all",array(
		
			"conditions"=>array(
				"DailyopSection.featured"=>1
			),
			"contain"=>array(),
			"order"=>array("DailyopSection.sort_weight"=>"ASC")
		
		));
		
		$this->set(compact("items"));
		
	}
	
	
}
?>