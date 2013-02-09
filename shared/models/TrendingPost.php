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

		if(($posts = Cache::read($token,"1min"))===false) {

			switch($section) {

				case "featured-news":
				$Dailyop = ClassRegistry::init("Dailyop");
				$posts = $Dailyop->find("all",array(
					"conditions"=>array(
						"Dailyop.publish_date < NOW()",
						"Dailyop.active"=>1,
						"Dailyop.dailyop_section_id"=>65
					),
					"contain"=>array(
						"DailyopSection",
						"DailyopTextItem"=>array(
							"MediaFile",
							"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
							"limit"=>1
						)
					),
					"order"=>array(
						"Dailyop.publish_date"=>"DESC"
					),
					"limit"=>5
				));
				break;
				default:
				$posts = $this->find("all",array(
							"conditions"=>array(
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
								"TrendingPost.display_weight"=>"ASC"
							)
						));
				break;

			}

			

			Cache::write($token,$posts,"1min");

		}

		return $posts;

	}

	public function featuredPost() {
		
		$date = date('Y-m-d');

		$token = "featured-post-".$date;

		if(($tp = Cache::read($token,"1min")) === false) {

			$tp = $this->find("first",array(
				"conditions"=>array(
					"TrendingPost.start_date <= NOW()",
					"TrendingPost.end_date > NOW()",
					"TrendingPost.section"=>"featured-post"
				)
			));

			Cache::write($token,$tp,"1min");

		}
		
		
		$post = $this->Dailyop->returnPost(array(
					"Dailyop.id"=>$tp['TrendingPost']['dailyop_id']
				));

		return $post;

	}
}
