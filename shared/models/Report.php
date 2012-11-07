<?php

App::import("Vendor","BigQueryApi",array("file"=>"BigQueryApi.php"));

class Report extends AppModel {
	
	
	public $belongsTo = array("User");
	
	public function validate_date_overview($data) {
		
		$this->set($data);
		
	}
	
	public function date_overview($start_date,$end_date,$title = '') {
		
		$params = serialize(array(
					"start_date"=>$start_date,
					"end_date"=>$end_date
				));
		
		$jobs = array();
		
		$data = array(
			"report_type"=>"date_overview",
			"params_data"=>$params,
			"user_id"=>CakeSession::read("Auth.User.id"),
			"report_status"=>"pending",
			"title"=>$title		
		);
		
		$bq = new BigQueryApi();
		
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date." 23:59:59");
		
		$pv_sql = "select count(*) AS total,date_str FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} GROUP BY date_str ORDER BY date_str ASC";
		
		$jobs['pageviews'] = $bq->addJobQuery($pv_sql);
		
		$u_sql = "select count(distinct(session)) AS total,date_str FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} GROUP BY date_str ORDER BY date_str ASC";
		
		$jobs['uniques'] = $bq->addJobQuery($u_sql);
		
		$m_sql = "select count(*) AS total,date_str FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND mobile=1 GROUP BY date_str ORDER BY date_str ASC";
		
		$jobs['mobile_views'] = $bq->addJobQuery($m_sql);
		
		
		$pv_sql = "select count(*) AS total,country_code FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} GROUP BY country_code ORDER BY total DESC";
		
		$jobs['country_pageviews'] = $bq->addJobQuery($pv_sql);
		
		$u_sql = "select count(distinct(session)) AS total,country_code FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} GROUP BY country_code ORDER BY total DESC";
		
		$jobs['country_uniques'] = $bq->addJobQuery($u_sql);
		
		$m_sql = "select count(*) AS total,country_code FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} and mobile=1 GROUP BY country_code ORDER BY total DESC";
		
		$jobs['country_mobile_views'] = $bq->addJobQuery($m_sql);
		
		$data['job_data'] = serialize($jobs);
		
		$this->create();
		
		$this->save($data);
		
		$_SERVER['FORCEMASTER'] = true;
		$report = $this->findById($this->id);
		unset($_SERVER['FORCEMASTER']);
		
