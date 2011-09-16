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
}