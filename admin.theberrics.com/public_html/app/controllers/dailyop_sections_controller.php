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
		
		$this->paginate['DailyopSection'] = array(
		
			"limit"=>100,
			"order"=>array("DailyopSection.name"=>"ASC")
		
		);
		
		$this->set('dailyopSections', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dailyop section', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('dailyopSection', $this->DailyopSection->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->DailyopSection->create();
			
			
			
			$this->data['DailyopSection']['uri'] = Tools::safeUrl($this->data['DailyopSection']['name']);
			
			if ($this->DailyopSection->save($this->data)) {
				$this->Session->setFlash(__('The dailyop section has been saved', true));
				$this->redirect(array('action' => 'edit',$this->DailyopSection->id));
			} else {
				$this->Session->setFlash(__('The dailyop section could not be saved. Please, try again.', true));
			}
		}
		$tags = $this->DailyopSection->Tag->find('list');
		$this->set(compact('tags'));
	}

	function edit($id = null) {
		
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dailyop section', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$this->data['Tag'] = $this->DailyopSection->Tag->parseTags($this->data['Tag']);
			
			ImgServer::instance()->connect();
			
			if(($dark_file = $this->uploadIcon($this->data,$this->data['DailyopSection']['icon_dark_file']))!=false) {
				
				$this->data['DailyopSection']['icon_dark_file'] = $dark_file;
				
			} else {
				
				unset($this->data['DailyopSection']['icon_dark_file']);
				
			}
			if(($light_file = $this->uploadIcon($this->data,$this->data['DailyopSection']['icon_light_file']))!=false) {
				
				$this->data['DailyopSection']['icon_light_file'] = $light_file;
				
			} else {
				
				unset($this->data['DailyopSection']['icon_light_file']);
				
			}
			
			ImgServer::instance()->close();
			
			$this->data['Tag'] = $this->DailyopSection->Tag->parseTags($this->data['Tag']['Tag']);
			if ($this->DailyopSection->save($this->data)) {
				$this->Session->setFlash(__('The dailyop section has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dailyop section could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->DailyopSection->read(null, $id);
		}
		$tags = $this->DailyopSection->Tag->find('list');
		$this->set(compact('tags'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dailyop section', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->DailyopSection->delete($id)) {
			$this->Session->setFlash(__('Dailyop section deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Dailyop section was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	private function uploadIcon($data,$file) {
		
		if(!is_uploaded_file($file['tmp_name'])) {
			
			return false;
			
		}
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$fileName = md5(mt_rand(999,9999)).".".$ext;
		
		move_uploaded_file($file['tmp_name'],TMP."upload/".$fileName);
		
		ImgServer::instance()->upload_icon_file($fileName,TMP."upload/".$fileName,false);
		
		unlink(TMP."upload/".$fileName);
		
		return $fileName;
		
		
	}
	
	public function manage_menu() {
		
		if(count($this->data)>0) {
			
			
			foreach($this->data as $k=>$nav) {
				
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