<?php

App::uses("DailyopsController","Controller");

class MtnDewController extends DailyopsController {

	public $uses = array("Dailyops");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->theme = "mtn-dew";

		if(isset($_GET['uri'])) {

			$_GET['uri'] = trim($_GET['uri'],"/");

			$uri = explode("/", $_GET['uri']);
			
			$this->request->params['section'] = $uri[0];
			$this->request->params['uri'] = $uri[1];
			$this->request->params['action'] = "view";

		}

		if($this->request->params['action'] == "view") {

			$this->request->params['action'] = $this->view = "section";

			$this->setPost();

		}

	}

	public function setPost() {
		
		$this->loadModel('Dailyop');
		
		$post = $this->Dailyop->returnPost(array(

					"Dailyop.uri"=>$this->request->params['uri'],
					"DailyopSection.uri"=>$this->request->params['section']

				),$this->isAdmin());

		$this->set(compact("post"));

		$this->set("top_element","mtn-dew-post");

	}

	public function ___section() {
		
		$this->loadModel('Dailyop');
		
		$token = "mtn-dew-page";

		if(($posts = Cache::read($token,"1min")) === false) {

			$post_ids = $this->Dailyop->DailyopsTag->find("all",array(
						"fields"=>array(
							"DailyopsTag.dailyop_id"
						),
						"conditions"=>array(
							"DailyopsTag.tag_id"=>3388
						),
						"contain"=>array()
					));

			$post_ids = Set::extract("/DailyopsTag/dailyop_id",$post_ids);

			
			$posts = $this->Dailyop->find("all",array(
						"conditions"=>array(
							"Dailyop.id"=>$post_ids,
							"Dailyop.active"=>1,
							"Dailyop.publish_date < '".AppModel::awsNow()."'"
						),
						"contain"=>array(
								"DailyopMediaItem"=>array(
									
									"MediaFile"=>array(
				
									),
									"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
								),
								"User"=>array(

								),
								"DailyopSection"=>array(

								),
								"Tag"=>array(

									"User"
								),
								"Meta",
								"DailyopTextItem"=>array(
									"MediaFile"=>array(

									),
									"order"=>array("DailyopTextItem.display_weight"=>"ASC")
								)
						
						),
						"order"=>array("Dailyop.publish_date"=>"DESC")
					));

		}

		$this->set(compact("posts"));

	}

	public function section() {
		
		$ids = $this->getDewTags();

		$this->Paginator->settings = array();

		$this->Paginator->settings['Dailyop'] = array(

					"conditions"=>array(
						"Dailyop.id"=>$ids,
						"Dailyop.publish_date < NOW()",
						"Dailyop.active"=>1
					),
					"contain"=>array(
						"DailyopMediaItem"=>array(
							"MediaFile",
							"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
							"limit"=>1
						),
						"DailyopTextItem"=>array(
							"MediaFile",
							"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
							"limit"=>1
						),
						"DailyopSection",
						"Tag"
					),
					"order"=>array("Dailyop.publish_date"=>"DESC"),
					"limit"=>20

				);


		$posts = $this->paginate("Dailyop");

		//die(pr($posts));


		$this->set(compact("posts"));

		//$this->view = "section";

	}

	private function getDewTags() {

		$this->loadModel('Tag');
		
		$ids = $this->Tag->find("all",array(
					"fields"=>array(
						"Tag.id"
						
					),
					"conditions"=>array(
						"Tag.name"=>array(
							"PAUL RODRIGUEZ",
							"THEOTIS BEASLEY",
							"KEELAN DADD",
							"AM TEAM",
							"BOO JOHNSON",
							"NICK TUCKER",
							"JUSTIN SCHULTE",
							"CODY DAVIS",
							"CARLOS ZARAZUA",
							"CHRIS COLBOURN",
							"JORDAN MAXHAM",
							"TRAVIS GLOVER",
							"TULIO OLIVEIRA",
							"MIKE FRANKLIN",
							"FLOW TEAM",
							"REEMO PEARSON",
							"URIEL ESQUIVITAS",
							"DAVID HAFFSTEINSSON",
							"MILES CANEVELLO",
							"TOM ROHRER",
							"mtn dew"
						)
					),
					"contain"=>array(
						"Dailyop"=>array(
							"fields"=>array("Dailyop.id")
						)
					)
				));
		
		$ids = Set::extract("/Dailyop/id",$ids);

		return $ids;

	}


}
