<?php

class Article extends AppModel {
	
	public $hasMany = array(
	
		"ArticleParagraph",
		"ArticleMediaItem"
	
	);
	
	public $belongsTo = array(
	
		"User",
		"ArticleType",
		"MediaFile"
	);
	
	public $hasAndBelongsToMany = array(
	
		'AberricaCategory' =>
            array(
                'className'              => 'AberricaCategory',
                'joinTable'              => 'aberrica_categories_articles',
                'foreignKey'             => 'aberrica_category_id',
                'associationForeignKey'  => 'article_id'
            ),
           "Tag"
	
	);
	
	
	public function returnArticle($date = false,$uri = false,$admin = false,$tally_count = false) {
		
		$conditions = array(
				"DATE(Article.publish_date) = '{$date}'",
				"Article.uri"=>$uri
			);
			
		if(!$admin) {
			
			$conditions["Article.active"] = 1;
			
		}
		
		$article = $this->find("first",array(
			"conditions"=>$conditions,
			"contain"=>array(
				"User",
				"ArticleParagraph"=>array("MediaFile","order"=>array("ArticleParagraph.sort_weight"=>"ASC")),
				"ArticleMediaItem"=>array("order"=>array("ArticleMediaItem.display_weight"=>"ASC"))
			)
		));
		
		///do we have media items?
		
		if(count($article['ArticleMediaItem'])>0) {
			
			$items = $article['ArticleMediaItem'];
			
			if(count($items)>1) {
				
				//get an array of all the media ids 
				
				$ids = Set::extract("/media_file_id",$items);
				
				$media = $this->MediaFile->find("all",array(
					"conditions"=>array("MediaFile.id"=>$ids),
					"contain"=>array()
				));

				//loops through the items and give them a media file
				
				foreach($items as $k=>$v) {
					
					$media_id = $v['media_file_id'];
					
					//lets extract the media file from our collection
					
					$media_file = Set::extract("/MediaFile[id={$media_id}]",$media);
					
					$items[$k]['MediaFile'] = $media_file[0]['MediaFile'];
					
				}

				$article['Gallery'] = $items;

				unset($article['ArticleMediaItem']);
			}

		}
		
		if($tally_count) {
			
			$id = $article['Article']['id'];
			
			$this->query("UPDATE articles SET view_count = view_count+1 WHERE id = '{$id}'");
			
		}
				
		return $article;
		
	}

	
	
}