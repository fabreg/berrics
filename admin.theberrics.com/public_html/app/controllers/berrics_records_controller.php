<?php


App::import("Controller","AdminApp");

class BerricsRecordsController extends AdminAppController {
	
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		$records = $this->paginate("BerricsRecord");
		
		$this->set(compact("records"));
		
	}
	
	public function add() {
		
		if(count($this->data)>0) {
			
			$this->BerricsRecord->create();
			
			$this->data['BerricsRecord']['publish_date']  = date("Y-m-d G:i:s",strtotime("+30 Days"));

			$this->BerricsRecord->save($this->data);
			
			return $this->flash("Berrics Record Added Successfully","/berrics_records/edit/".$this->BerricsRecord->id);
			
		}
		
		
	}
	
	
	public function edit($id = false) {
		
		if(!$id) return $this->cakeError("error404");
		
		if(count($this->data)) {
			
			$this->BerricsRecord->create();
			
			$this->BerricsRecord->id = $this->data['BerricsRecord']['id'];
			
			//format the publish date and time
			
			$this->data['BerricsRecord']['publish_date'] = $this->data['BerricsRecord']['pub_date']." ".$this->data['BerricsRecord']['pub_time'].":00";
			
			$this->BerricsRecord->save($this->data);
			
			return $this->flash("Record Udpated","/berrics_records/edit/".$this->data['BerricsRecord']['id']);
			
			
		} else {
			
			$this->data = $this->BerricsRecord->find("first",array(
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
			
			$this->data['BerricsRecord']['pub_date'] = date("Y-m-d",strtotime($this->data['BerricsRecord']['publish_date']));
			
			$this->data['BerricsRecord']['pub_time'] = date("G:i",strtotime($this->data['BerricsRecord']['publish_date']));
			
		}
		
		$this->setDailyopsList();
		
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
		
		$this->BerricsRecordsItem->save($this->data);
		
		return $this->flash("Post Attached Successfully","/berrics_records/edit/".$this->data['BerricsRecordsItem']['berrics_record_id']);
		
	}
	
	public function update_item_active() {
		
		$this->loadModel("BerricsRecordsItem");
		
		$this->BerricsRecordsItem->create();
		$this->BerricsRecordsItem->id = $this->data['BerricsRecordsItem']['id'];
		
		$this->BerricsRecordsItem->save($this->data['BerricsRecordsItem']);
		
		return $this->flash("Record Updated","/berrics_records/edit/".$this->data['BerricsRecordsItem']['berrics_record_id']);
		
	}
	
	public function update_current_record_item() {
		
		$this->loadModel("BerricsRecordsItem");
		
		$this->BerricsRecordsItem->create();
		$this->BerricsRecordsItem->id = $this->data['BerricsRecordsItem']['id'];
		
		$this->BerricsRecordsItem->save($this->data['BerricsRecordsItem']);
		
		return $this->flash("Record Updated","/berrics_records/edit/".$this->data['BerricsRecordsItem']['berrics_record_id']);
		
	}
	
	public function delete_item($id = false,$berrics_record_id = false) {
		
		if(!$id) return $this->cakeError("error404");
		
		$this->loadModel("BerricsRecordsItem");
		
		$this->BerricsRecordsItem->delete($id);
		
		return $this->flash("Record Post Deleted Successfully","/berrics_records/edit/".$berrics_record_id);
		
	}
	
	
	
}