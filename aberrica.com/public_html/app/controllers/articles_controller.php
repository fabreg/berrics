<?php

App::import("Controller","AberricaApp");

class ArticlesController extends AberricaAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function index() {
		
		
	}
	
	public function view() {
		
		//build the date
		$date = date("Y-m-d",strtotime($this->params['year']."-".$this->params['month']."-".$this->params['day']));
		
		$article = $this->Article->returnArticle($date,$this->params['uri'],$this->isAdmin(),true);
		
		$meta_d = $article['Article']['summary'];
		
		$title_for_layout = $article['Article']['title'];
		
		$this->set(compact("article","meta_d","title_for_layout"));
		
	}
	
	public function day() {
		

		if(
			isset($this->params['year']) && 
			isset($this->params['month']) && 
			isset($this->params['day'])
 		) {
			
 			$date = date("Y-m-d",strtotime($this->params['year']."-".$this->params['month']."-".$this->params['day']));
 		
		} else {
			
			$date = date("Y-m-d");
			
		}

		$this->loadModel("Article");
		$this->loadModel("User");
		$this->loadModel("CoverPage");
		
		//get the cover page
		$cover = $this->CoverPage->find("first",array(
		
			"conditions"=>array(
		
				"CoverPage.publish_date"=>$date,
				"CoverPage.aberrica_category_id"=>0	
		
			)
		
		));
		
		
		//get the articles
		$articles = $this->Article->find("all",array(
		
			"conditions"=>array(
				"Article.active"=>1,
				"DATE(Article.publish_date) = '{$date}'"
			),
			"contain"=>array(
				"MediaFile",
				"Tag",
				"User"
			),
			"order"=>array("Article.publish_date"=>"DESC")
		
		));
		
		$featured_bloggers = $this->User->find("all",array(
			"conditions"=>array(
				"User.active"=>1,
				"User.facebook_account_num !="=>'',
				"User.profile_image_url !="=>''
			),
			"contain"=>array(),
			"limit"=>8,
			"order"=>"RAND()"
		));
		
		
		$title_for_layout = $cover['CoverPage']['title'];
		
		$this->set(compact("articles","featured_bloggers","cover","title_for_layout"));
		
	}
	
	public function month() {
		
		
	}
	
	
	
}

?>