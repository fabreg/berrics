<?php
class Dailyop extends AppModel {
	var $name = 'Dailyop';
	
	
	public $validate = array(
	
		"name"=>"notEmpty"
	
	
	);
	
	
	public $hasMany = array(
	
		"DailyopMediaItem",
		"DailyopTextItem",
		
	);
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DailyopSection' => array(
			'className' => 'DailyopSection',
			'foreignKey' => 'dailyop_section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		"UnifiedStore"
	);

	var $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'dailyops_tags',
			'foreignKey' => 'dailyop_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		"Meta",
		"AssignedUser"=>array(
			"className"=>"User",
			"foreignKey"=>"dailyop_id",
			"joinTable"=>"dailyops_users"
		)
	);
	//berrics news category
	private $news_id = 65;
	
	public function returnPost($cond = array(),$admin = false,$no_cache = false,$contain = false) {
		
		if(!$admin) {
			
			$cond[]='Dailyop.publish_date < NOW()';
			$cond['Dailyop.active'] = 1;
			
		}
		
		$_contain = array(
			
					"DailyopMediaItem"=>array(
						"MediaFile",
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
					),
					"User",
					"DailyopSection",
					"Tag"=>array(
						"User"
					),
					"Meta",
					"DailyopTextItem"=>array(
						"MediaFile",
						"order"=>array("DailyopTextItem.display_weight"=>"ASC")
					),
					"UnifiedStore"
			
				);
			

		if($contain) {
			
			$_contain = $contain;
			
		}
		
		if($admin) { //force users to be pulled up if admin setting is true
			
			$_contain[] = 'AssignedUser';
			
		}
				
		$token = "post_".md5(serialize($cond+$_contain))."-".$admin;
		
		if(($post = Cache::read($token,"1min")) === false || $no_cache == true) {
			
			$post = $this->find("first",array(
			
				"conditions"=>$cond,
				"contain"=>$_contain
			
			));
			
			Cache::write($token,$post,"1min");
			
		}
		
		return $post;
		
	}
	
	public function returnPostsByMonth($date = false, $section_id = false, $exclude = false) {
		
		$cond = array(
		
				"Dailyop.publish_date < NOW()",
				"Dailyop.active"=>1,
		        "Dailyop.promo !="=>1,
				"Dailyop.dailyop_section_id"=>$section_id,
				"MONTH(Dailyop.publish_date) = '".date("m",strtotime($date))."'",
				"YEAR(Dailyop.publish_date) = '".date("Y",strtotime($date))."'",
				
		);
			
		if($exclude) {
			
			$cond[] = "Dailyop.id != '{$exclude}'";
			
		}
		
		$token = "posts_by_month_".md5(serialize($cond));
		
		if(($posts = Cache::read($token,"1min")) === false) {
			
			
			$posts = $this->find("all",array(
				"conditions"=>$cond,
				"contain"=>array(
					"DailyopMediaItem"=>array(
						"MediaFile",
						"order"=>array(
							"DailyopMediaItem.display_weight"=>"ASC"
						)
					),
					"Tag",
					"DailyopSection"
				),
				"order"=>array(
					"Dailyop.publish_date"=>"DESC"
				)
			));
			
			Cache::write($token,$posts,"1min");
			
		}
		

		
		return $posts;
		
	}
	
	
	public function returnPostByUri($uri = false,$section = false) {
		
		
		if(!$uri || !$section) {
			
			return false;

		}
		
		$cache_token = md5($uri.$section);
		
		
		if(($post = Cache::read($cache_token,"1min")) === false) {
				
			$post = $this->find("first",array(
			
					"conditions"=>array(
						"Dailyop.active"=>1,
						"Dailyop.publish_date <= NOW()",
						"Dailyop.uri"=>$uri,
						"DailyopSection.uri"=>$section
					),
					"contain"=>array(
							"DailyopSection",
							"Tag",
							"DailyopMediaItem"=>array(
								"MediaFile",
								"order"=>array(
									"DailyopMediaItem.display_weight"=>"ASC"
								)
							),
							"User"
						)
	
			));
			
			Cache::write($cache_token,$post,"1min");
			
		}
	
		
		if(isset($post['Dailyop']['id'])) {
			
			return $post;
			
		} else {
			
			return false;
			
		}
		
	}
	
	public function getYearsBySection($section_id = false) {
		
		$years = array();
		
		if(!$section_id) {
			
			return $years;
			
		}
		
		$token = "section_years_".md5($section_id);
		
		
		if(($years = Cache::read($token,"1min")) === false) {
			
			
				
			$years = $this->find("all",array(
					
						"fields"=>array(
							"DISTINCT(YEAR(Dailyop.publish_date)) AS `year`"
						),
						"conditions"=>array(
							"Dailyop.dailyop_section_id"=>$section_id,
							"DATE(Dailyop.publish_date)<NOW()"
						),
						"contain"=>array(),
						"order"=>array("year"=>"DESC")
					
					));
			
			$years = Set::extract("/0/year",$years);
			
			Cache::write($token,$years,"1min");
				
		}
		
		return $years;		
		
	}
	
	public function getLatestYear($section_id = false) {
		
		$cond = array();
		
		if($section_id) {
			
			$cond['Dailyop.dailyop_section_id'] = $section_id;
			
		}
		
		$cond[] = "DATE(Dailyop.publish_date)<NOW()";
		$cond['Dailyop.active'] = 1;
		
		$year = $this->find("all",array(
			
			"fields"=>array(
				"DISTINCT(YEAR(Dailyop.publish_date))  AS `year`"
			),
			"conditions"=>$cond,
			"contain"=>array(),
			"order"=>array("year"=>"DESC"),
			"limit"=>1
		
		));
		
		return $year[0][0]['year'];
		
	}
	
	
	public function getNextDate($date = false, $older = true , $section_id = false) {
		
		//do a hack for bangyoself 3
		
		if(($older && ($date == '2011-09-18')) || (!$older && ($date == '2011-09-16'))) return "2011-09-17";
		
		$cond =	array(
						"Dailyop.active"=>1,
						"Dailyop.hidden"=>0
				);
		
		
		if($section_id) {
			
			$cond['Dailyop.dailyop_section_id'] = $section_id;
			
		}
		
		if($older) {
			
			$cond[] = "DATE(Dailyop.publish_date) < '{$date}'";
			$order = array();
			$fields = array(
					"MAX(DATE(Dailyop.publish_date)) AS `d`"
				);
			
		} else {
			
			$cond[] = "DATE(Dailyop.publish_date) > '{$date}'";
			$order = array("Dailyop.publish_date"=>"ASC");
			$fields = array(
					"DATE(Dailyop.publish_date) AS `d`"
				);
		}
		
		$token = "dop_get_next_date_".md5(serialize($cond));
		
		if(($post = Cache::read($token,"1min")) === false) {
			
			$post = $this->find("first",array(
	
				"fields"=>$fields,
				"conditions"=>$cond,
				"limit"=>1,
				"order"=>$order,
				"contain"=>array()
				
			
			));
		
			Cache::write($token,$post,"1min");
			
		}
		
		return (isset($post[0]['d'])) ? $post[0]['d']:false;
		
		
	}
	
	/*
	 * END OF VIDEO RELATED POSTS
	 * 
	 */
	

	public function getRelatedPosts($dailyop_id = false,$limit = 3) {
		
		//for right now we're going to get the section of the post and search for items of the same type
		$post = $this->returnPost(array(
		
			"Dailyop.id"=>$dailyop_id
		
		));
		
		$r_token = "dop_related_posts_".$dailyop_id;
		
		if(($related = Cache::read($r_token,"1min")) === false) {
			
			$related = array();
			
			$useDate = false;
			
			switch($post['Dailyop']['dailyop_section_id']) {
				

				case 64: //by3
					$hidden = true;
				break;
				default:
					$hidden = false;
				break;
				
			}
			
			$useDate = $post['Dailyop']['publish_date'];
			
			$related = $this->getSectionPostsByDate($post['Dailyop']['dailyop_section_id'],$useDate,2,$post['Dailyop']['id']);
			
			$exclude = Set::extract("/Dailyop/id",$related);
			
			$tag_ids = Set::extract("/Tag/id",$post);
			
			$tagPosts = $this->Tag->returnHighestRankedPosts($tag_ids,$dailyop_id,$exclude);
			
			//how many did we get off of the date?
			$remainder = $total_posts - count($related);
			
			while(count($related) < $limit) {
				
				$tmp = array_shift($tagPosts);
				
				if($hidden) {
					$p = $this->returnPost(array(
				
						"Dailyop.id"=>$tmp,
						"Dailyop.promo !="=>1
				
					));
					
				} else {
					$p = $this->returnPost(array(
				
						"Dailyop.id"=>$tmp,
						"Dailyop.promo !="=>1,
						"Dailyop.hidden"=>0
				
					));
				}
				
				if(isset($p['Dailyop']['id'])) {
					
					$related[] = $p;
					
				}
				
				
			}
			
			
			Cache::write($r_token,$related,"1min");
			
		}
		
		return compact("post","related");
		
	}
	
	private function getSectionPostsByDate($section_id = false,$date = false, $limit = 2,$exclude = false) {
		
		
		
		$cond = array(
			"Dailyop.dailyop_section_id"=>$section_id,
			"Dailyop.id !="=>$dailyop_id,
			"Dailyop.publish_date < NOW()",
			"Dailyop.active"=>1
		);
		
		if($date) {
			
			$month = date("m",strtotime($date));
			$year = date("Y",strtotime($date));
			
			
			$cond[] = "MONTH(Dailyop.publish_date) = '{$month}'";
			$cond[] = "YEAR(Dailyop.publish_date) = '{$year}'";
			
			
		} 
		
		
		if($exclude) {
			
			if(is_array($exclude)) {
				
				$cond['NOT']["Dailyop.id"] = $exclude;
				
			} else {
				
				$cond['Dailyop.id !='] = $exclude;
				
			}
			
		}
		
		$cond[] ='Dailyop.promo !=1';
		$cond[] ='Dailyop.hidden !=1';
		
		$token = "getSectionPostsByDate_".md5(serialize($cond));
		
		if(($posts =  Cache::read($token,"1min")) === false) {
			$posts = $this->find("all",array(
			
				"conditions"=>$cond,
				"order"=>array(
					"Dailyop.publish_date"=>"DESC"
				),
				"limit"=>$limit,
				"contain"=>array(
					"DailyopMediaItem"=>array(
						"MediaFile",
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
						"limit"=>1
					),
					"DailyopSection"
				)
			
			));
					
			Cache::write($token,$posts,"1min");
			
		}
		
		return $posts;

	}
	
	
	public function getUpcomingPosts($validate = false) {
		
		$cond = array(
		
			"Dailyop.active"=>1,
			"Dailyop.publish_date > NOW()",
			"Dailyop.hidden"=>0
		
		);
		
		$posts = $this->find("all",array(
		
			"conditions"=>$cond,
			"contain"=>array(
			
				"DailyopMediaItem"=>array(
					"MediaFile",
					"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
				),
				"DailyopSection",
				"Tag",
				"User"
		
			),
			"order"=>array(
				"Dailyop.publish_date"=>"ASC"
			)
		
		));
		
		if($validate) {
			
			foreach($posts as $k=>$v) {
				
				
				$posts[$k]['Validate'] = $this->validatePost($v);
				
				
			}
			
		}
		
		return $posts;
	}
	
	private function validatePost($post) {
		
		$d = $post['Dailyop'];
		$i = $post['DailyopMediaItem'];
		$t = $post['Tag'];
		
		$msg = array();
		$class = 'good';
		$str = '';
		//check the URI
		if(!$this->dupeUriCheck($post)) {
			
			$msg[] = "Duplicate URI";
			
		}
		
		//check for tags
		if(count($t)<=0) {
			
			$msg[] = "Missing tags";
			
		}
		
		//check for media
		if(count($i)<=0) {
			
			$msg[] = "Missing media";
			
		} else {
			
			//check for image gallery
			switch($post['DailyopSection']['directive']) {
				
				case "image_gallery":
				case "yoonivision":
					if(count($i)<2) {
						
						$msg[] = "ImgGallery has 1 image";
						
					}
				break;
				default:
					foreach($i as $k=>$item) {
						
						$m = $item['MediaFile'];
						
						if(!isset($m['media_type'])) continue;
						
						switch($m['media_type']) {
							
							case "bcove":
								if(empty($m['file_video_still']) || $m['file_video_still'] == NULL) {
									
									$msg[] = "Video({$k}): Missing Image";
									
								}
								
							break;
							
						}
						
					}
				break;
				
			}
			
			
		}
		
		
		//finish'er up 
		
		if(count($msg)>0) {
			
			foreach($msg as $m) $str .= "<li>{$m}</li>"; 
			
			$msg = "<ul>{$str}</ul>";
			
			$class = "fail";
				
		} else {
			
			$msg = '';
			
		}
		
		
		return compact("msg","class");
	
	}
	
	public function dupeUriCheck($post) {
		
		$check = $this->find("count",array(
		
			"conditions"=>Array(
				"Dailyop.id !="=>$post['Dailyop']['id'],
				"Dailyop.dailyop_section_id"=>$post['Dailyop']['dailyop_section_id'],
				"Dailyop.uri"=>$post['Dailyop']['uri']
			),
			"contain"=>array()
		
		));
		
		if($check>0) {
			
			return false;
			
		} else {
			
			return true;
			
		}
		
		
	}
	
	
	public function batbPostSelect() {
		
		//get the battle at the berrics categories
		
		$posts = $this->find("all",array(
		
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>array(7,38,44,47,74)
			),
			"contain"=>array(
				"DailyopSection"
				
			),
			"order"=>array(
				
				"DailyopSection.name"=>"DESC",
				"Dailyop.publish_date"=>"DESC"
			
			)
		
		));
		
		
		$drop = array();
		
		foreach($posts as $post) $drop[$post['Dailyop']['id']] = $post['DailyopSection']['name'].": ".$post['Dailyop']['name']." - ".$post['Dailyop']['sub_title'];
		
		return $drop;
		
	}
	
	
	public function returnLatestPostBySection($section_id,$year = false) {
		
		//get the id of the latest post 
		$token = "latest_post_by_section_".$section_id."_".$year;
		
		if(($post_id = Cache::read($token,"1min")) === false) {
			
			$post_id = $this->find("first",array(
			
				"conditions"=>array(
			
					"Dailyop.dailyop_section_id"=>$section_id,
					"YEAR(Dailyop.publish_date) = '{$year}'",
					"Dailyop.active"=>1,
					"Dailyop.publish_date < NOW()"	
			
				),
				"order"=>array(
				
					"Dailyop.publish_date"=>"DESC"
				
				),
				"limit"=>1,
				"contain"=>array()
			
			));
			
			Cache::write($token,$post_id,"1min");
			
		}
		
		$post = $this->returnPost(array(
		
			"Dailyop.id"=>$post_id['Dailyop']['id']
		
		));
		
		return $post;
		
		
	}
	
	public function getLastNewsDay() {
		
		//return "2012-01-08";
		
		$token = "last_news_day";
		
		if(($check = Cache::read($token,"1min")) === false) {
			
			$check = $this->find("first",array(
				"fields"=>array("DATE(Dailyop.publish_date) AS `date_in`"),
				"conditions"=>array(
					"Dailyop.dailyop_section_id"=>$this->news_id,
					"Dailyop.active"=>1,
					"Dailyop.publish_date < NOW()"
				),
				"contain"=>array(),
				"order"=>array("Dailyop.publish_date"=>"DESC")
			));
			
			Cache::write($token,$check,"1min");
			
		}

		return $check[0]['date_in'];
		
	}
		
	public function returnDailyopsDashboard() {
		
		//get all the upcoming posts
		$posts = $this->find("all",array(
			"conditions"=>array(
				"Dailyop.publish_date > NOW()",
					"DailyopSection.id !="=>65
			),
			"contain"=>array(
				"DailyopMediaItem"=>array("MediaFile"),
				"DailyopSection",
				"AssignedUser",
				"DailyopTextItem"=>array("MediaFile")
			),
			"order"=>array(
				"Dailyop.publish_date"=>"ASC"
			)
		));
		
		
		foreach($posts as $k=>$v) {
			
			$posts[$k]['Status'] = array(
				"msg"=>"",
				"pass"=>true
			);
			
			//run media checks
			if(count($v['DailyopMediaItem'])<=0 && !$v['Dailyop']['hide_media']) {
				
				$posts[$k]['Status']['pass'] = false;
				$posts[$k]['Status']['msg'] .= "<div class='dop-status-error'>No Media Attached to post</div>";
				
				
			} else {
				
				//we have some media, let's do some checks
				switch($v['DailyopSection']['id']) {
					
					case 65:
						break;
					case 14:
						break;
					default:
						foreach($v['DailyopMediaItem'] as $kitem=>$item) {
							
							switch($item['MediaFile']['media_type']) {
								
								case "bcove":
									//ensure video file is on limelight
									if(empty($item['MediaFile']['limelight_file'])) {
										
										$posts[$k]['Status']['pass'] = false;
										$posts[$k]['Status']['msg'] .= "<div class='dop-status-error'>Video[{$kitem}]: File Not Uploaded <a href='javascript:VideoFileUpload.openUpload(\"".$item['MediaFile']['id']."\",\"handleVideoUpload\");'>(Click Here To Upload)</a></div>";
										
									}
									//ensure video still image has been uploaded
									if(empty($item['MediaFile']['file_video_still']) || $item['MediaFile']['file_video_still'] == "true") {
										
										$posts[$k]['Status']['pass'] = false;
										$posts[$k]['Status']['msg'] .= "<div class='dop-status-error'>Video[{$kitem}]: Image Not Uploaded <a href='javascript:VideoStillUpload.openUpload(\"".$item['MediaFile']['id']."\",\"handleStillUpload\");'>(Click Here To Upload)</a></div>";
										
									}
									//ensure advertising params have been set on video
									if(empty($item['MediaFile']['preroll_label'])) {
										
										$posts[$k]['Status']['pass'] = false;
										$posts[$k]['Status']['msg'] .= "<div class='dop-status-error'>Video[{$kitem}]: Advertising not set <a href='/media_files/inspect/".$item['MediaFile']['id']."/'>(Edit Video)</a></div>";
										
									}
									break;
								case "img":
									break;
								
							}
							
						}
						break;
				}
				
				
			}
			
			//run dupe URI checks
			if(!$this->dupeUriCheck($v)) {
				
				$posts[$k]['Status']['pass'] = false;
				$posts[$k]['Status']['msg'] .= "<div class='dop-status-error'>Duplicate URI <a href='/dailyops/edit/".$v['Dailyop']['id']."/'>(Edit Post)</a></div>";
				
			}
			
		}
		
		return $posts;
		
	}
	
	public function returnAtArchive() {
		
		$token = "at-archive-posts";
		
		if(($data = Cache::read($token,"1min")) == false) {
			
			$data = $this->find("all",array(
			
				"conditions"=>array(
					"Dailyop.publish_date <= NOW()",
					"Dailyop.active"=>1,
					"Dailyop.misc_category"=>"news-general",
					"Dailyop.dailyop_section_id"=>65,
					"YEAR(Dailyop.publish_date)=2012",
					"Dailyop.display_weight"=>1
				),
				"group"=>array(
					"DATE(Dailyop.publish_date)",
					"MONTH(Dailyop.publish_date)",
					"DAY(Dailyop.publish_date)"
					
				),
				"order"=>array(
					"Dailyop.publish_date"=>"DESC",
					"Dailyop.display_weight"=>"ASC"
				),
				"contain"=>array(
					"DailyopTextItem"=>array(
						"order"=>array(
							"DailyopTextItem.display_weight"=>"ASC"
						),
						"limit"=>1,
						"MediaFile"
					)
				)
			
			));
			
			Cache::write($token,$data,"1min");
			
		}
		
		return $data;
		
	}

}