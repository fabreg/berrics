<?php

class CanteenCategory extends AppModel {
	
	public $actsAs = array("GroupTree");
	
	public $hasMany = array("CanteenProduct");
	
	public function treeList() {
		
		
		$token = "canteen_categories_";
		
		if(($cats = Cache::read($token,"1min")) === false) {
			
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
			
			//$cats['raw'] = $tree;
			
			Cache::write($token,$cats,"1min");
			
		}
		
		
		
		return $cats;
		
	}
	
	public function getSubcat($cond) {
		
		$token = "canteen_grabSubcat_".md5(serialize($cond));
		
		if(($cat = Cache::read($token,"5min")) === false) {
			
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
	
	
	
	public function treeArray() {
		
		
		$token = "canteen_categories_array_";
		
		if(($cats = Cache::read($token,"5min")) === false) {
			
			$tree = $this->find("all",array(
			
				"order"=>array("CanteenCategory.parent_id"=>"ASC","CanteenCategory.lft"=>"ASC"),
				"contain"=>array()
			
			));
			
			$top = Set::extract("/CanteenCategory[parent_id=0]",$tree);
			
			$cats = array();
			
			foreach($top as $k=>$v) {
				
				$cats[$k] = $v['CanteenCategory'];
				
				//$cats[$key]['subs'] = Set::extract("/CanteenCategory[parent_id={$key}]",$tree);
				$c = Set::extract("/CanteenCategory[parent_id={$v['CanteenCategory']['id']}]",$tree);
				foreach($c as $cc) $cats[$k]['sub_categories'][] = $cc['CanteenCategory'];
				
			}
			
			//$cats['raw'] = $tree;
			
			Cache::write($token,$cats,"1min");
			
		}

		return $cats;
		
	}

	
	public function getProductFilters($canteen_category_id = false) {
		
		$cache_token = "canteen_category_filters_".$canteen_category_id;
		
		if(($filters = Cache::read($cache_token,"1min")) === false) {
			
			$data = $this->find("first",array(
				"conditions"=>array(
					"CanteenCategory.id"=>$canteen_category_id
				),
				"contain"=>array(
					"CanteenProduct"=>array(
						"conditions"=>array(
							"CanteenProduct.active"=>1,
							"DATE(CanteenProduct.publish_date) < NOW()",
							"CanteenProduct.featured"=>1
						),
						"Meta"=>array("order"=>array("Meta.key"=>"ASC","Meta.val"=>"ASC")),
						"Brand"
					)
				)
			));
			
			$filters = array();
			
			foreach($data['CanteenProduct'] as $p) {
			
				$filters['Brand'][$p['Brand']['id']] = $p['Brand'];
				
				foreach($p['Meta'] as $m) $filters['Meta'][strtolower($m['key'])][$m['id']] = $m['val'];
				
			}
			
			//$filters['Meta'] = Set::sort($filters['Meta'],"{s}.{n}.{s}","asc");

			Cache::write($cache_token,$filters,"1min");
			
		}
		
		return $filters;
		
	}
	
	
	
}