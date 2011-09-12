<?php

App::import("Controller","AdminApp");

App::import("Vendor","DfpApi",array("file"=>"DfpApi.php"));

class DfpReportsController extends AdminAppController {
	
	
	public $uses = array('DfpReport');
	
	public $helpers = array("Dfp");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		//$this->Auth->allow("*");
		if($this->params['action'] == "public") {
			
			$this->params['action'] = "view_report";
			$this->Auth->allow("view_report");
			$this->layout = "plain";
			
		}
	}
	
	
	public function index() {
		
		
		$this->paginate['DfpReport'] = array(
		
			"limit"=>100,
			"order"=>array("DfpReport.id"=>"DESC")
		);
		
		$reports = $this->paginate("DfpReport");
		
		$this->set(compact("reports"));
			
	}
	
	public function choose_company() {
		
		if(count($this->data)>0) {

			$id = $this->data['DfpReport']['Company'];
			
			return $this->redirect("/dfp_reports/choose_orders/".$id);
			
		}
		
		$this->companyList();
		
	}
	
	public function choose_orders($company_id) {
		
		if(count($this->data)>0) {
			//die(pr($this->data));
			$filters = serialize($this->data['order']);
			
			$report_id =DFPAPI::instance()->executeReportJob($this->data['DfpReport']['date_start'],$this->data['DfpReport']['date_end']);
			
			$this->data['DfpReport']['serialized_filters'] = $filters;
			
			$this->data['DfpReport']['report_id'] = $report_id;
			
			$this->data['DfpReport']['hash'] = md5(time());
			
			$this->DfpReport->save($this->data);
			
			return $this->redirect(array("action"=>"view_report",$this->data['DfpReport']['hash']));
			
		} else {
			
			$this->data['DfpReport']['date_start'] = date("Y-m-d",strtotime("-1 Month"));
			$this->data['DfpReport']['date_end'] = date("Y-m-d");
		}
		
		$orders = DFPAPI::instance()->getOrdersByCompanyId($company_id);
		
		$this->data['Orders'] = $orders;
		
	}
	
	public function view_report($id = false) {
		
		$report = $this->DfpReport->find("first",array(
			"conditions"=>array(
				"DfpReport.hash"=>$id
			)
		));
		
		$csv = false;
		
		if($this->DfpReport->reportFileExists($report)) {
			
			$csv = $report['DfpReport']['report_id'].".csv";
			
		} else {
			
			//check to see if the report is ready
			if(DFPAPI::instance()->checkReportStatus($report['DfpReport']['report_id'])) {
				
				//download the reports
				DFPAPI::instance()->downloadReport($report['DfpReport']['report_id']);
				
				$csv = $report['DfpReport']['report_id'].".csv";
				
			}
			
		}
		
		if($csv) {
			
			$csv = file_get_contents(TMP."dfp/".$csv);
			
		}
		
		$this->set(compact("csv","report"));

	}
	
	public function formatCsvData(/*POLYMORPHIC*/) {
		
		
		
	}
	
	
	private function companyList() {
		
		$c_data = DFPAPI::instance()->getCompanies();
		
		$list = array();
		
		foreach($c_data as $v) {
			
			
			$list[$v['id']] = $v['name']." - ".$v['type'];
			
			
		}
		
		
		$this->set("company_list",$list);
		
		return $list;
		
	}

	
}