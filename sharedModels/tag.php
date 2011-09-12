<?php
class Tag extends AppModel {
	var $name = 'Tag';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
		'Banner' => array(
			'className' => 'Banner',
			'joinTable' => 'banners_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'banner_id',
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
		'DailyopSection' => array(
			'className' => 'DailyopSection',
			'joinTable' => 'dailyop_sections_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'dailyop_section_id',
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
		'Dailyop' => array(
			'className' => 'Dailyop',
			'joinTable' => 'dailyops_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'dailyop_id',
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
		'MediaFile' => array(
			'className' => 'MediaFile',
			'joinTable' => 'media_files_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'media_file_id',
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
		"User",
		"Article",
		"Brand",
		"OndemandTitle",
		"CanteenProduct"
		
	);
	
	public $hasMany = array(
	
		"DailyopsTag"
	
	);
	
	/**
	 * Parses a comma seperated string of tags and returns an array of tag id's
	 * @param String $tags Comma sperated string of tags
	 * @return Array
	 */
	public function parseTags($str) {
		$results=array();
		
		if(strlen($str)>0) {
			
			$a=explode(",",$str);
			
			foreach($a as $k=>$v) {
				
				//check to see if the tag exists
				$new_tag=trim(strtolower($v));
				$slug = Inflector::slug(trim(preg_replace('/[^\w\d_ -]/si', '', $new_tag)));
	
				
				$chk=$this->find('first',array(
				
					"contain"=>array(),
					"conditions"=>array(
					
						"Tag.slug"=>$slug
				
					)
				
				));
				if($chk['Tag']['id']) {
					
					$results[]=$chk['Tag']['id'];
					
					
				} else {
					
					$this->create(array("name"=>$new_tag,"slug"=>$slug));
					$this->save();
					$results[]=$this->id;
					
				}
	
			}
			
		} 
		
		
		return array('Tag'=>$results);

	}
	
	
	
	public function searchTags($str = false) {
		
		if(!$str) {
			
			return false;
			
		}
		
		$str = trim($str);
		
		$strP = explode(" ",$str);
		
		$cond = array();
		
		foreach($strP as $c) {
			
			$cond['OR'][] = "Tag.name LIKE '%{$c}%'";
			
		}
		
		
		$token = "tag_search_".md5(serialize($cond));
		
		if(($tags = Cache::read($token,"1min")) === false) {
			
			$tags = $this->find("all",array(
						
				"conditions"=>$cond,
				"contain"=>array()

			));
			
			Cache::write($token,$tags,"1min");
			
		}
		
		return $tags;
		
	}
	
	
	
	public function returnHighestRankedPosts($tag_ids = array(),$exclude = false) {
		
		//get all the posts for each tag
		$cond = array();
		
		$cond['DailyopsTag.tag_id'] = $tag_ids;
		
		if($exclude) {
			
			if(is_array($exclude)) {
				
				$cond['NOT'][] = array('DailyopsTag.dailyop_id'=>$exclude);
				
			} else {
				
				$cond['DailyopsTag.dailyop_id !='] = $exclude;
				
			}
			
		}
		
		$token = "tag_related_posts_".md5(serialize($cond));
		
		if(($ranked = Cache::read($token,"1min")) === false) {
			
			
					$post_ids = $this->DailyopsTag->find("all",array(
		
					"conditions"=>$cond,
					"contain"=>array()
					
					));
					
					$res = array();
					
					foreach($post_ids as $id) {
						
						$res[$id['DailyopsTag']['dailyop_id']] += 1;
						
					}
					
					asort($res,SORT_NUMERIC);
					
					$res = array_reverse($res,true);
					
					$ranked = array();
					
					foreach($res as $k=>$v) {
						
						$ranked[] = $k;
						
					}
				
					
					Cache::write($token,$ranked,"1min");
			
		}

		return $ranked;
		
	}
	
	public function tagIndexList($letter = false) {
		
		$token = "tag_index_list_".$letter;
		
		
		if(($tags = Cache::read($token,"1min")) === false) {
			
			$tags = $this->find("all",array(
			
				"conditions"=>array(
					"Tag.name LIKE '{$letter}%'"
				),
				"contain"=>array(),
				"order"=>array(
					"Tag.name"=>"ASC"
				)
			
			));
			
			Cache::write($token,$tags,"1min");
			
		}
		
		return $tags;
		
	}

}
