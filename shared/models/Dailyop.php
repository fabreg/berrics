<?php
class Dailyop extends AppModel {
	var $name = 'Dailyop';
	
	
	public $validate = array(
	
		"name"=>"notEmpty"
	
	
	);
	
	
	public $hasMany = array(
	
		"DailyopMediaItem",
		"DailyopTextItem",
		"UserAssignedPost",
		"DailyopsShareParameter"
		
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
		"OndemandTitle"
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
		"Meta"
	);
	//berrics news category
	private $news_id = 65;
	
	/*
	OVERLOADED METHODS
	*/
	public function afterSave($created) {
		
		$id = $this->id;

		$_SERVER['FORCEMASTER'] = true;

		$post = $this->returnPost(array(
					"Dailyop.id"=>$id
				),true,true);

		//make the keywords
		$s = $this->extractSearchValues($post);
		
		$SearchItem = ClassRegistry::init("SearchItem");

		$SearchItem->insertItem($s);

		return parent::afterSave();

	}

	public function afterDelete($created) {
		
		$SearchItem = ClassRegistry::init("SearchItem");

		$SearchItem->deleteAll(array(
			"model"=>"Dailyop",
			"foreign_key"=>$this->id
		));

		return parent::afterDelete();

	}

	/**
	 * returnPos
	 * 
	 */
	public function returnPost($cond = array(),$admin = false,$no_cache = false,$contain = false) {
		
		if(!$admin) {
			
			$cond[]='Dailyop.publish_date < NOW()';
			$cond['Dailyop.active'] = 1;
			
		}
		
		/*
		 * 		$_contain = array(
			
					"DailyopMediaItem"=>array(
						"fields"=>array(
							"id","media_file_id","display_weight","dailyop_id","featured"
						),
						"MediaFile"=>array(
							"fields"=>array(
								"id","media_type","file_video_still","limelight_file",
								"preroll_label_override","postroll_label_override","preroll_label","postroll_label",
								"preroll_tags","postroll_tags","file","url"
							)
						),
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
					),
					"User"=>array(
						"fields"=>array(
							"id","first_name","last_name","email","active"
						)
					),
					"DailyopSection"=>array(
						"fields"=>array(
							"id","uri","name","active","icon_light_file","icon_dark_file"
						)
					),
					"Tag"=>array(
						"fields"=>array(
							"name","id","slug"
						),
						"User"
					),
					"Meta",
					"DailyopTextItem"=>array(
						"MediaFile"=>array(
							"fields"=>array(
								"id","media_type","file_video_still","limelight_file",
								"preroll_label_override","postroll_label_override","preroll_label","postroll_label",
								"preroll_tags","postroll_tags","file","url"
							)
						),
						"order"=>array("DailyopTextItem.display_weight"=>"ASC")
					),
					"UnifiedStore"
			
				);
			

		 * 
		 */
		$_contain = array(
			
					"DailyopMediaItem"=>array(
						
						"MediaFile"=>array(
	
						),
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
					),
					"User"=>array(

					),
					"DailyopSection"=>array(

					),
					"Tag"=>array(

						"User"
					),
					"Meta",
					"DailyopTextItem"=>array(
						"MediaFile"=>array(

						),
						"order"=>array("DailyopTextItem.display_weight"=>"ASC")
					)
			
				);
			

		if($contain) {
			
			$_contain = $contain;
			
		}
		
		if($admin) {
			
			$_contain["UserAssignedPost"] = array(
				"User"		
			);
			
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
			//$remainder = $total_posts - count($related);
			
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

	public function getRelatedItems($post,$exclude_ids = array(),$strict = true) {
		
		$token = "dailyops-related-items-".$post['Dailyop']['id'];

		if(($posts = Cache::read($token,"1min")) === false) {

			$SearchItem = ClassRegistry::init("SearchItem");

			$sv = $this->extractSearchValues($post);

			//$str = $sv['title']." ".$sv['sub_title']." ".$sv['keywords'];

			$tags = Set::extract("/Tag/name",$post);

			$str = implode(" ", $tags);

			$exclude_ids[] = $post['Dailyop']['id'];
			
			$exclude = array(
				"SearchItem.model"=>"Dailyop",
				"NOT"=>array(
					"SearchItem.foreign_key"=>$exclude_ids
				)
				
			);
			
			$sids = $SearchItem->run_search($str,$strict,$exclude);

			if(count($sids)<=0) $sids = $SearchItem->run_search($str,false,$exclude);

			$ids = Set::extract("/SearchItem/foreign_key",$sids);

			$posts = $this->find("all",array(
						"conditions"=>array(
							"Dailyop.id"=>$ids,
							"Dailyop.active"=>1,
							"Dailyop.promo"=>0,
							"Dailyop.publish_date < NOW()"
						),
						"contain"=>array(
							"DailyopMediaItem"=>array(
								"MediaFile",
								"order"=>array(
									"DailyopMediaItem.display_weight"=>"ASC"
								),
								"limit"=>1
							),
							"DailyopSection",
							"DailyopTextItem"=>array(
								"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
								"limit"=>1,
								"MediaFile"
							)
						),
						"limit"=>4,
						"order"=>array(
							"Dailyop.publish_date"=>"DESC"
						)
						

					));

			Cache::write($token,$posts,"1min");
		
		}

		

		return $posts;

	}
	
	public function trickipedia_list($noCache = false) {

		set_time_limit(0);

		$token = "trickipedia-listing";

		if(($p = Cache::read($token,"1min")) === false || $noCache) {

			

			$ds = $this->DailyopSection->find('first',array(
				"conditions"=>array('DailyopSection.id'=>4),
				"contain"=>array()
			));

			$p = $this->find('all',array(
				"fields"=>array(
					"Dailyop.id",
					"Dailyop.uri",
					"Dailyop.publish_date",
					"Dailyop.name",
					"Dailyop.sub_title"
				),
				"conditions"=>array(
					"Dailyop.dailyop_section_id"=>4,
					"Dailyop.publish_date<NOW()",
					"Dailyop.active"=>1
				),	
				"contain"=>array(
					"DailyopMediaItem"=>array(
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
						"MediaFile"
					),
					"Tag"=>array(
						"fields"=>array(
							"Tag.name",
							"Tag.slug",
							"Tag.user_id"
						)
					),
					"Meta"=>array(
						"fields"=>array(
							"Meta.key",
							"Meta.val",
							"Meta.id"
						)
					)
				),
				"order"=>array("Dailyop.publish_date"=>"DESC")
			));

			$user_ids = Set::extract("/Tag[user_id=/-/i]/user_id",$p);

			$users = $this->User->find('all',array(
				"conditions"=>array('User.id'=>$user_ids),
				"contain"=>array()
			));

			foreach($p as $k=>$v) { 

				foreach($v['Tag'] as $kt=>$vt) {

					if(strlen($vt['user_id'])<=0) continue;

					$tu = Set::extract("/User[id={$vt['user_id']}]",$users);

					if(!empty($tu[0]['User']['id'])) $p[$k]['Tag'][$kt]['User'] = $tu[0]['User'];

				}

				$p[$k]['DailyopSection'] = $ds['DailyopSection'];

			}
			//die();
			Cache::write($token,$p,"1min");

		}

		

		return $p;


	}

	public function ___trickipedia_list($noCache = false) {
		
		$token = "trickipedia-listing";

		if(($posts = Cache::read($token,"1min")) === false || $noCache) {

			$posts = $this->find('all',array(
				"conditions"=>array(
					"DailyopSection.id"=>4,
					"Dailyop.publish_date<NOW()",
					"Dailyop.active"=>1,
					"Dailyop.hidden !="=>1
				),
				"contain"=>array(
					"DailyopSection",
					"DailyopMediaItem"=>array(
						"MediaFile",
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
					),
					"Tag"=>array("User"),
					"Meta"
				),
				"order"=>array(
					"Dailyop.publish_date"=>"DESC"
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
				"Dailyop.dailyop_section_id"=>array(7,38,44,47,74,83)
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
				$posts[$k]['Status']['msg'][] = "<div class='dop-status-error'>Duplicate URI <a href='/dailyops/edit/".$v['Dailyop']['id']."/'>(Edit Post)</a></div>";
				
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
	
	public function validatePostStatus($Dailyop) {

			$Dailyop['Status'] = array(
					"msg"=>"",
					"pass"=>true
			);
				
			//run media checks
			if(count($Dailyop['DailyopMediaItem'])<=0 && !$Dailyop['Dailyop']['hide_media']) {
		
				$Dailyop['Status']['pass'] = false;
				$Dailyop['Status']['msg'][] = "<div class='dop-status-error'>No Media Attached to post</div>";
		
		
			} else {
		
				//we have some media, let's do some checks
				switch($Dailyop['DailyopSection']['id']) {
						
					case 65:
						break;
					case 14:
						break;
					default:
						foreach($Dailyop['DailyopMediaItem'] as $kitem=>$item) {
								
							$item_key = ($kitem+1);
							
							switch($item['MediaFile']['media_type']) {
		
								case "bcove":
									//ensure video file is on limelight
									if(empty($item['MediaFile']['limelight_file'])) {
		
										$Dailyop['Status']['pass'] = false;
										$Dailyop['Status']['msg'][] = "<div>Video [{$item_key}]: File Not Uploaded <button type='button' value='{$item['MediaFile']['id']}' class='btn btn-mini btn-primary fix-video-file-button'>Click Here To Fix</button></div>";
		
									}
									//ensure video still image has been uploaded
									if(empty($item['MediaFile']['file_video_still']) || $item['MediaFile']['file_video_still'] == "true") {
		
										$Dailyop['Status']['pass'] = false;
										$Dailyop['Status']['msg'][] = "<div>Video [{$item_key}]: Image Not Uploaded <button type='button' value='{$item['MediaFile']['id']}' class='btn btn-mini btn-primary fix-video-image-button'>Click Here To Fix</button></div>";
		
									}
									//ensure advertising params have been set on video
									if(empty($item['MediaFile']['preroll_label'])) {
		
										$Dailyop['Status']['pass'] = false;
										$Dailyop['Status']['msg'][] = "<div>Video [{$item_key}]: Advertising not set</div>";
		
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
			if(!$this->dupeUriCheck($Dailyop)) {
		
				$Dailyop['Status']['pass'] = false;
				$Dailyop['Status']['msg'][] = "<div class='dop-status-error'>Duplicate URI <a href='/dailyops/edit/".$Dailyop['Dailyop']['id']."/' class='btn btn-mini btn-primary'>Edit Post</a></div>";
		
			}
	
		return $Dailyop;
		
	}
	
	public function getAssignedPostIds($user_id = false,$date_start = false,$days = 7,$noCache = false) {

		if(!$user_id) $user_id = CakeSession::read("Auth.User.id");
		
		if(!$date_start) $date_start = date("Y-m-d");
		
		$date_end = date('Y-m-d',strtotime("+{$days} Days",strtotime($date_start)));
		
		$token = "pending-posts-".$user_id.md5($date_start.$days);
		
		$post_ids = $this->find('all',array(
					"fields"=>array(
						"Dailyop.id"		
					),
					"contain"=>array(),
					"joins"=>array(
						"INNER JOIN user_assigned_posts `UserAssignedPost` ON (UserAssignedPost.dailyop_id=Dailyop.id)"			
					),
					"conditions"=>array(
						"DATE(Dailyop.publish_date) BETWEEN '{$date_start}' AND '{$date_end}'",
						"UserAssignedPost.user_id"=>$user_id		
					)
				));
		
		return $post_ids;
		
	}

	public static function postTemplates() {
		
		$a = array(

			"post-bit"=>"Legacy ( Original Version 2 Template )",
			"slim"=>"Slim Post",
			"news"=>"Standard News",
			"news-large"=>"News Post With Large Image On Dailyops",
			"interrogation"=>"Interrogation Post"

		);

		return $a;

	}
	/**
	 * GET POSTS BY SECTION AND YEAR
	 */
	public function getPostsBySectionYear($DailyopSection = fasle,$year = false) {
			
		if(!$DailyopSection) throw new BadRequestException("No Dailyop Section Passed In");

		if(isset($DailyopSection['DailyopSection'])) $DailyopSection = $DailyopSection['DailyopSection'];

		if(!$year) $year = date("Y");

		$token = "dailyop_section_posts_".$DailyopSection['id']."_".$year;

		if(($posts = Cache::read($token,"1min")) === false) {

			$posts = $this->find("all",array(
				"conditions"=>array(
					"Dailyop.dailyop_section_id"=>$DailyopSection['id'],
					"Dailyop.active"=>1,
					"Dailyop.hidden"=>0,
					"YEAR(Dailyop.publish_date) = '{$year}'",
					"Dailyop.publish_date < NOW()"
				),
				"contain"=>array(
					"DailyopSection",
					"DailyopMediaItem"=>array(
						"MediaFile",
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
						"limit"=>1
					),
					"DailyopTextItem"=>array(
						"MediaFile",
						"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
						"limit"=>1
					)
				),
				"order"=>array(
					"Dailyop.publish_date"=>"DESC"
				)
			));

			//Cache::write($token,$posts,"1min");

		}

		return $posts;


	}	

	public function newsFeed($dateIn = false,$tag_ids = false) {
		
		$cond = array(
			"Dailyop.active"=>1,
			"Dailyop.hidden"=>0,
			"Dailyop.dailyop_section_id"=>65,
			"Dailyop.publish_date < NOW()"
		);

		$contain = array(
			"DailyopTextItem"=>array(
				"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
				"limit"=>1,
				"MediaFile"
			),
			"Tag"=>array(
				"User",
				"Brand"
			),
			"DailyopSection",
			"User"
		);

		$order = array(
			"Dailyop.publish_date"=>"DESC"
		);
		$limit = "25";
		$page = "1";

		if($dateIn) $cond[] = "DATE(Dailyop.publish_date) = '{$dateIn}'";

		$token = "news-feed-".md5(serialize($cond).serialize($contain).serialize($order).$limit.$page);

		if(($posts = Cache::read($token,"1min")) === false) {

			$posts = $this->find("all",array(
					"conditions"=>$cond,
					"contain"=>$contain,
					"order"=>$order,
					"limit"=>$limit,
					"page"=>$page
				));

			Cache::write($token,$posts,"1min");

		}

		return $posts;

	}

	public function validateNewsDateRoute($datein = false) {
		
		$token = "validate-news-date-route-".$datein;

		if(($chk = Cache::read($token,"1min")) == false) {

			$chk = $this->find("first",array(
				"fields"=>array(
					"Dailyop.publish_date"
				),
				"conditions"=>array(
					"DATE(Dailyop.publish_date) <='{$datein}'",
					"Dailyop.dailyop_section_id"=>65,
					"Dailyop.active"=>1,
					"Dailyop.publish_date < NOW()"
				),
				"contain"=>array(),
				"order"=>array(
					"Dailyop.publish_date"=>"DESC"
				)
			));

			Cache::write($token,$chk,"1min");

		}

		return $chk['Dailyop']['publish_date'];

	}

	/**
	 * $direction can either be "next"||"prev"
	 */
	public function getNewsDate($dateIn = false,$direction="next") {
		
		$token = "get-news-date-".$dateIn."-".$direction;


		if(!$dateIn) {

			//if(($date == Cache::read($token,"1min")) === false) {

				$d = $this->find("first",array(
						"fields"=>array(
							"Dailyop.publish_date"
						),
						"conditions"=>array(
							"Dailyop.publish_date < NOW()",
							"Dailyop.active"=>1,
							"Dailyop.hidden"=>0,
							"Dailyop.dailyop_section_id"=>65
						),
						"contain"=>array(),
						"order"=>array(
							"Dailyop.publish_date"=>"DESC"
						),
						"limit"=>1
					));

				$date = date("Y-m-d",strtotime($d['Dailyop']['publish_date']));

				Cache::write($token,$date,"1min");

		//}

			return $date;

		}



		

	}

	public function getRecentPostsByPost($post) {
		
		$token = "get-recent-posts-by-post".$post['Dailyop']['id'];

		if(($posts = Cache::read($token,"1min")) === false) {

			$posts = $this->find("all",array(
				"conditions"=>array(
					"Dailyop.dailyop_section_id"=>$post['Dailyop']['dailyop_section_id'],
					"Dailyop.id !="=>$post['Dailyop']['id'],
					"Dailyop.active"=>1,
					"Dailyop.hidden"=>0,
					"Dailyop.publish_date <= NOW()"
				),
				"contain"=>array(
					"DailyopSection",
						"DailyopMediaItem"=>array(
							"MediaFile",
							"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
							"limit"=>1
						),
						"DailyopTextItem"=>array(
							"MediaFile",
							"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
							"limit"=>1
						)
				),
				"limit"=>4,
				"order"=>array(
					"Dailyop.publish_date"=>"DESC"
				)
			));

			Cache::write($token,$posts,"1min");

		}

		return $posts;

	}

	public function postViewRelated($post,$exclude_section = true) {

		$SearchItem = ClassRegistry::init("SearchItem");

		$posts = $this->find("all",array(
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>$post['Dailyop']['dailyop_section_id'],
				"Dailyop.id !="=>$post['Dailyop']['id'],
				"Dailyop.active"=>1,
				"Dailyop.hidden"=>0,
				"Dailyop.publish_date <= NOW()"
			),
			"contain"=>array(
				"DailyopSection",
					"DailyopMediaItem"=>array(
						"MediaFile",
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
						"limit"=>1
					),
					"DailyopTextItem"=>array(
						"MediaFile",
						"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
						"limit"=>1
					)
			),
			"limit"=>4,
			"order"=>array(
				"Dailyop.publish_date"=>"DESC"
			)
		));

		$tags = Set::extract("/Tag/name",$post);

		$str = implode(" ",$tags);

		$str .= " ".$post['Dailyop']['name']." ".$post['Dailyop']['sub_title'];

		if($exclude_section) {

			$exclude_ids = Set::extract("/Dailyop/id",$posts);

		}
		

		$exclude_ids[] = $post['Dailyop']['id'];

		$cond = array(
			"SearchItem.model"=>"Dailyop",
			"NOT"=>array(
				"SearchItem.foreign_key"=>$exclude_ids
			)
		);

		$res = $SearchItem->run_search($str,false,$cond);

		$ids = Set::extract("/SearchItem/foreign_key",$res);

		$related = $this->find("all",array(
			"conditions"=>array(
				"Dailyop.active"=>1,
				"Dailyop.hidden"=>0,
				"Dailyop.publish_date <= NOW()",
				"Dailyop.dailyop_section_id !="=>65,
				"Dailyop.id"=>$ids
			),
			"contain"=>array(
				"DailyopSection",
					"DailyopMediaItem"=>array(
						"MediaFile",
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
						"limit"=>1
					),
					"DailyopTextItem"=>array(
						"MediaFile",
						"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
						"limit"=>1
					)
			),
			"limit"=>4,
			"order"=>array(
				"Dailyop.publish_date"=>"DESC"
			)
		));

		return array(
			"recent_posts"=>$posts,
			"related_posts"=>$related
		);	

	}

	public function publicContentCalendar($year = false,$month = false) {
		
		if(!$year) $year = date("Y");

		if(!$month) $month = date("m");

		$token = "pub-content-cal-{$year}-{$month}";

		if(($content = Cache::read($token,"5min")) === false) {

					$posts = $this->find("all",array(
						"fields"=>array(
							"Dailyop.name",
							"Dailyop.sub_title",
							"Dailyop.uri",
							"DailyopSection.name",
							"DailyopSection.uri",
							"Dailyop.publish_date"
						),
						"conditions"=>array(
							"YEAR(Dailyop.publish_date) = '{$year}'",
							"MONTH(Dailyop.publish_date) = '{$month}'",
							"Dailyop.active"=>1,
							"Dailyop.hidden"=>0,
							"Dailyop.publish_date < NOW()"
						),
						"contain"=>array(
							"DailyopSection"
						)
					));

					$content = array();

					foreach($posts as $p) {

						$date = date("Y-m-d",strtotime($p['Dailyop']['publish_date']));

						$content[$date][] = $p;

					}

			Cache::write($token,$content,"5min");
		}

		return $content;


	}

	public function extractSearchValues($Dailyop) {

		$id = $Dailyop['Dailyop']['id'];

		$tags = Set::extract("/Tag/name",$Dailyop);
			
		$tags = implode(" ", $tags);

		$kw = $tags." ";

		if(!empty($Dailyop['Dailyop']['text_content'])) $kw.= strip_tags($Dailyop['Dailyop']['text_content'])." ";

		if(count($Dailyop['DailyopTextItem'])>0) {

			foreach ($Dailyop['DailyopTextItem'] as $k => $v) {
				
				$kw.=strip_tags($v['text_content'])." ";
				$kw.=strip_tags($v['text_content_2'])." ";
				$kw.=strip_tags($v['text_content_3'])." ";
				$kw.=strip_tags($v['heading'])." ";

			}

		}

		$s = array(
			"title"=>$Dailyop['Dailyop']['name'],
			"sub_title"=>$Dailyop['Dailyop']['sub_title'],
			"keywords"=>$kw." ".$kw." ".$Dailyop['Dailyop']['name']." ".$Dailyop['Dailyop']['sub_title'],
			"model"=>"Dailyop",
			"foreign_key"=>$id
		);

		return $s;

	}



	public function returnDailyopsHome($startDate = false,$numDays = 2,$isAdmin = false) {
		
		if(!$startDate) $startDate = date("Y-m-d");

		$startDate = $this->checkDailyopsHomeDate($startDate);

		$posts = array(
					"posts"=>array(),
					"news"=>array()
				);

		for($i = 1;$i<=$numDays;$i++) {

			if($i > 1) $startDate = date('Y-m-d',strtotime('-1 Day',strtotime($startDate)));
			
			$startDate = $this->checkDailyopsHomeDate($startDate);
			
			$cond = array(
						"Dailyop.active"=>1,
						"Dailyop.hidden"=>0,
						"DATE(Dailyop.publish_date) = '$startDate'"
					);

			//do an admin check
			if (!$isAdmin) {
				
				$cond[] = "Dailyop.publish_date < NOW()";	

			}

			$dops = $this->find('all',array(
						"conditions"=>$cond,
						"contain"=>array(
							"DailyopMediaItem"=>array(
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
								"limit"=>1,
								"MediaFile"
							),
							"DailyopTextItem"=>array(
								"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
								"limit"=>1,
								"MediaFile"
							),
							"DailyopSection",
							"Tag"=>array(
								"UnifiedStore",
								"User",
								"Brand"
							)
						),
						"order"=>array(
							"Dailyop.pinned"=>"DESC",
							"Dailyop.publish_date"=>"DESC",
							"Dailyop.display_weight"=>"ASC"
						)

					));

					
			
			
			$posts['posts'] = array_merge($posts['posts'],$dops);
			
		}

		return $posts;

	}

	public function checkDailyopsHomeDate($dateIn = false) {
		
		$chk = $this->find("count",array(
			"conditions"=>array(
				"DATE(Dailyop.publish_date) = '{$dateIn}'",
				"Dailyop.active"=>1,
				"Dailyop.hidden"=>0,
				"Dailyop.publish_date <= NOW()"
			),
			"contain"=>array()
		));
		
		if($chk<=0) return $this->checkDailyopsHomeDate(date("Y-m-d",strtotime("-1 Day",strtotime($dateIn))));

		return $dateIn;

	}


	
	
}