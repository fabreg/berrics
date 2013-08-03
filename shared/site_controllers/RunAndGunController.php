<?php


App::uses("LocalAppController","Controller");


class RunAndGunController extends LocalAppController {


	public $uses = array("Dailyop","RgVote");

	private $section_id = 103;

	private $userVotes = false;
	
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
			


		} else {

			$post[] = $this->Dailyop->returnPost(array(
				"Dailyop.dailyop_section_id"=>$this->section_id,
				"Dailyop.uri"=>$this->request['uri']
			),$this->isAdmin());

			$post = $this->attachScores($post);

		}

		if(!isset($post[0]['Dailyop']['id'])) {

			$this->redirect("/run-and-gun");

		}

		$this->set(compact("post"));



	}

	public function dailyops() {

		$dateIn = date("Y-m-d");

		$posts = $this->getPosts();

		$post = $this->dailyopsPosts();

		$this->set(compact("post","dateIn","posts"));

		$this->view = "section";

	}

	private function dailyopsPosts() {

		$dates = array(date("Y-m-d"));

		if(strtoupper(date("D")) == "SUN") $dates[] = date("Y-m-d",strtotime("-1 Days"));

		$token = "rg-dops-".md5(serialize($dates));

		if (($post = Cache::read($token, "1min")) === false) {
			
			$post = array();

			$post_ids = $this->Dailyop->find('all',array(
						"conditions"=>array(
							"DATE(Dailyop.publish_date)"=>$dates,
							"Dailyop.dailyop_section_id"=>$this->section_id
						),
						"contain"=>array(),
						"order"=>array("Dailyop.publish_date"=>"DESC"),
						"fields"=>array("Dailyop.id")
					));

			foreach($post_ids as $k=>$v) {

				$post[] = $this->Dailyop->returnPost(array("Dailyop.id"=>$v['Dailyop']['id']),$this->isAdmin());

			}

			Cache::write($token, $post, "1min");

		}

		$post = $this->attachScores($post);

		return $post;

	}


	public function view() {
		


	}

	public function place_vote() {
		
		if(!CakeSession::check("Auth.User.id")) die("nope");

		if($this->request->is("post") || $this->request->is("put")) {
		
			$this->RgVote->placeVote(CakeSession::read("Auth.User.id"), $post_id = $this->request->data['RgVote']['dailyop_id'], $this->request->data['RgVote']['score']);
			
			die("1");

		}

		die("0");

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

		$posts = $this->attachScores($posts);

		//die(pr($posts));

		$this->set(compact("posts"));

		return $posts;

	}

	private function attachScores($posts) {

		//check if logged in and attach votes
		if(CakeSession::check("Auth.User.id")) {

			if(!$this->userVotes) $this->userVotes = $this->RgVote->getUserVotes(CakeSession::read("Auth.User.id"));

			//die(print_r($userVotes));

			foreach($posts as $k=>$v) {

				$vote = Set::extract("/RgVote[dailyop_id={$v['Dailyop']['id']}]", $this->userVotes);

				if(count($vote)>0) {

					$posts[$k]['RgVote'] = $vote[0]['RgVote'];

				}

			}

		}

		return $posts;

	}




}