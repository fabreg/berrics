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
						
			$data = $this->CanteenProduct->find("all",array(
				"fields"=>array(
					"CanteenProduct.id",
					"CanteenProduct.brand_id"
				),	
				"conditions"=>array(
					"CanteenProduct.canteen_category_id"=>$canteen_category_id,
					"CanteenProduct.active"=>1,
					"DATE(CanteenProduct.publish_date) < NOW()"
				),
				"contain"=>array()
			));
			
			$product_ids = Set::extract("/CanteenProduct/id",$data);
			
			$product_id_str = implode(",",$product_ids);
			
			$brand_ids = Set::extract("/CanteenProduct/brand_id",$data);
			
			$brand_id_str = implode(",",$brand_ids);
			
			$metas = $this->query(
				"SELECT Meta.id,Meta.key,Meta.val FROM metas AS `Meta`
				LEFT JOIN canteen_products_metas AS `CanteenProductMeta` ON CanteenProductMeta.meta_id=Meta.id
				WHERE CanteenProductMeta.canteen_product_id IN ({$product_id_str})
				ORDER BY Meta.key,Meta.val ASC"
			);
			
			$brands = $this->query(
				"SELECT Brand.name,Brand.id 
				FROM brands AS `Brand`
				WHERE Brand.id IN ({$brand_id_str})
				ORDER BY Brand.name ASC"
			);
	
			$filters = array();
			
			foreach($brands as $b) $filters['Brand'][$b['Brand']['id']] = $b['Brand'];
			
			foreach($metas as $m) $filters['Meta'][strtolower($m['Meta']['key'])][$m['Meta']['id']] = $m['Meta']['val'];			

			Cache::write($cache_token,$filters,"1min");
			
		}


		return $filters;
		
	}
	
}