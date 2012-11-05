<?php

App::import("Controller","LocalApp");

class TagsController extends LocalAppController {



	var $name = 'Tags';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}

	public function search() {
		
		if(count($this->request->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"search"=>true
				);
				
				
				foreach($this->request->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						$url[$k.".".$kk]=urlencode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}

	}

	function index() {

		$this->Tag->recursive = 0;

		$this->Paginator->settings = array();

		$this->Paginator->settings['Tag'] = array(
			"order"=>array("Tag.name"=>"ASC"),
			"contain"=>array(
				"User",
				"Brand"
			)
		);


		if(isset($this->request->params['named']['search'])) {

			if (!empty($this->request->params['named']['Tag.name'])) {
				
				$this->Paginator->settings['Tag']['conditions']['Tag.name LIKE'] = 
						"%".str_replace(" ","%",urldecode($this->request->params['named']['Tag.name']))."%";

				$this->request->data['Tag']['name'] = urldecode($this->request->params['named']['Tag.name']);

			}

		}


		$this->set('tags', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid tag'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('tag', $this->Tag->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Tag->create();
			if ($this->Tag->save($this->request->data)) {
				$this->Session->setFlash(__('The tag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
			}
		}
		
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid tag'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Tag->save($this->request->data)) {
				$this->Session->setFlash(__('The tag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Tag->find('first',array(
						"conditions"=>array("Tag.id"=>$id),
						"contain"=>array(
							"User"
						)
				));
		}
		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for tag'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tag->delete($id)) {
			$this->Session->setFlash(__('Tag deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Tag was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function attach_user($tag_id = false) {
		
		if($this->request->is("post") || $this->request->is("put")) {
		
			$this->Tag->create();

			$this->Tag->id = $this->request->data['Tag']['id'];

			$this->Tag->save(array(
				"user_id"=>$this->request->data['Tag']['user_id']
			));

			$cb = "/tag/edit/".$tag_id;

			if(isset($this->request->params['named']['cb'])) $cb = base64_decode($this->request->params['named']['cb']);

			$this->redirect($cb);
			
		}

		$tag = $this->Tag->find('first',array(
			"conditions"=>array('Tag.id'=>$tag_id),
			"contain"=>array()
		));

		$this->set(compact("tag"));
	}

	public function remove_user($tag_id = false) {

		if(!$tag_id) throw new NotFoundException("Invalid Link");

		$this->Tag->create();
		$this->Tag->id = $tag_id;

		$this->Tag->save(array(
				"user_id"=>""
			));


		$cb = "/tags/edit/{$tag_id}";

		if(isset($this->request->params['named']['cb'])) $cb = base64_decode($this->request->params['named']['cb']);

		return $this->redirect($cb);

	}

	public function attach_brand($tag_id = false) {
		


		if($this->request->is("post") || $this->request->is("put")) {
		
			
		
		}


		$tag = $this->Tag->find('first',array(
			"conditions"=>array('Tag.id'=>$tag_id),
			"contain"=>array()
		));

		$this->set(compact("tag"));


	}




	public function disambig($user_id = false) {
		
		if($this->request->is("post") || $user_id) {
		
			if(isset($this->request->data['Tag']['user_id'])) $user_id = $this->request->data['Tag']['user_id'];

			$res = $this->check_disambig($user_id);

			$this->set(compact("res"));
		
		}






	}

	private function check_disambig($user_id) {
		
		$tables = array("aberrican_originals",
						"articles",
						"bangyoself_entries",
						"batb_events",
						"batb_scores",
						"batb_votes",
						"berrics_records_items",
						"bq_reports",
						"canteen_batches",
						"canteen_order_notes",
						"canteen_orders",
						"canteen_products",
						"canteen_promo_codes",
						"dailyops",
						"dailyops_users",
						"gateway_accounts",
						"gateway_transactions",
						"media_file_uploads",
						"media_files",
						"media_files_users",
						"mediahunt_media_items",
						"ondemand_titles",
						"photoshoot_confirmations",
						"reports",
						"sls_votes",
						"tags",
						"tags_users",
						"unified_shops",
						"user_addresses",
						"user_assigned_posts",
						"user_billing_profiles",
						"user_contest_entries",
						"user_ondemand_profiles",
						"user_passwd_resets",
						"user_permissions",
						"user_profile_images",
						"user_profiles",
						"user_sponsors",
						"younited_nations_posse_members",
						"younited_nations_posses",
						"younited_nations_votes"
						);

		$res = array();

		foreach($tables as $v) {

			$m = Inflector::classify($v);

			$this->loadModel($m);

			$c = $this->{$m}->find('count',array(
					"conditions"=>array(
						"{$m}.user_id"=>$user_id
					),
					"contain"=>array()
				));
			
			if($c>0) {

				$res[$m]['count'] = $c;
				$res[$m]['results'] = $this->{$m}->find('all',array(
											"conditions"=>array(
												"{$m}.user_id"=>$user_id
											),
											"contain"=>array()
										));
			}
		}

		return $res;

	}




}