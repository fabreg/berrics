<?php

App::import("Controller","LocalApp");

App::import("Vendor","DfpApi",array("file"=>"DfpApi.php"));

class DfpReportsController extends LocalAppController {
	
	
	public $uses = array('DfpReport');
	
	public $helpers = array("Dfp");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		//$this->Auth->allow("*");
		if($this->request->params['action'] == "public") {
			
			$this->request->params['action'] = "view_report";
			$this->Auth->allow("view_report");
			$this->layout = "plain";
			
		}
	}
	
	
	public function index() {
		
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['DfpReport'] = array(
		
			"limit"=>100,
			"order"=>array("DfpReport.id"=>"DESC")
		);
		
		$reports = $this->paginate("DfpReport");
		
		$this->set(compact("reports"));
			
	}
	
	public function choose_company() {
		
		if(count($this->request->data)>0) {

			$id = $this->request->data['DfpReport']['Company'];
			
			return $this->redirect("/dfp_reports/choose_orders/".$id);
			
		}
		
		$this->companyList();
		
	}
	
	public function choose_orders($company_id) {
		
		if(count($this->request->data)>0) {
			//die(pr($this->request->data));
			$filters = serialize($this->request->data['order']);
			
			$report_id =DFPAPI::instance()->executeReportJob($this->request->data['DfpReport']['date_start'],$this->request->data['DfpReport']['date_end']);
			
			$this->request->data['DfpReport']['serialized_filters'] = $filters;
			
			$this->request->data['DfpReport']['report_id'] = $report_id;
			
			$this->request->data['DfpReport']['hash'] = md5(time());
			
			$this->DfpReport->save($this->request->data);
			
			return $this->redirect(array("action"=>"view_report",$this->request->data['DfpReport']['hash']));
			
		} else {
			
			$this->request->data['DfpReport']['date_start'] = date("Y-m-d",strtotime("-1 Month"));
			$this->request->data['DfpReport']['date_end'] = date("Y-m-d");
		}
		
		$orders = DFPAPI::instance()->getOrdersByCompanyId($company_id);
		
		$this->request->data['Orders'] = $orders;
		
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