		return $report;
		
	}
	
	public function url_report($uri,$start_date,$end_date,$title = "") {
		
		$params = serialize(array(
					"url"=>$uri,
					"start_date"=>$start_date,
					"end_date"=>$end_date
				));
		
		$jobs = array();
		
		$data = array(
				"report_type"=>"url_report",
				"params_data"=>$params,
				"user_id"=>CakeSession::read("Auth.User.id"),
				"report_status"=>"pending",
				"title"=>$title
		);
		
		$bq = new BigQueryApi();
		
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date." 23:59:59");
		
		$pv_sql = "select count(*) as total,date_str FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND uri='{$uri}' GROUP BY date_str ORDER BY date_str ASC";

		$jobs['pageviews'] = $bq->addJobQuery($pv_sql);
		
		$pv_sql = "select count(distinct(session)) as total,date_str FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND uri='{$uri}' GROUP BY date_str ORDER BY date_str ASC";
		
		$jobs['uniques'] = $bq->addJobQuery($pv_sql);
		
		$pv_sql = "select count(*) as total,date_str FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND uri='{$uri}' AND mobile=1 GROUP BY date_str ORDER BY date_str ASC";

		$jobs['mobile_views'] = $bq->addJobQuery($pv_sql);
		
		$pv_sql = "select count(*) AS total,country_code FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND uri='{$uri}' GROUP BY country_code ORDER BY total DESC";
		
		$jobs['country_pageviews'] = $bq->addJobQuery($pv_sql);
		
		$pv_sql = "select count(distinct(session)) AS total,country_code FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND uri='{$uri}' GROUP BY country_code ORDER BY total DESC";
		
		$jobs['country_uniques'] = $bq->addJobQuery($pv_sql);
		
		$pv_sql = "select count(*) AS total,country_code FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND mobile=1 AND uri='{$uri}' GROUP BY country_code ORDER BY total DESC";
		
		$jobs['country_mobile_views'] = $bq->addJobQuery($pv_sql);
		
		$data['job_data'] = serialize($jobs);
		
		$this->create();
		
		$this->save($data);
		
		$_SERVER['FORCEMASTER'] = true;
		$report = $this->findById($this->id);
		unset($_SERVER['FORCEMASTER']);
		
		return $report;
		
	}
	
	public function url_search_report($uri,$start_date,$end_date,$title = "") {
	
		$params = serialize(array(
				"url"=>$uri,
				"start_date"=>$start_date,
				"end_date"=>$end_date
		));
	
		$jobs = array();
	
		$data = array(
				"report_type"=>"url_search",
				"params_data"=>$params,
				"user_id"=>CakeSession::read("Auth.User.id"),
				"report_status"=>"pending",
				"title"=>$title
		);
	
		$bq = new BigQueryApi();
	
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date." 23:59:59");
	
		$tpv_sql = "select count(*) as total FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND uri CONTAINS '{$uri}'";
		
		$jobs['total_pageviews'] = $bq->addJobQuery($tpv_sql);
		
		$pv_sql = "select count(distinct(session)) as total FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND uri CONTAINS '{$uri}'";
		
		$jobs['total_uniques'] = $bq->addJobQuery($pv_sql);
		
		$pv_sql = "select count(*) as total FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND uri CONTAINS '{$uri}' AND mobile=1";
		
		$jobs['total_mobile_views'] = $bq->addJobQuery($pv_sql);
		
		$pv_sql = "select count(*) as total,uri FROM traffic.pages_live where ts >= {$start_ts} AND ts <= {$end_ts} AND uri CONTAINS '{$uri}' GROUP BY uri ORDER BY total DESC LIMIT 100";
	
		$jobs['pageviews'] = $bq->addJobQuery($pv_sql);
	
		$data['job_data'] = serialize($jobs);
	
		$this->create();
	
		$this->save($data);
	
		$_SERVER['FORCEMASTER'] = true;
		$report = $this->findById($this->id);
		unset($_SERVER['FORCEMASTER']);
	
		return $report;
	
	}
	
	public function media_date_overview($start_date,$end_date,$title = '') {
		
		$params = serialize(array(
				"start_date"=>$start_date,
				"end_date"=>$end_date
		));
		
		$jobs = array();
		
		$data = array(
				"report_type"=>"media_date_overview",
				"params_data"=>$params,
				"user_id"=>CakeSession::read("Auth.User.id"),
				"report_status"=>"pending",
				"title"=>$title
		);
		
		$bq = new BigQueryApi();
		
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date." 23:59:59");
		
		$mv_sql = "select count(*) AS total,date_str from traffic.media_live where ts>={$start_ts} and ts<={$end_ts} group by date_str order by date_str asc";
		
		$jobs['total_views'] = $bq->addJobQuery($mv_sql);
		
		$mv_sql = "select count(*) AS total,date_str from traffic.media_live where ts>={$start_ts} and ts<={$end_ts} and mobile = 1 group by date_str order by date_str asc";
		
		$jobs['mobile_views'] = $bq->addJobQuery($mv_sql);
		
		$cv_sql = "select count(*) as total,country_code from traffic.media_live where ts>={$start_ts} and ts <={$end_ts} group by country_code order by total desc";
		
		$jobs['country_views'] = $bq->addJobQuery($cv_sql);
		
		$cv_sql = "select count(*) as total,country_code from traffic.media_live where ts>={$start_ts} and ts <={$end_ts} and mobile = 1 group by country_code order by total desc";
		
		$jobs['country_mobile_views'] = $bq->addJobQuery($cv_sql);
		
		$data['job_data'] = serialize($jobs);
		
		$this->create();
		
		$this->save($data);
		
		$_SERVER['FORCEMASTER'] = true;
		$report = $this->findById($this->id);
		unset($_SERVER['FORCEMASTER']);
		
		return $report;
		
	}

	public function media_file_report($media_file_id = false,$title = "", $start_date,$end_date) {
		

		$params = serialize(array(
				"media_file_id"=>$media_file_id,
				"start_date"=>$start_date,
				"end_date"=>$end_date
		));

		$jobs = array();

		$data = array(
				"report_type"=>"media_file_report",
				"params_data"=>$params,
				"user_id"=>CakeSession::read("Auth.User.id"),
				"report_status"=>"pending",
				"title"=>$title
		);


		$bq = new BigQueryApi();
		
		$start_ts = strtotime($start_date);

		$end_ts = strtotime($end_date." 23:59:59");

		//get the views

		$view_sql = "select count(*) AS total from traffic.media_live where media_file_id = '{$media_file_id}' AND ts>={$start_ts} AND ts<={$end_ts}";

		$jobs['views'] = $bq->addJobQuery($view_sql);

		$mobile_sql = "select count(*) AS total from traffic.media_live where media_file_id = '{$media_file_id}' AND ts>={$start_ts} AND ts<={$end_ts} AND mobile = 1";

		$jobs['mobile_views'] = $bq->addJobQuery($mobile_sql);

		//get the country breakdown

		$country_sql = "select count(*) AS total,country_code from traffic.media_live where media_file_id = '{$media_file_id}' AND ts>={$start_ts} AND ts<={$end_ts} GROUP BY country_code ORDER BY total DESC";

		$jobs['country_view'] = $bq->addJobQuery($country_sql);

		$data['job_data'] = serialize($jobs);
		
		$this->create();
		
		$this->save($data);
		
		$_SERVER['FORCEMASTER'] = true;
		$report = $this->findById($this->id);
		unset($_SERVER['FORCEMASTER']);
		
		return $report;


	}

	public function top_videos($start_date,$end_date,$limit=50,$title = '') {
		
		$params = serialize(array(
				"start_date"=>$start_date,
				"end_date"=>$end_date,
				"limit"=>$limit
		));
		
		$jobs = array();
		
		$data = array(
				"report_type"=>"top_videos",
				"params_data"=>$params,
				"user_id"=>CakeSession::read("Auth.User.id"),
				"report_status"=>"pending",
				"title"=>$title
		);
		
		$bq = new BigQueryApi();
		
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date." 23:59:59");
		
		$mv_sql = "select count(*) AS total,media_file_id from traffic.media_live where ts>={$start_ts} and ts<={$end_ts} group by media_file_id order by total desc limit {$limit}";
		
		$jobs['total_views'] = $bq->addJobQuery($mv_sql);
		
		$mv_sql = "select count(*) AS total,media_file_id from traffic.media_live where ts>={$start_ts} and ts<={$end_ts} and mobile = 1 group by media_file_id order by total desc limit {$limit}";
		
		$jobs['mobile_views'] = $bq->addJobQuery($mv_sql);
		
		$data['job_data'] = serialize($jobs);
		
		$this->create();
		
		$this->save($data);
		
		$_SERVER['FORCEMASTER'] = true;
		$report = $this->findById($this->id);
		unset($_SERVER['FORCEMASTER']);
		
		return $report;
	}	
	
	public function refresh_report_status($report_id = false) {
		
		//get the report
		$_SERVER['FORCEMASTER'] = true;
		$report = $this->findById($report_id);
		
		$bq = new BigQueryApi();
		
		//get the job data
		
		$job_data = unserialize($report['Report']['job_data']);
		
		$report_data = (!empty($report['Report']['report_data'])) ? unserialize($report['Report']['report_data']):array();
		
		foreach($job_data as $k=>$v) {
			
			$status = $bq->getJobStatus($v['jobReference']['jobId']);
			
			if($status['status']['state'] == "DONE") {
				
				$report_data[$k] = $bq->jobs()->getQueryResults($bq->berrics_reports, $v['jobReference']['jobId']);
				
				unset($job_data[$k]);
				
			}
			
		}
		
		if(count($job_data)<=0) {
			
			$this->update_report_status($report['Report']['id'],"completed");
			unset($report['Report']['report_status']);
		}
		
		
		$report['Report']['job_data'] = serialize($job_data);
		
		$report['Report']['report_data'] = serialize($report_data);
		
		$this->create();
		
		$this->id = $report['Report']['id'];
		
		unset($report['Report']['id']);
		
		$this->save($report['Report']);
		
		$report = $this->read();
		unset($_SERVER['FORCEMASTER']);
		return $report;
		
	}
	
	public function update_report_status($report_id,$status) {
		
		$this->create();
		
		$this->id = $report_id;
		
		return $this->save(array(
					"report_status"=>$status		
				));
		
		
	}
	
	public static function formatReportData($Report) {
		
		if($Report['Report']['report_status']!='completed') return $Report; 
		
		$tmp = array();
		
		$Report['Report']['report_data'] = unserialize($Report['Report']['report_data']);
		
		foreach($Report['Report']['report_data'] as $k=>$v) {
			
			if($v['totalRows']<=0) continue;
			
			$schema = Set::classicExtract($v,'schema.fields.{n}.name');
			
			$t = array();
			
			foreach($v['rows'] as $row) {
				
				$vals = Set::classicExtract($row,'f.{n}.v');
				
				$tmp[$k][] = array_combine($schema,$vals);
				
			}
			
		}
		
		$Report['Report']['data_formatted'] = $tmp;
		
		return $Report;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}