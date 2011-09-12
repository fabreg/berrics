<?php

class StatsShell extends Shell {
	
	
	public $uses = array(
		"FactMediaView",
		"DimDate",
		"MediaFile",
		"EmailMessage"
	);
	
	
	public function queue_daily_video() {
		
		//get yesterday
		$yesterday = date("Y-m-d",strtotime("-1 Day"));

		//let's get the top 20 videos
		$top20 = $this->FactMediaView->query(
			"SELECT count(*) AS `total`,FactMediaView.media_file_id
			FROM fact_media_views AS `FactMediaView`
			WHERE FactMediaView.dim_date_id IN (SELECT id FROM dim_dates as `DimDate` WHERE DimDate.report_date = '{$yesterday}')
			GROUP BY FactMediaView.media_file_id
			ORDER BY total DESC LIMIT 100
			"
		);
		
		$media_file_ids = Set::extract("/FactMediaView/media_file_id",$top20);
		$this->MediaFile->getDatasource()->reconnect();
		$media_files = $this->MediaFile->find("all",array(
			"conditions"=>array(
				"MediaFile.id"=>$media_file_ids
			),
			"contain"=>array()
		));
		
		foreach($top20 as $k=>$v) {
			
			$file = Set::extract("/MediaFile[id={$v['FactMediaView']['media_file_id']}]",$media_files);
			
			$top20[$k]['MediaFile'] = $file[0]['MediaFile'];
			
		}
		
		$this->EmailMessage->save(array(
			"to"=>"john.hardy@me.com",
			"cc"=>"john@theberrics.com,john.c.hardy@gmail.com",
			"from"=>"do.not.reply@theberrics.com",
			"serialized_data"=>serialize($top20),
			"template"=>"daily_video_stats",
			"subject"=>"Daily Video Stats - ".$yesterday,
			"app_name"=>"Crontab",
			"send_as"=>"html"
		));
		
		
	}
	
	
	
	
	
	
	
	
}