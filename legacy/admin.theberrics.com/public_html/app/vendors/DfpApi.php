<?php

class DFPAPI {
	
	
	public static $instance = false;
	
	
	private function __construct() {
		
		
		
	}
	
	
	public static function instance() {
		
		if(!self::$instance) {
			
			self::$instance = new self();
			
		}
		
		
		return self::$instance;
		
		
	}
	
	
	public function getCompanies() {
		
		
		$path = dirname(__FILE__) . '/dfp/src';
		$old_path = set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		
		require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
		
		set_include_path($old_path);
		
		$cache_token = "dfp_companies";
		
		if(($data = Cache::read($cache_token,"5min")) === false) {
			
			$data = array();
		
			try {
			  // Get DfpUser from credentials in "../auth.ini"
			  // relative to the DfpUser.php file's directory.
			  $user = new DfpUser();
			
			  // Log SOAP XML request and response.
			  $user->LogDefaults();
			
			  // Get the CompanyService.
			  $companyService = $user->GetCompanyService('v201108');
			
			  // Set defaults for page and statement.
			  $page = new CompanyPage();
			  $filterStatement = new Statement();
			  $offset = 0;
			
			  do {
			    // Create a statement to get all companies.
			    $filterStatement->query = 'LIMIT 500 OFFSET ' . $offset;
			
			    // Get companies by statement.
			    $page = $companyService->getCompaniesByStatement($filterStatement);
			
			    // Display results.
			    if (isset($page->results)) {
			      $i = $page->startIndex;
			      foreach ($page->results as $k=>$company) {
			        $data[$k]['name'] = $company->name;
			        $data[$k]['id'] = $company->id;
			        $data[$k]['type'] = $company->type;
			        
			      }
			    }
			
			    $offset += 500;
			  } while ($offset < $page->totalResultSetSize);
			
			  
			} catch (Exception $e) {
			   die($e->getMessage());
			}
			asort($data);
			Cache::write($cache_token,$data,"5min");
			
		}
		

		return $data;
		
	}

	public function getOrdersByCompanyId($id = false) {
		
		
		if(!$id) {
			
			return;
			
		}
		
		$path = dirname(__FILE__) . '/dfp/src';
		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		
		require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
		require_once 'Google/Api/Ads/Common/Util/MapUtils.php';
		
		$token = "company_orders_".$id;
		
		if(($data = Cache::read($token,"5min")) === false) {
			
			
			$data = array();
			
			try {
			  // Get DfpUser from credentials in "../auth.ini"
			  // relative to the DfpUser.php file's directory.
			  $user = new DfpUser();
			
			  // Log SOAP XML request and response.
			  $user->LogDefaults();
			
			  // Get the OrderService.
			  $orderService = $user->GetOrderService('v201108');
			
			  // Set the ID of the advertiser (company) to get orders for.
			  $advertiserId = (float) $id;
			
			  // Create bind variables.
			  $vars = MapUtils::GetMapEntries(
			      array('advertiserId' => new NumberValue($advertiserId)));
			
			  // Create a statement to only select orders for a given advertiser.
			  $filterStatement =
			      new Statement("WHERE advertiserId = :advertiserId LIMIT 500", $vars);
			
			  // Get orders by statement.
			  $page = $orderService->getOrdersByStatement($filterStatement);
			
			  // Display results.
			  if (isset($page->results)) {
			    $i = $page->startIndex;
			    foreach ($page->results as $k=>$order) {
			     	$data[$k]['id'] = $order->id;
			     	$data[$k]['name'] = $order->name;
			     	$data[$k]['advertiserId']=$order->advertiserId;
			    }
			  }
			
			  Cache::write($token,$data,"5min");
			  
			} catch (Exception $e) {
			  die($e->getMessage());
			}
			
			
		}
		
		return $data;
		
	}
	
	
	
	
	public function executeReportJob($date_start = false, $date_end = false) {
					
		
			if(!$date_start) {
				
				$date_start = '2009-07-01';
				
			}
			
			if(!$date_end) {
				
				$date_end = date("Y-m-d");
				
			}
		
			$path = dirname(__FILE__) . '/dfp/src';
			set_include_path(get_include_path() . PATH_SEPARATOR . $path);
			
			require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
			
			try {
			  // Get DfpUser from credentials in "../auth.ini"
			  // relative to the DfpUser.php file's directory.
			  $user = new DfpUser();
			
			  // Log SOAP XML request and response.
			  $user->LogDefaults();
			
			  // Get the ReportService.
			  $reportService = $user->GetReportService('v201108');
			
			  // Create report job.
			  $reportJob = new ReportJob();
			
			  // Create report query.
			  $reportQuery = new ReportQuery();
			  $reportQuery->dateRangeType = 'CUSTOM_DATE';
			  $reportQuery->startDate = new Date(date("Y",strtotime($date_start)),date("m",strtotime($date_start)),date("d",strtotime($date_start)));
			  $reportQuery->endDate = new Date(date("Y",strtotime($date_end)),date("m",strtotime($date_end)),date("d",strtotime($date_end)));
			  $reportQuery->dimensions = array('ORDER','CREATIVE_SIZE','CREATIVE');
			  $reportQuery->columns = array('AD_SERVER_IMPRESSIONS', 'AD_SERVER_CLICKS',
			      'AD_SERVER_CTR', 'AD_SERVER_REVENUE', 'AD_SERVER_AVERAGE_ECPM');
			  $reportJob->reportQuery = $reportQuery;
			
			  // Run report job.
			  $reportJob = $reportService->runReportJob($reportJob);
			  return $reportJob->id;
			 
			} catch (Exception $e) {
			 die($e->getMessage());
			}
		
	}
	
	
	public function downloadReport($id) {
				
		$path = dirname(__FILE__) . '/dfp/src';
		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		
		require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
		require_once 'Google/Api/Ads/Dfp/Util/ReportUtils.php';
		
		try {
		  // Get DfpUser from credentials in "../auth.ini"
		  // relative to the DfpUser.php file's directory.
		  $user = new DfpUser();
		
		  // Log SOAP XML request and response.
		  $user->LogDefaults();
		
		  // Get the ReportService.
		  $reportService = $user->GetReportService('v201108');
		
		  // Set the ID of the completed report.
		  $reportJobId = (float) $id;
		
		  // Set the format of the report.  Ex: CSV
		  $exportFormat = 'CSV';
		
		  // Set the file name to download the gzipped report to. Ex: report.csv.gz.
		  $fileName = $id.".csv.gz";
		
		  $filePath = TMP."/dfp_csv";
		
		  $downloadUrl =
		      $reportService->getReportDownloadURL($reportJobId, $exportFormat);
			
		  //printf("Downloading report from URL '%s'.\n", $downloadUrl);
		
		 // ReportUtils::DownloadReport($downloadUrl, $filePath);
			
		  $cwd = getcwd();
		  
		  
		  
		  chdir(TMP."dfp");
		  exec('wget -O '.$fileName.' '.$downloadUrl);
		  exec('gunzip '.$fileName);
		  chdir($cwd);    
		      
		//  printf("Report downloaded to file '%s'.\n", $filePath);
		} catch (Exception $e) {
			 die($e->getMessage());
		}
		
	}
	
