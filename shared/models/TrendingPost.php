<?php
App::uses('AppModel', 'Model');
/**
 * TrendingPost Model
 *
 */
class TrendingPost extends AppModel {

	public $belongsTo = array(
		"Dailyop"
	);

	public static function sections() {
		
		$a = array(
			"weekly"=>"Weekly",
			"monthly"=>"Monthly",
			"yearly"=>"Yearly",
			"featured-news"=>"Featured News",
			"featured-post"=>"Featured Post"
		);

		return $a;

	}
	
	public function addPost($dailyop_id) {
		
		$chk = $this->find('first',array(
			"conditions"=>array(
				"TrendingPost.dailyop_id"=>$dailyop_id
			),
			"contain"=>array()
		));

		if(!empty($chk['TrendingPost']['id'])) return $chk['TrendingPost']['id'];

		$this->create();

		$d = date("Y-m-d h:i:S",strtotime("+30 Days"));

		$this->save(array(
			"dailyop_id"=>$dailyop_id,
			"start_date"=>$d,
			"end_date"=>$d
		));

		return $this->id;

	}

	public function currentTrending($section = 'daily') {
		
		$token = "trending-{$section}";

		if(($posts = Cache::read($token,"5min"))===false) {

			$posts = $this->find("all",array(
				"condition"=>array(
					"TrendingPost.section"=>$section,
					"TrendingPost.start_date < NOW()",
					"TrendingPost.end_date > NOW()"
				),
				"contain"=>array(
					"Dailyop"=>array(
						"DailyopSection",
						"DailyopMediaItem"=>array(
							"MediaFile",
							"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
							"limit"=>1
						)
					)
				),
				"order"=>array(
					"TrendingPost.start_date"=>"DESC",
					"TrendingPost.display_weight"=>"ASC"
				)
			));

		}

		return $posts;

	}
}
