<?php
App::uses("DailyopsController","Controller");


class WatchThisController extends DailyopsController {

	private $section_id = 99;

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

	}

	public function view() {

		$token = "wt-view-data-".md5($this->request->params['uri']);

		if(($posts = Cache::read($token,"1min")) === false) {

			//get the main post in scope
			$posts['post'] = $this->Dailyop->returnPost(array(
														"Dailyop.dailyop_section_id"=>$this->section_id,
														"Dailyop.uri"=>$this->request->params['uri']),
														$this->isAdmin());


			//do we have the parent post?
			if($posts['post']['Dailyop']['title_episode'] == 1) {

				$posts['parent'] = $posts['post'];

				unset($posts['post']);

			} else {

				$posts['parent'] = $this->Dailyop->returnPost(array("Dailyop.id"=>$posts['post']['Dailyop']['parent_dailyop_id']),$this->isAdmin());

			}



			//now get all the posts excluding the one we are viewing

			$cond = array(

				"Dailyop.dailyop_section_id"=>$this->section_id,
				"Dailyop.parent_dailyop_id"=>$posts['parent']['Dailyop']['id']

			);

			if(!$this->isAdmin()) { 

				$cond[] = "Dailyop.publish_date < NOW()";
				$cond['Dailyop.active'] = 1;

			}

			if(isset($posts['post']['Dailyop']['id'])) {

				$cond['Dailyop.id !='] = $posts['post']['Dailyop']['id'];
				$this->setFacebookMetaData($posts['post']);
			
			} else {

				$this->setFacebookMetaData($posts['parent']);

			}

			$posts['posts'] = $this->Dailyop->find("all",array(
									"conditions"=>$cond,
									"contain"=>array(
										"DailyopMediaItem"=>array(
											"MediaFile",
											"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
											"limit"=>1
										),
										"Tag",
										"DailyopSection"
									),
									"order"=>array(
										"Dailyop.episode_display_weight"=>"ASC"
									)
								));

			Cache::write($token,$posts,"1min");

		}

		$this->set(compact("posts"));

	}

	public function section() {
		
		$this->view = "/Dailyops/section";

		return parent::section();

	}




}