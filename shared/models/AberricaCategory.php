<?php


class AberricaCategory extends AppModel {
	
	
	public $actsAs = array("GroupTree");
	
	public $hasAndBelongsToMany = array(
	
		'Article' =>
            array(
                'className'              => 'Article',
                'joinTable'              => 'aberrica_categories_articles',
                'foreignKey'             => 'article_id',
                'associationForeignKey'  => 'aberrica_category_id'
               )
	
	);
	
	
	public function grabTree() {
		
		
		$tree = $this->find("all",array(
		
			"order"=>array("AberricaCategory.parent_id"=>"ASC","AberricaCategory.lft"=>"ASC"),
			"contain"=>array()
		
		));
		
		$top = Set::extract("/AberricaCategory[parent_id=0]",$tree);
		
		$cats = array();
		
		foreach($top as $v) {
			
			$key = $v['AberricaCategory']['id'];
			
			$cats[$key] = $v;
			
			$cats[$key]['subs'] = Set::extract("/AberricaCategory[parent_id={$key}]",$tree);
			
			
		}
		
		return $tree;
		
	}
	
}
