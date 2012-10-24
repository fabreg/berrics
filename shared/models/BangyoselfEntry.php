<?php

class BangyoselfEntry extends AppModel {
	
	
	public $belongsTo = array(
	
	
		"User",
		"Dailyop",
		"BangyoselfEvent"
		
	
	);	
	
	public function update_facebook_likes($id) {
		
		
		
		$entry = $this->find("first",array(
			"conditions"=>array("BangyoselfEntry.id"=>$id),
			"contain"=>array(
				"Dailyop"=>array("DailyopSection")
			)
		));
		
		
		$fb = FacebookApi::instance();
		
		$sql = "SELECT url, normalized_url, share_count, like_count, comment_count, total_count,
				commentsbox_count, comments_fbid, click_count FROM link_stat WHERE url='http://theberrics.com/{$entry['Dailyop']['DailyopSection']['uri']}/{$entry['Dailyop']['uri']}'";
		
		$q = $fb->facebook->api(array(
			
			"method"=>"fql.query",
			"query"=>$sql,
			"format"=>"json"
		
		));
		
		$count = $q[0]['total_count'];
		
		$this->create();
		
		$this->id = $id;
		
		$this->save(array("like_count"=>$count));
		
		
	}
	
	
	
	
}