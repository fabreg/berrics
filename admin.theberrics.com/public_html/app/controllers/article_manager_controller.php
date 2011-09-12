<?php

App::import("Controller","AdminApp");


class ArticleManagerController extends AdminAppController {
	
	
	public $uses = array("Article","ArticleType","ArticleParagraph","ArticleMediaItem");

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();

	}
	public function search() {
		
		$url = array(
			"action"=>"index",
			"search"=>true
		);
		
		foreach($this->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
		
		//special case for aberrica categories
		
		if(is_array($this->data['AberricaCategory']['AberricaCategory'])) {
			
			$url['AberricaCategory'] = implode("-",$this->data['AberricaCategory']['AberricaCategory']);
			
		}
		
		return $this->redirect($url);
		
	}
	
	public function index() {
		
		$this->paginate['Article'] = array(
		
			"limit"=>50,
			"contain"=>array(
		
				"User",
				"ArticleType",	
				"MediaFile"
			),
			"order"=>array("Article.id"=>"DESC")
		
		);
		
		if(isset($this->params['named']['search'])) {
			
			
			if(isset($this->params['named']['Article.title'])) {
				
				$this->paginate['Article']['conditions']['Article.title LIKE'] = "%".str_replace(" ","%",$this->params['named']['Article.title'])."%"; 
				$this->data['Article']['title'] = $this->params['named']['Article.title'];
				
			}
			
			if(isset($this->params['named']['Article.active'])) {
				
				$this->paginate['Article']['conditions']['Article.active'] = $this->params['named']['Article.active'];
				$this->data['Article']['active'] = $this->params['named']['Article.active'];
				
			}
			
			if(isset($this->params['named']['Article.featured'])) {
				
				$this->paginate['Article']['conditions']['Article.featured'] = $this->params['named']['Article.featured'];
				$this->data['Article']['featured'] = $this->params['named']['Article.featured'];
				
				
			}
			
			if(isset($this->params['named']['Article.article_type_id'])) {
				
				$this->paginate['Article']['conditions']['Article.article_type_id'] = $this->params['named']['Article.article_type_id'];
				$this->data['Article']['article_type_id'] = $this->params['named']['Article.article_type_id'];
				
			}
			
			if(isset($this->params['named']['Article.pub_date_start']) && isset($this->params['named']['Article.pub_date_end'])) {
				
				$date_start = date("Y-m-d",strtotime($this->params['named']['Article.pub_date_start']));
				$date_end = date("Y-m-d",strtotime($this->params['named']['Article.pub_date_end']));
				
				$this->paginate['Article']['conditions'][] = "DATE(Article.publish_date) BETWEEN '{$date_start}' AND '{$date_end}'";
				$this->data['Article']['pub_date_start'] = $date_start;
				$this->data['Article']['pub_date_end'] = $date_end;
				
			}	
			
			if(isset($this->params['named']['Article.my_articles']) && $this->params['named']['Article.my_articles'] == 1) {
				
				$this->paginate['Article']['conditions']['Article.user_id'] = $this->user_id_scope;
				
				$this->data['Article']['my_articles'] = $this->params['named']['Article.my_articles'];
				
			}
			
		}
		
		
		//get some select lists
		$articleTypes = $this->ArticleType->find("list");
		
		$aberricaCategories = $this->Article->AberricaCategory->generatetreelist(null,null,null,"-");
		
		$articles = $this->paginate("Article");
		
		$this->set(compact("articles","articleTypes","aberricaCategories"));
		
		
	}
	
	
	public function create_article() {
		
		if(count($this->data)>0) {
			
			$this->data['Article']['publish_date'] = $this->data['Article']['pub_date']." ".$this->data['Article']['pub_time'].":00";
			//die(pr($this->data));
			
			$this->data['Article']['uri'] = Tools::safeUrl($this->data['Article']['title']).".html";
			
			if($this->Article->save($this->data)) {

				$this->Session->setFlash("Article Created Successfully");
				return $this->redirect(array("action"=>"edit",$this->Article->id));
				
			}
			
		}
		
		//make some select lists
		
		$articleTypes = $this->Article->ArticleType->find("list");
		
		$aberricaCategories = $this->Article->AberricaCategory->generatetreelist(null,null,null,"-");
		
		$this->set(compact("articleTypes","aberricaCategories"));
		
	}
	
	
	public function edit($id = false) {
		
		$_SERVER['FORCEMASTER'] = true;
		
		if(!$id) {
			
			return $this->invalidUrl("/article_manager");
			
		}
		
		if(count($this->data)>0) {
			
			//concat the publish date
			$this->data['Article']['publish_date'] = $this->data['Article']['pub_date']." ".$this->data['Article']['pub_time'].":00";
			
			$this->data['Tag'] = $this->Article->Tag->parseTags($this->data['Article']['tags']);
			
			if($this->Article->save($this->data)) {
				
				//$this->Session->setFlash("Article Updated");
				//$this->redirect(array("action"=>"edit",$this->Article->id));
				return $this->flash("Article Updated",array("action"=>"edit",$this->Article->id));
			}
			
		} else {
			
			
			$this->data = $this->Article->find("first",array(
			
				"conditions"=>array(
					"Article.id"=>$id
				),
				"contain"=>array(
					"User",
					"ArticleType",
					"AberricaCategory",
					"MediaFile",
					"Tag"
				)
			
			));
			
			//format pub_date and pub_time
			
			$this->data['Article']['pub_date'] = date("Y-m-d",strtotime($this->data['Article']['publish_date']));
			
			$this->data['Article']['pub_time'] = date("H:i",strtotime($this->data['Article']['publish_date']));
			
		}
		
		
		//get some select lists
		$articleTypes = $this->Article->ArticleType->find("list");
		
		$aberricaCategories = $this->Article->AberricaCategory->generatetreelist(null,null,null,"-");		
		
		$this->set(compact("articleTypes","aberricaCategories"));
		
	}
	
	function delete($id = false) {
		
		
		
	}
	
	public function ajax_load_paragraphs($article_id = false) {
		
		$_SERVER['FORCEMASTER'] = true;
		
		$paragraphs = $this->ArticleParagraph->find("all",array(
		
			"conditions"=>array("ArticleParagraph.article_id"=>$article_id),
			"order"=>array("ArticleParagraph.sort_weight"=>"ASC"),
			"contain"=>array(
				"MediaFile"
			)
		
		));
		
		$this->set(compact("paragraphs"));
		
	}
	
	public function ajax_new_paragraph($article_id = false,$below = 0) {
		
		$_SERVER['FORCEMASTER'] = true;
				
		$pos = $below + 1;
		
		if($pos > 1) {
			
			$para = $this->ArticleParagraph->find("all",array(
				"conditions"=>array(
					"ArticleParagraph.sort_weight >="=>$pos
				),
				"contain"=>array(),
				"order"=>array("ArticleParagraph.sort_weight"=>"ASC")
			));
			
			foreach($para as $p) {
				
				$id = $p['ArticleParagraph']['id'];
				$this->ArticleParagraph->create();
				$this->ArticleParagraph->id = $id;
				$this->ArticleParagraph->save(array("sort_weight"=>($p['ArticleParagraph']['sort_weight']+1)));
				
			}
			
		}
		
		$this->ArticleParagraph->create();
		
		$this->ArticleParagraph->save(array(
		
			"article_id"=>$article_id,
			"sort_weight"=>$pos
		
		));
		
		
		
		
		$this->autoRender = false;
		
		if(sleep(2)) {
			
			$this->ajax_load_paragraphs($article_id);
		
			
			//$this->set(compact("paragraphs"));
			//$this->layout = 'default';
			return $this->render("ajax_load_paragraphs","default");
			
		} else {
			
			
			die("Didn't Sleep");
			
		}
		
		
		
		
	}
	
	public function ajax_update_paragraphs($article_id) {
		
		//lets loops through the paragraphs
		
		foreach($this->data['paragraph'] as $p) {
			
			$this->ArticleParagraph->create();
			
			$this->ArticleParagraph->id = $p['id'];
			
			$this->ArticleParagraph->save($p);
			
		}
		
		die();
		
	}
	
	
	public function ajax_update_media_align() {

		$this->ArticleParagraph->id = $this->data['ArticleParagraph']['id'];
		
		$this->ArticleParagraph->save(array(
		
			"media_align"=>$this->data['ArticleParagraph']['media_align']
		
		));
		
		die();
		
	}
	
	public function ajax_remove_media() {
		
		$this->ArticleParagraph->id = $this->data['ArticleParagraph']['id'];
		
		$this->ArticleParagraph->save(array(
		
			"media_file_id"=>NULL
		
		));
		die();
		
	}
	
	public function ajax_delete_paragraph() {
		
		//get the paragraph that we want to delete
		
		$paragraph_id = $this->data['ArticleParagraph']['id'];
		
		$paragraph = $this->ArticleParagraph->find("first",array(
		
			"conditions"=>array(
				"ArticleParagraph.id"=>$paragraph_id
			),
			"contain"=>array()	
		
		));
		
		//what's the sort weight?
		$sort_weight = $paragraph['ArticleParagraph']['sort_weight'];
		
		
		
		//get all the post below this one and update the sort weights
		
		$update = $this->ArticleParagraph->find("all",array(
		
			"conditions"=>array(
				"ArticleParagraph.article_id"=>$paragraph['ArticleParagraph']['article_id'],
				"ArticleParagraph.sort_weight >"=>$sort_weight
			),
			"contain"=>array()		
		
		));
		
		
		
		//loop thru and decrement the sort_weight
		foreach($update as $p) {
			
			$this->ArticleParagraph->create();
			$this->ArticleParagraph->id = $p['ArticleParagraph']['id'];
			
			$this->ArticleParagraph->save(array(
				
				"sort_weight"=>($p['ArticleParagraph']['sort_weight'] - 1)
			
			));
			
		}
		
		$this->ArticleParagraph->delete($paragraph_id);
		
		die();
		
	}
	
	
	public function ajax_load_media_items($id) {
		
		
		//get the media items
		$items = $this->ArticleMediaItem->find("all",array(
			
			"conditions"=>array(
		
				"ArticleMediaItem.article_id"=>$id	
		
			),
			"order"=>array(
				"ArticleMediaItem.display_weight"=>"ASC"
			),
			"contain"=>array(
				"MediaFile"
			)
		
		));
		
		
		$this->set(compact("items"));
		
	}
	
	public function ajax_update_media_item_weight($media_item_id = false,$display_weight = false) {
		
		if(!$media_item_id || !$display_weight) {
			
			die("We fucked up!");
			
		}
		
		
		//lets update the stuff
		$this->ArticleMediaItem->id = $media_item_id;
		
		$this->ArticleMediaItem->save(array(
		
			"display_weight"=>$display_weight
		
		));
		
		die("Media Item Updated Successfullys");
		
	}
	
	public function remove_media_item($id = false) {
		
		if(!$id) {
			
			die("Invalid URL");
			
		}
		
		$media_item = $this->ArticleMediaItem->find("first",array(
		
			"conditions"=>array(
				"ArticleMediaItem.id"=>$id
			),
			"contain"=>array()	
		
		));
		
		if($media_item) {
			
			$this->ArticleMediaItem->delete($id);
			
			die("Media Item Removed Article");
			
		} else {
			
			die("Item doesn't exist?");
			
		}
		
		
		
	}	
	
}


?>