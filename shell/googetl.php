#!/usr/bin/php
<?php
	echo "Exdcuting.....";
	
	$mysql = new Mysqli(
						'berricsdw',
						'john',
						'19Berrics82',
						'theberrics_traffic'
					);
	if($mysql->connect_error) {
		
		die("Connection Error: ".$mysql->connect_error);
		
	}
	
	$ops = getopt(
		"",
		array(
			"start:",
			"end:",
			"limit:",
			"total:"
		)
	);
	
	if(empty($ops['start'])) die("You have to specify a start pos: --start \n");
	if(empty($ops['total'])) die("You have to specify total number to processes: --total \n");

	
	$page = 0;
	$date = '2011-06-20';
	$loop = true;
	$numrows = 0;
	$limit = (isset($ops['limit']) && !empty($ops['limit'])) ? $ops['limit']:100000;
	$start = (isset($ops['start']) && !empty($ops['start'])) ? $ops['start']:0;
	$total = (isset($ops['total']) && !empty($ops['total'])) ? $ops['total']:5000000;
	$end = $start + $total;
	
	while($loop) {
		
		$offset = $page * $limit;
		
		$sql = "SELECT 
	  	  	   PageView.session,DimRequest.request_uri,
	  	  	   DimDate.report_hour,DimDate.report_day,DimDate.report_month,DimDate.report_year,
	  	  	   DimLocation.country_code,
	  	  	   DimLocation.region_name,
	  	  	   PageView.mobile
	  	  	   FROM fact_page_views `PageView`
	  	  	   INNER JOIN dim_requests `DimRequest` on DimRequest.id = PageView.dim_request_id
	  	  	   INNER JOIN dim_dates `DimDate` on DimDate.id = PageView.dim_date_id
	  	  	   INNER JOIN dim_locations `DimLocation` on DimLocation.id = PageView.dim_location_id
	  	  	   WHERE PageView.id > $start AND PageView.id < $end
	  	  	   ORDER BY PageView.id ASC
	  	  	   LIMIT $offset,$limit";
		
		//$mysql->refresh();
		
		//test
		$start_time = time();
		echo "Start Query Page ($page) \n";
		$test = $mysql->query($sql);
		echo "Query Time:";
		echo (time()-$start_time);
		echo "\n";
		
		if($test->num_rows>0) {
			
			while($row = $test->fetch_row()) {
			
				foreach($row as $k=>$v) $row[$k] = preg_replace("/[',]/","",$v);
				
				//date string
				$row[] = $row[5]."-".$row[4]."-".$row[3];
				//date hour string
				$row[] = $row[5]."-".$row[4]."-".$row[3]." ".$row[2].":00:00";
				//time stamp
				$row[] = strtotime($row[10]);
				
				$str = implode(",",$row)."\n";
				
				file_put_contents("/tmp/{$start}-{$end}.csv", $str,FILE_APPEND);
			
			}
			
			echo "Query: \n";
			echo $sql;
			echo "\n";
			
			$numrows += $test->num_rows;
			echo "Rows Processed: ".$numrows;
			echo "\n";
			$test->free();
			
			$page++;
			
			
		} else {
			
			$loop = false;
			
			`gzip /tmp/$start-$end.csv`;
			
			continue;
			
		}
		
		
		
		
	}
	

	
?>