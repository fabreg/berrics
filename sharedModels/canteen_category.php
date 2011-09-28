<?php

class CanteenCategory extends AppModel {
	
	public $actsAs = array("GroupTree");
	

	public function treeList() {
		
		
		$tree = $this->find("all",array(
		
			"order"=>array("CanteenCategory.parent_id"=>"ASC","CanteenCategory.lft"=>"ASC"),
			"contain"=>array()
		
		));
		
		$top = Set::extract("/CanteenCategory[parent_id=0]",$tree);
		
		$cats = array();
		
		foreach($top as $v) {
			
			$key = $v['CanteenCategory']['name'];
			
			$cats[$key] = array();
			
			//$cats[$key]['subs'] = Set::extract("/CanteenCategory[parent_id={$key}]",$tree);
			$c = Set::extract("/CanteenCategory[parent_id={$v['CanteenCategory']['id']}]",$tree);
			foreach($c as $cc) $cats[$key][$cc['CanteenCategory']['id']] = $cc['CanteenCategory']['name'];
			
		}
		
		return $cats;
		
	}
	
	public function grabSubcat($cond) {
		
		$token = "canteen_grabSubcat_".md5(serialize($cond));
		
		if(($cat = Cache::read($token,"1min")) === false) {
			
			$cat = $this->find("first",array(
				"conditions"=>$cond,
				"contain"=>array()
			));
			
			if(!empty($cat['CanteenCategory']['parent_id'])) {
				
				$p = $this->find("first",array(
					"conditions"=>array(
						"CanteenCategory.id"=>$cat['CanteenCategory']['parent_id']
					),
					"contain"=>array()
				));
				
				$cat['Parent'] = $p['CanteenCategory'];
				
			}
			
			Cache::write($token,$cat,"1min");
			
		}
		
		return $cat;
		
	}
}