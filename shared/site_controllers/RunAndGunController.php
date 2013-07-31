<?php


App::uses("LocalAppController","Controller");


class RunAndGunController extends LocalAppController {


	public $uses = array("Dailyop","RgVote");

	private $section_id = 103;
	
	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

		$this->theme = "run-and-gun";

		if($this->request['action'] == "view") $this->view = $this->request['action'] = "section";

		$this->set("body_element","rg-body");

	}


	public function section() {
		
		$posts = $this->getPosts();

		$uri = false;

		if(isset($this->request['uri'])) $uri = $this->request['uri'];

		$post = array();

		if(!$uri) {
		
			$post[] = $posts[0];
			
			$post[] = $posts[1];


		} else {

			$post[] = $this->Dailyop->returnPost(array(
				"Dailyop.dailyop_section_id"=>$this->section_id,
				"Dailyop.uri"=>$this->request['uri']
			),1);

		}

		$this->set(compact("post"));



	}

	public function dailyops() {
		


	}


	public function view() {
		


	}

	public function place_vote() {
		
	}

	private function getPosts() {

		$token = "rg-ctrl-posts";

		if(($posts = Cache::read($token, "1min")) === false) {

			$post_ids = $this->Dailyop->find('all',array(
				"conditions"=>array(
					"Dailyop.dailyop_section_id"=>$this->section_id,
				),
				"contain"=>array(
				),
				"order"=>array("Dailyop.publish_date"=>"ASC"),
				"field"=>array("Dailyop.id")
			));

			$posts = array();

			foreach ($post_ids as $k => $v) {
				
				$posts[] = $this->Dailyop->returnPost(array("Dailyop.id"=>$v['Dailyop']['id']),1);

			}

			Cache::write($token, $posts, "1min");

		}

		//check if logged in and attach votes
		if(CakeSession::check("Auth.User.id")) {

			$userVotes = $this->RgVote->getUserVotes(CakeSession::Read("Auth.User.id"));

		}

		$this->set(compact("posts"));

		return $posts;

	}




}