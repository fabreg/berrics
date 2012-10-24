<?php

class BigQueryApi {
	
	private $accessToken = '{"access_token":"ya29.AHES6ZQ9yjVf6xdFjpiLZsfqQIAxDOkm95MMv33GHySZlYNRpsgPrA","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/-qDO6Ug3qj_xnlCqMdhJ0N0zD8QxpZFBI5tFhJtOark","created":1342628689}';
	
	public $berrics_reports = "theberrics.com:site-reports";
	
	private $apiClient;
	private $bq;
	
	public function __construct() {
		
		
		App::import("Vendor","GoogleApiClient",array("file"=>"google-api-php-client/src/apiClient.php"));
		App::import("Vendor","GoogleBigqueryApi",array("file"=>"google-api-php-client/src/contrib/apiBigqueryService.php"));
		
		$apiClient = new apiClient();
		$apiClient->setApplicationName("Testing App");
		$apiClient->setClientId("632632109626-oi3e0cvvkbur75r1fe4cg80dbuk4sjds@developer.gserviceaccount.com");
		$apiClient->setClientSecret("dhWNmyamq9LPLfMpWStQbmww");
		$apiClient->setRedirectUri("http://".$_SERVER['HTTP_HOST']."/tester/goog_callback");
		$apiClient->setScopes(array(
				'https://www.googleapis.com/auth/bigquery'
		));
		$apiClient->setApprovalPrompt("auto");
		
		$apiClient->setAccessToken($this->accessToken);
		
		$this->apiClient = $apiClient;
		
		$this->bq = new apiBigqueryService($apiClient);
		
	}
	
	public function jobs() {
		
		return $this->bq->jobs;
		
	}
	
	
	public function tables() {
		
		return $this->bq->tables;
		
	}
	
	public function processTemplate($data) {
		
		$jobs = array();
		
		switch($data['template']) {
			
			case "traffic-overview":
				$jobs[] = $this->addJob("distinct-visitors",$data);
				break;
			
		}
		
		$data['bq_jobs'] = json_encode($jobs);
		
		return $data;
		
	}
	
	public function addJobQuery($query) {
		
		$opts = array(
			"query"=>$query		
		);
		
		return $this->addJob('default',$opts);
		
	}
	
	/**
	 * Helper command to queue up jobs for reporting templates
	 * @param unknown_type $command
	 */
	public function addJob($command = "default",$opts = array()) {
		
		#setup query for the job to run
		$qr = new JobConfigurationQuery();

		switch(strtolower($command)) {
			
			case "distinct-visitors":
				$qr->setQuery(
					"select count(distinct(session)) as total,date_str
					from traffic.pageviews
					where ts > {$opts['ts_start']} AND ts < {$opts['ts_end']}
					group by date_str
					order by date_str ASC
					"
				);
				break;
			case 'distinct_by_country':
				$qr->setQuery(
					"select count(distinct(session)) as total,country_code 
					from traffic.pageviews 
					group by country_code 
					order by total desc"
				);
				break;
			
			default:
				$def_query = "select count(distinct(session)) from traffic.pageviews";
				
				if(isset($opts['query']) && !empty($opts['query'])) $def_query = $opts['query'];
				
				$qr->setQuery($def_query);
				break;
			
		}
		
		$job = new Job();
		
		$jobConfig = new JobConfiguration();
		
		$jobConfig->setQuery($qr);
		
		$jobRef = new JobReference();
		
		
		//additional job options
		$jobOps = array();
		if(isset($opts['job_id'])) { 
			
			$jobRef->setJobId($opts['jobId']);
			
		} else { 
			
			$jobRef->setJobId($command."_".md5(microtime()));
			
		}

		$jobRef->setProjectId($this->berrics_reports);
		$jobOps['projectId'] = $this->berrics_reports;
		
		$job->setJobReference($jobRef);
		
		$job->setConfiguration($jobConfig);

		//make job test
		$job_id = $this->jobs()->insert($job,$jobOps);
		//die($job_id);
		return $job_id;
		
	}
	
	
	public function getJobStatus($id) {
		
		$status = $this->jobs()->get($this->berrics_reports, $id);
		
		return $status;
		
	}

	
	public function test() {
		
		
		
	}

	
	
}