	public function getCreative($id) {
		
		$token = "creative_".$id;
		
		if(($c = Cache::read($token,"1day")) === false) {
			
				$path = dirname(__FILE__) . '/dfp/src';
				set_include_path(get_include_path() . PATH_SEPARATOR . $path);
				
				require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
				
				try {
				  // Get DfpUser from credentials in "../auth.ini"
				  // relative to the DfpUser.php file's directory.
				  $user = new DfpUser();
				
				  // Log SOAP XML request and response.
				  $user->LogDefaults();
				
				  // Get the CreativeService.
				  $creativeService = $user->GetCreativeService('v201108');
				
				  // Set the ID of the creative to get.
				  $creativeId = (float) $id;
				
				  // Get the creative.
				  $creative = $creativeService->getCreative($creativeId);
				
				  // Display results.
				  if (isset($creative)) {
				    $c = get_object_vars($creative);
				  	
				    foreach($c as $k=>$v) {
				    	
				    	if(is_object($c[$k])) {
				    		
				    		$c[$k] = get_object_vars($c[$k]);
				    		
				    	}
				    	
				    }
				    
				  	Cache::write($token,$c,"1day");
				  	
				  } else {
				    
				  }
				} catch (Exception $e) {
				 	return $e->getMessage();
				}	
			
		}
		
		return $c;
				
		
	}
	
	public function checkReportStatus($id) {
		
		
		$path = dirname(__FILE__) . '/dfp/src';
		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
		
		require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
		
		
		try {
		  // Get DfpUser from credentials in "../auth.ini"
		  // relative to the DfpUser.php file's directory.
		  $user = new DfpUser();
		
		  // Log SOAP XML request and response.
		  $user->LogDefaults();
		
		 
		
		  // Set the ID of the completed report.
		  $reportJobId = (float) $id;
		  
		  $reportService = $user->GetReportService('v201108');
		
		  $reportJob = $reportService->getReportJob($reportJobId);
		  
		  if($reportJob->reportJobStatus == 'COMPLETED') {
		  	
		  	return true;
		  	 
		  } else {
		  	
		  	return false;
		  	
		  }
		
		//  printf("Report downloaded to file '%s'.\n", $filePath);
		} catch (Exception $e) {
			 die($e->getMessage());
		}
		
		
	}
	
	/*
	 * 
	 *  do {
			    printf("Report with ID '%d' is running.\n", );
			    sleep(30);
			    // Get report job.
			    $reportJob = $reportService->getReportJob($reportJob->id);
			  } while ($reportJob->reportJobStatus == 'IN_PROGRESS');
			
			  if ($reportJob->reportJobStatus == 'FAILED') {
			    printf("Report job with ID '%d' failed to finish successfully.\n",
			        $reportJob->id);
			  } else {
			    printf("Report job with ID '%d' completed successfully.\n", $reportJob->id);
			  }
			 
	 */
	
}