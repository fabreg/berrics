<?php


App::import("Controller","LocalApp");

class BerricsRecordsController extends LocalAppController {
	
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		$this->Paginator->settings = array();

		$this->Paginator->settings['BerricsRecord']['order'] = array("BerricsRecord.id"=>"DESC");

		$records = $this->paginate("BerricsRecord");
		
		$this->set(compact("records"));
		
	}
	
	public function add() {
		
		if(count($this->request->data)>0) {
			
			$this->BerricsRecord->create();
			
			$this->request->data['BerricsRecord']['publish_date']  = date("Y-m-d G:i:s",strtotime("+30 Days"));

			$this->BerricsRecord->save($this->request->data);
			
			return $this->flash("Berrics Record Added Successfully","/berrics_records/edit/".$this->BerricsRecord->id);
			
		}
		
		
	}
	
	
	public function edit($id = false) {
		
		if(!$id) throw new NotFoundException();
		
		if(count($this->request->data)) {
			
			$this->BerricsRecord->create();
			
			$this->BerricsRecord->id = $this->request->data['BerricsRecord']['id'];
			
			//format the publish date and time
			
			$this->request->data['BerricsRecord']['publish_date'] = $this->request->data['BerricsRecord']['pub_date']." ".$this->request->data['BerricsRecord']['pub_time'].":00";
			
			$this->BerricsRecord->save($this->request->data);
			
			return $this->flash("Record Udpated","/berrics_records/edit/".$this->request->data['BerricsRecord']['id']);
			
			
		} else {
			
			$this->request->data = $this->BerricsRecord->find("first",array(
				'conditions'=>array(
					"BerricsRecord.id"=>$id
				),
				"contain"=>array(
					"BerricsRecordsItem"=>array(
						"User",
						"Dailyop"
					)
				)
			));
			
			//format the pub_date and pub_time
			
			$this->request->data['BerricsRecord']['pub_date'] = date("Y-m-d",strtotime($this->request->data['BerricsRecord']['publish_date']));
			
			$this->request->data['BerricsRecord']['pub_time'] = date("G:i",strtotime($this->request->data['BerricsRecord']['publish_date']));
			
		}
		
		$this->setDailyopsList();
		
	}
	
	public function uploads($id = false) {
		
		if(!$id) throw new NotFoundException();
		
		$record = $this->BerricsRecord->find("first",array(
			"conditions"=>array(
				"BerricsRecord.id"=>$id
			),
			"contain"=>array()
		));
		
		//get the uploads
		$this->loadModel("MediaFileUpload");
		
		$uploads = $this->MediaFileUpload->find("all",array(
			"conditions"=>array(
				"model"=>"BerricsRecord",
				"foreign_key"=>$id
			),
			"contain"=>array(
				"User"
			),
			"order"=>Array(
				"MediaFileUpload.created"=>"ASC"
			)
		));
		
		$this->set(compact("uploads","record"));
		
		
	}
	
	
	
	public function setDailyopsList() {
		
		$this->loadModel("Dailyop");
		
		$d = $this->Dailyop->find("all",array(
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>71
			),
			"contain"=>array()
		));
		
		$list = array();
		
		foreach($d as $v) $list[$v['Dailyop']['id']] = $v['Dailyop']['name']." - ".$v['Dailyop']['sub_title'];
		
		$this->set("dailyopsList",$list);
		
	}
	
	
	public function delete() {
		
		
		
	}
	
	public function add_berrics_records_item() {
		
		$this->loadModel("BerricsRecordsItem");
		
		$this->BerricsRecordsItem->create();
		
		$this->BerricsRecordsItem->save($this->request->data);
		
		return $this->flash("Post Attached Successfully","/berrics_records/edit/".$this->request->data['BerricsRecordsItem']['berrics_record_id']);
		
	}
	
	public function update_item_active() {
		
		$this->loadModel("BerricsRecordsItem");
		
		$this->BerricsRecordsItem->create();
		$this->BerricsRecordsItem->id = $this->request->data['BerricsRecordsItem']['id'];
		
		$this->BerricsRecordsItem->save($this->request->data['BerricsRecordsItem']);
		
		return $this->flash("Record Updated","/berrics_records/edit/".$this->request->data['BerricsRecordsItem']['berrics_record_id']);
		
	}
	
	public function update_current_record_item() {
		
		$this->loadModel("BerricsRecordsItem");
		
		$this->BerricsRecordsItem->create();
		$this->BerricsRecordsItem->id = $this->request->data['BerricsRecordsItem']['id'];
		
		$this->BerricsRecordsItem->save($this->request->data['BerricsRecordsItem']);
		
		return $this->flash("Record Updated","/berrics_records/edit/".$this->request->data['BerricsRecordsItem']['berrics_record_id']);
		
	}
	
	public function delete_item($id = false,$berrics_record_id = false) {
		
		if(!$id) throw new NotFoundException();
		
		$this->loadModel("BerricsRecordsItem");
		
		$this->BerricsRecordsItem->delete($id);
		
		return $this->flash("Record Post Deleted Successfully","/berrics_records/edit/".$berrics_record_id);
		
	}

	public function pending_records($limit) {

		$this->loadModel('MediaFileUpload');

		$this->Paginator->settings = array();
		$this->Paginator->settings['MediaFileUpload'] = array(
			"conditions"=>array(
				'MediaFileUpload.model'=>'BerricsRecord'
			),
			"contain"=>array(
				'BerricsRecord',
				'User'
			),
			"limit"=>25,
			"order"=>array(
				"MediaFileUpload.created"=>"DESC"
			)
		);

		if(isset($this->request->params['named']['serach'])) {

			if (isset($this->request->params['named']['MediaFileUpload.file_status']) && 
				!empty($this->request->params['named']['MediaFileUpload.file_status'])) {
				
				$this->Paginator->settings['MediaFileUpload']['conditions']['MediaFileUpload.file_status'] = 
				$this->request->data['MediaFileUpload']['file_status'] = 
						$this->request->params['named']['MediaFileUpload.file_status'];

			}


		}


		$uploads = $this->paginate('MediaFileUpload');
		$this->set(compact("uploads"));


	}

	public function filter_pending() {
		
		if(count($this->request->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"search"=>true
				);
				
				
				foreach($this->request->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						

						$url[$k.".".$kk]=urlencode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}

	}
	
	
	
}