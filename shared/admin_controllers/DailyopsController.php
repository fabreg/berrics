<?php

App::import("Controller","LocalApp");

class DailyopsController extends LocalAppController {

	var $name = 'Dailyops';
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
		$this->Dailyop->recursive = 0;
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['Dailyop'] = array(
		
			"limit"=>"50",
			"order"=>array("Dailyop.publish_date"=>"DESC")
		
		);
		
		
		if(!empty($this->request->params['named']['Dailyop.name'])) {
			
			$this->Paginator->settings['Dailyop']['conditions']['Dailyop.name LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['Dailyop.name'])."%";
			$this->request->data['Dailyop']['name'] = $this->request->params['named']['Dailyop.name'];
			
		}
		if(!empty($this->request->params['named']['Dailyop.sub_title'])) {
			
			$this->Paginator->settings['Dailyop']['conditions']['Dailyop.sub_title LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['Dailyop.sub_title'])."%";
			$this->request->data['Dailyop']['sub_title'] = $this->request->params['named']['Dailyop.sub_title'];
			
		}
		if(!empty($this->request->params['named']['Dailyop.DailyopSection'])) {
			
			$this->Paginator->settings['Dailyop']['conditions']['DailyopSection.id'] = $this->request->params['named']['Dailyop.DailyopSection'];
			$this->request->data['Dailyop']['DailyopSection'] = $this->request->params['named']['Dailyop.DailyopSection'];
			
		}
		
		$dailyopSections = $this->Dailyop->DailyopSection->find("list",array("order"=>array("DailyopSection.name"=>"ASC")));
		
		$this->set(compact("dailyopSections"));
		
		$this->set('dailyops', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dailyop'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('dailyop', $this->Dailyop->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Dailyop->create();
			
			//create the URL
			
			if(!empty($this->request->data['Dailyop']['sub_title'])) {
				
				$this->request->data['Dailyop']['uri'] = Tools::safeUrl($this->request->data['Dailyop']['sub_title']).".html";
				
			} else {
				
				$this->request->data['Dailyop']['uri'] = Tools::safeUrl($this->request->data['Dailyop']['name']).".html";
				
			}
			
			$this->request->data['Dailyop']['user_id'] = $this->user_id_scope;
			$this->request->data['Dailyop']['news_post'] = 0;
			
			$this->request->data['Dailyop']['publish_date'] = $this->request->data['Dailyop']['pub_date']." ".$this->request->data['Dailyop']['pub_time'].":00";
			
			
			if ($this->Dailyop->saveAll($this->request->data)) {
				//$this->Session->setFlash(__('The dailyop has been saved'));
				
				if(!empty($this->request->data['Dailyop']['num_videos'])) {
					
					for($i = 1;$i<=$this->request->data['Dailyop']['num_videos'];$i++) {
						
						$this->Dailyop->DailyopMediaItem->MediaFile->create();
						
						$this->Dailyop->DailyopMediaItem->MediaFile->save(array(

								"media_type"=>"bcove",
								"name"=>$this->request->data['Dailyop']['name']." ".$this->request->data['Dailyop']['sub_title']
								
						));
						
						$this->Dailyop->DailyopMediaItem->create();
						
						$this->Dailyop->DailyopMediaItem->save(array(
									"dailyop_id"=>$this->Dailyop->id,
									"media_file_id"=>$this->Dailyop->DailyopMediaItem->MediaFile->id
								));
						
					}
					
					
				}
				
				if(count($this->request->data['UserAssignedPosts']['user_id'])>0) {
					
					foreach($this->request->data['UserAssignedPosts']['user_id'] as $uap) {
						
						
						$this->Dailyop->UserAssignedPost->create();
							
						$this->Dailyop->UserAssignedPost->save(array(
								"user_id"=>$uap,
								"dailyop_id"=>$this->Dailyop->id,
								"active"=>1
						));
						
					}
					
						
				}
				
				return $this->flash("Dailyops Post Added Successfully","/dailyops/edit/".$this->Dailyop->id);
				
				
			} else {
				$this->Session->setFlash(__('The dailyop could not be saved. Please, try again.'));
			}
		}
		
		if(isset($this->request->params['named']['publish_date'])) {
			
			$this->request->data['Dailyop']['pub_date'] = $this->params['named']['publish_date'];
			
		} else {
			
			$this->request->data['Dailyop']['pub_date'] = date("Y-m-d",strtotime("+30 Days"));
			
		}
		
		$this->request->data['Dailyop']['pub_time'] = "00:00";
		
		$dailyopSections = $this->Dailyop->DailyopSection->returnSelectList();
		$users = $this->Dailyop->User->returnAssignedUserList();
		$this->set(compact('users', 'dailyopSections', 'mediaFiles', 'tags','users'));
	}

	
	public function edit($id = false) {
		
		if(!$id) throw new NotFoundException("Invalid URL");
		
		if($this->request->is("put")) {
			
			
		} else {
			
			$this->request->data = $this->Dailyop->returnPost(array("Dailyop.id"=>$id),$this->isAdmin(),true);
			
		}
		
		$this->setSelects();
		
		
	}
	
	public function handle_tab_save($id) {
		
		if(!$this->request->is("ajax")) {

			return $this->redirect(array("action"=>"edit",$id));

		}

		$element = $this->request->data['Dailyop']['element'];
		
		if($this->request->is("put") || $this->request->is("post")) {
			
			switch($element) {
				
				case "edit-article":

					$this->handle_save_article();
					
				break;
				
				case "edit-general":

					$this->handle_save_general();
					
				break;
				
				case "edit-media":
					
					$this->handle_save_media();
					
				break;
				
				case "edit-meta":
					
					$this->handle_save_meta();
				
				break;
				
				case 'edit-text':
					
					$this->handle_save_text();
				
				break;
				
			}
			
		}
		
		$this->request->data = $this->Dailyop->returnPost(array("Dailyop.id"=>$id),$this->isAdmin(),true);
		
		$this->setSelects();
		
		$this->render("/Elements/dailyops/{$element}");
		
	}
	
	private function handle_save_general() {
		
		$tag_ids = $this->Dailyop->Tag->parseTags($this->request->data['Dailyop']['add_tags']);
		
		if(count($tag_ids)>0) {

			foreach ($tag_ids['Tag'] as $key => $value) {
				
				$chk = $this->Dailyop->DailyopsTag->find("count",array(
						"conditions"=>array(
							"DailyopsTag.dailyop_id"=>$this->request->data['Dailyop']['id'],
							"DailyopsTag.tag_id"=>$value
						),
						"contain"=>array()
					));

				if($chk<=0) {

					$this->Dailyop->DailyopsTag->create();
					$this->Dailyop->DailyopsTag->save(array(
						"tag_id"=>$value,
						"dailyop_id"=>$this->request->data['Dailyop']['id']
					));

				}


			}

		}

		$this->request->data['Dailyop']['publish_date'] = $this->request->data['Dailyop']['pub_date']." ".$this->request->data['Dailyop']['pub_time'].":00";
		
			if($this->request->data['Dailyop']['featured_archive'] == 1) {
				
				$this->Dailyop->updateAll(
					array(
						"featured_archive"=>0
					),
					array(
						"featured_archive"=>1
					)
				);
				
			}
		$this->Dailyop->create();
		$this->Dailyop->id = $this->request->data['Dailyop']['id'];
		if($this->Dailyop->save($this->request->data)) {
		
			$this->Session->setFlash("General info updated");
		
		} else {
		
			$this->Session->setFlash("There was an error while saving");
		
		}
		
	}
	
	private function handle_save_text() {
		
		$this->Dailyop->create();
		$this->Dailyop->id = $this->request->data['Dailyop']['id'];
		if($this->Dailyop->save($this->request->data)) {
		
			$this->Session->setFlash("Text & Misc. updated");
		
		} else {
		
			$this->Session->setFlash("There was an error while saving");
		
		}
		
	}
	
	private function handle_save_media() {
		
		foreach($this->request->data['DailyopMediaItem'] as $v) {
			
			$this->Dailyop->DailyopMediaItem->create();
			$this->Dailyop->DailyopMediaItem->id = $v['id'];
			
			$this->Dailyop->DailyopMediaItem->save($v);
			
		}
		
		if(isset($this->request->data['DailyopMediaItem']['DeleteMediaItem'])) {
			
			$this->Dailyop->DailyopMediaItem->delete($this->request->data['DailyopMediaItem']['DeleteMediaItem']);
			
		}
		
	}
	
	private function handle_save_meta() {
		
		$this->loadModel("Meta");
		$this->loadModel("DailyopsMeta");
		
		if(!empty($this->request->data['Meta']['key']) && !empty($this->request->data['Meta']['val'])) {
			
			$chk = $this->Meta->find("first",array(
						"conditions"=>array(
							"Meta.key"=>$this->request->data['Meta']['key'],
							"Meta.val"=>$this->request->data['Meta']['val']		
						),
						"contain"=>array()
					));
			
			if(!isset($chk['Meta']['id'])) {
				
				$this->Meta->create();
				
				$this->Meta->save(array(

					"key"=>strtolower($this->request->data['Meta']['key']),
					"val"=>strtolower($this->request->data['Meta']['val'])
						
				));
				
				$chk['Meta']['id'] = $this->Meta->id;
				
			}
			
			$this->DailyopsMeta->create();
			$this->DailyopsMeta->save(array(
						"meta_id"=>$chk['Meta']['id'],
						"dailyop_id"=>$this->request->data['Dailyop']['id']
					));
			
			$this->Session->setFlash("Meta tag added successfully");
			
		}
		
		if(isset($this->request->data['Meta']['DeleteMeta'])) {
			
			$this->Dailyop->query(
				"DELETE FROM dailyops_metas WHERE id = '{$this->request->data['Meta']['DeleteMeta']}'"
			);
		
			$this->Session->setFlash("Meta item removed");
			
		}
		
	}
	
	private function handle_save_article() {
		
		$this->loadModel("DailyopTextItem");
	
		if(count($this->request->data['DailyopTextItem'])>0) {
			
			foreach($this->request->data['DailyopTextItem'] as $k=>$v) {
				
				$this->DailyopTextItem->create();
				
				$this->DailyopTextItem->id = $v['id'];
				
				$this->DailyopTextItem->save($v);
				
				
			}
			
		}
		
		if(isset($this->request->data['DailyopTextItem']['RemoveTextItem'])) {
			
			$this->DailyopTextItem->delete($this->request->data['DailyopTextItem']['RemoveTextItem']);
			
		}
		
		
		if(isset($this->request->data['DailyopTextItem']['RemoveMedia'])) {
				
			$this->DailyopTextItem->create();
			
			$this->DailyopTextItem->id = $this->request->data['DailyopTextItem']['RemoveMedia'];
			
			$this->DailyopTextItem->save(array(
					
				"media_file_id"=>""
					
			));
			
				
		}
		
		$this->Session->setFlash("Text items updated");
		
		
	}
	
	public function handle_remove_tag($post_id=false,$tag_id=false) {

		if(!$post_id || !$tag_id) throw new NotFoundException("Invalid Link");

		$this->Dailyop->query("delete from dailyops_tags where dailyop_id={$post_id} AND tag_id={$tag_id}");

		die(true);

	}
	
	private function setSelects() {
		
		$this->request->data['Dailyop']['pub_date'] = date('Y-m-d',strtotime($this->request->data['Dailyop']['publish_date']));
		
		$this->request->data['Dailyop']['pub_time'] = date("H:i",strtotime($this->request->data['Dailyop']['publish_date']));
		$users = $this->Dailyop->User->returnAssignedUserList();
		$dailyopSections = $this->Dailyop->DailyopSection->returnSelectList();
		$unifiedStores = $this->Dailyop->UnifiedStore->find("list",array("order"=>array("UnifiedStore.shop_name"=>"ASC")));
		//$mediaFiles = $this->Dailyop->MediaFile->find('list');
		
		$themes = $this->returnThemes();
		
		$episodes = $this->returnTitleEpisodes();
		
		$this->set(compact('users', 'dailyopSections', 'mediaFiles',"themes","episodes","unifiedStores"));
		
	}
	
	function edit___old($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid dailyop'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			//die(pr($this->request->data));
			
			$this->request->data['Tag'] = $this->Dailyop->Tag->parseTags($this->request->data['Tag']['Tag']);
			
			//fix the publish date
			
			$this->request->data['Dailyop']['publish_date'] = $this->request->data['Dailyop']['pub_date']." ".$this->request->data['Dailyop']['pub_time'].":00";
			
			//safe uri
			//$this->request->data['Dailyop']['uri'] = Tools::safeUrl($this->request->data['Dailyop']['uri']);
			
			//are we setting a featured post?
			
			if($this->request->data['Dailyop']['featured_archive'] == 1) {
				
				$this->Dailyop->updateAll(
					array(
						"featured_archive"=>0
					),
					array(
						"featured_archive"=>1
					)
				);
				
			}
			
			//ensure that the news is a hidden post
			if($this->request->data['Dailyop']['news_post'] == 1) {
				
				$this->request->data['Dailyop']['hidden'] = 1;
				$this->request->data['Dailyop']['promo'] = 1;
				
			}
			
			$redir_self = false;
			
			if(isset($this->request->data['AddNewTextBlock'])) {
				
				$this->Dailyop->DailyopTextItem->addNewTextBlock($this->request->data['Dailyop']['id']);
				
				$redir_self = true;
				
			}
			
			$this->Dailyop->id = $this->request->data['Dailyop']['id'];
			
			if ($this->Dailyop->saveAll($this->request->data)) {
				
				if(isset($this->request->data['DeleteTextItem'])) {
				
					foreach($this->request->data['DeleteTextItem'] as $kk=>$vv) {
						
						$this->Dailyop->DailyopTextItem->delete($kk);
						
					}
					
					$redir_self = true;
				}
				
				
				if(isset($this->request->data['AttachMedia'])) {
					
					foreach($this->request->data['AttachMedia'] as $kk=>$vv) {
						
						return $this->redirect(array("controller"=>"media_files","action"=>"attach_media","DailyopTextItem","media_file_id",$kk,base64_encode($this->request->here)));
						
					}
					
					
				}
				
				if(isset($this->request->data['RemoveMediaItem'])) {
					
					foreach($this->request->data['RemoveMediaItem'] as $kk=>$vv) {
						
						$this->Dailyop->DailyopTextItem->removeMediaItem($kk);
						
					}
					
					$redir_self = true;
					
				}
					
				if($redir_self) {
					
					$this->request->data['Dailyop']['postback'] = base64_encode("/dailyops/edit/".$this->request->data['Dailyop']['id']."/#text-items");
					
				}
					
				$this->Session->setFlash(__('The post has been saved'));
				
				if(isset($this->request->data['Dailyop']['postback'])) {
					
					return $this->flash("Updated",base64_decode($this->request->data['Dailyop']['postback']));
				}
				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Dailyop->returnPost(array("Dailyop.id"=>$id),$this->isAdmin(),true);
		}
		
		//fix the date stuff
		
		$this->request->data['Dailyop']['pub_date'] = date('Y-m-d',strtotime($this->request->data['Dailyop']['publish_date']));
		
		$this->request->data['Dailyop']['pub_time'] = date("H:i",strtotime($this->request->data['Dailyop']['publish_date']));
		
		
		$users = $this->Dailyop->User->returnAssignedUserList();
		$dailyopSections = $this->Dailyop->DailyopSection->returnSelectList();
		$unifiedStores = $this->Dailyop->UnifiedStore->find("list",array("order"=>array("UnifiedStore.shop_name"=>"ASC")));
		//$mediaFiles = $this->Dailyop->MediaFile->find('list');
		
		$themes = $this->returnThemes();
		
		$episodes = $this->returnTitleEpisodes();
		
		$this->set(compact('users', 'dailyopSections', 'mediaFiles',"themes","episodes","unifiedStores"));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dailyop'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Dailyop->delete($id)) {
			$this->Session->setFlash(__('Dailyop deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Dailyop was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	
	public function attach_media($id = false,$model = "DailyopMediaItem",$extra_id = false) {
		
		$this->loadModel("MediaFile");
		
		if(!$id) throw new NotFoundException("Invalid URL");
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['MediaFile']['order'] = array("MediaFile.modified"=>"DESC");
		
		$media = $this->paginate("MediaFile");
		
		$post = $this->Dailyop->returnPost(array("Dailyop.id"=>$id),true,true);
		
		$this->set(compact("post","media"));
		
		if($this->request->is("ajax")) {
			
			$this->render("/Elements/dailyops/attach_media_index");
			
		}
		
	}
	
	public function handle_attach_media() {
		
		
		if($this->request->is("post")) {
			
			$model = $this->request->data['AttachMedia']['model'];
			
			$this->loadModel($model);
			
			foreach($this->request->data['AttachMedia']['media_file_id'] as $id) {
				
				$this->{$model}->create();
				
				$d = array(
					"media_file_id"=>$id		
				);
				
				switch($model) {
					
					case "DailyopMediaItem":
						$d['dailyop_id'] = $this->request->data['AttachMedia']['dailyop_id'];
						$d['display_weight'] = 99;
					break;
					case "DailyopTextItem":
						$this->{$model}->id = $this->request->data['AttachMedia']['extra_id'];
					break;
					
				}
				
				$this->{$model}->save($d);
				
				$this->Session->setFlash("Media attached succesfully");
				
				$url = array(
					"action"=>"edit",
					$this->request->data['AttachMedia']['dailyop_id'],
					"?"=>array(
						"tab"=>"media"		
					)		
				);
				
				$this->redirect($url);
				
			}
			
		}
		
	}
	
	public function handle_remove_media($id = false,$model = false) {
		
		
		
	}
	
	public function media_files($id = false) {
		
		if(!$id) {
			
			
			
		}
		
		//get the media files
		$mediaFiles = $this->Dailyop->DailyopMediaItem->find("all",array(
		
			"conditions"=>array(
				"DailyopMediaItem.dailyop_id"=>$id
			),
			"contain"=>array("MediaFile"),
			"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
		
		));
		
		$this->set(compact("mediaFiles"));
		
		
	}
	
	public function updateMediaItemWeight($media_item_id = false,$display_weight = false) {
		
		if(!$media_item_id || !$display_weight) {
			
			die("We fucked up!");
			
		}
		
		
		//lets update the stuff
		$this->Dailyop->DailyopMediaItem->id = $media_item_id;
		
		$this->Dailyop->DailyopMediaItem->save(array(
		
			"display_weight"=>$display_weight
		
		));
		
		die("Media Item Updated Successfullys");
		
	}
	
	public function remove_media_item($id = false) {
		
		if(!$id) {
			
			die("Invalid URL");
			
		}
		
		$media_item = $this->Dailyop->DailyopMediaItem->find("first",array(
		
			"conditions"=>array(
				"DailyopMediaItem.id"=>$id
			),
			"contain"=>array()	
		
		));
		
		if($media_item) {
			
			$this->Dailyop->DailyopMediaItem->delete($id);
			
			die("Media Item Removed From Dailyop's Post");
			
		} else {
			
			die("Item doesn't exist?");
			
		}
		
		
		
	}
	
	public function add_text_item($id = false) {
		
		$this->Dailyop->DailyopTextItem->addNewTextBlock($id);
		
		$this->redirect(array(

			"action"=>"edit",
			$id,
			"?"=>array(
				"tab"=>"article"		
			)
				
		));
		
	}
	
	public function ajax_add_meta() {
		
		if(count($this->request->data)>0) {
			
			$this->loadModel("Meta");
			
			$meta_id = $this->Meta->addMeta($this->request->data['NewMeta']['key'],$this->request->data['NewMeta']['val']);

			$this->Dailyop->id = $this->request->data['NewMeta']['dailyop_id'];
			
			$this->request->data['Meta'][] = $meta_id;
			
			
			
			$this->Dailyop->save(array(
				
				"Meta"=>$this->request->data['Meta']
			
			));

			die("It fucking worked!");
			
		} else {
			
			die("You fucked up");
			
		}
		
	}
	
	
	public function ajax_list_metas($id = false) {
		
		$dailyops = $this->Dailyop->find("first",array(
		
			"conditions"=>array(
				"Dailyop.id"=>$id
			),
			"contain"=>array(
				"Meta"
			)
		
		));

		$this->set(compact("dailyops"));
		
	}
	
	
	public function ajax_remove_meta($id) {
		
		$this->Dailyop->query(
			"DELETE FROM dailyops_metas WHERE id = '{$id}'"
		);
		
		die("We completed");
		
	}
	
	public function dupe_uri_check($dailyop_id,$section_id,$uri) {
		
		$check = $this->Dailyop->find("count",array(
		
			"conditions"=>Array(
				"Dailyop.id !="=>$dailyop_id,
				"Dailyop.dailyop_section_id"=>$section_id,
				"Dailyop.uri"=>$uri
			),
			"contain"=>array()
		
		));
		
		if($check>0) {
			
			$this->set("check","0");
			return false;
			
		} else {
			
			$this->set("check","1");
			return true;
			
		}
		
		
	}
	
	private function returnThemes() {
		//get the themes from the dev folder
		
		$path = "/home/sites/berrics.v3/site/public_html/app/webroot/theme";
		
		$scan = scandir($path);
		
		foreach($scan as $k=>$v) if(!is_dir($path."/".$v) || ($v=='..' || $v=='.')) unset($scan[$k]);
		
		$dir = array();
		
		foreach($scan as $k=>$v) $dir[$v]=$v;
		
		return $dir;
		
		
	}
	
	private function returnTitleEpisodes() {
		
		$posts = $this->Dailyop->find("all",array(
		
			"conditions"=>array(
		
				"Dailyop.title_episode"=>1		
		
			),
			"contain"=>array(
			
				"DailyopSection"	
			
			)
		
		));
		
		
		$o = array();
		
		foreach($posts as $p) {
			
			$label = $p['DailyopSection']['name'].": ";
			
			$label .= $p['Dailyop']['name'];
			
			if(!empty($p['Dailyop']['sub_title'])) {
				
				
				$label .= " - ".$p['Dailyop']['sub_title'];
				
				
			}
			
			
			$o[$p['Dailyop']['id']] = $label;
			
		}
		
		return $o;
		
	}
	
	public function add_news_post() {
		
		if(count($this->request->data)>0) {
			
			$this->request->data['Dailyop']['publish_date'] = $this->request->data['Dailyop']['pub_date']." 00:00:00";
			$this->request->data['Dailyop']['dailyop_section_id'] = 65;
			$this->request->data['Dailyop']['uri'] = Tools::safeUrl($this->request->data['Dailyop']['name']).".html";
			$this->request->data['Dailyop']['news_post'] = 1;
			$this->request->data['Dailyop']['active'] = 0;
			$this->request->data['Dailyop']['hidden'] = 1;
			$this->request->data['Dailyop']['promo'] = 1;
			$this->request->data['Dailyop']['user_id'] = $this->user_id_scope;
			
			$this->Dailyop->save($this->request->data);
			
			$cb = "/dailyops/manage_news";
			
			if(isset($this->request['named']['cb'])) {
				
				$cb = base64_decode($this->request['named']['cb']);
				
			}
			
			return $this->redirect($cb);
			
		}
		
		if(isset($this->request['named']['publish_date'])) {
			
			$this->request->data['Dailyop']['pub_date'] = $this->request['named']['publish_date'];
			
		}
		
	}
	
	
	public function manage_news() {
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['Dailyop'] = array(
		
			"conditions"=>array(
				"Dailyop.news_post"=>1
			),
			"order"=>array(
				"Dailyop.publish_date"=>"DESC",
				"Dailyop.display_weight"=>"ASC"
			),
			"limit"=>50	
			
		
		);
		
		
		if(isset($this->request->params['named']['search'])) {
			
			if(isset($this->request->params['named']['Dailyop.misc_category']) && !empty($this->request->params['named']['Dailyop.misc_category'])) {
				
				$this->request->data['Dailyop']['misc_category'] = $this->Paginator->settings['Dailyop']['conditions']['Dailyop.misc_category'] = $this->request->params['named']['Dailyop.misc_category'];
				 
			}
			
			if(isset($this->request->params['named']['Dailyop.publish_date']) && !empty($this->request->params['named']['Dailyop.publish_date'])) {
				
				$this->Paginator->settings['Dailyop']['conditions'][] = "DATE(Dailyop.publish_date) = '{$this->request->params['named']['Dailyop.publish_date']}'";
				
				$this->request->data['Dailyop']['publish_date'] = $this->request->params['named']['Dailyop.publish_date'];
				
			}
			
		}
		
		
		
		$this->set("posts",$this->paginate("Dailyop"));
		
		
	}
	
	public function search_news() {
		
		$url = array(
		
			"action"=>"manage_news",
			"search"=>true
		);
		
		
		foreach($this->request->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
		
		return $this->redirect($url);
		
	}
	
	public function updateDisplayWeight() {
		//die(pr($this->request->data));	
		$this->Dailyop->id = $this->request->data['Dailyop']['id'];
		
		$this->Dailyop->save(array(
			"display_weight"=>$this->request->data['Dailyop']['display_weight']
		));
		
		return $this->redirect(base64_decode($this->request->data['Dailyop']['postback']));
		
		
	}
	public function updateBestOfWeight() {
		//die(pr($this->request->data));	
		$this->Dailyop->id = $this->request->data['Dailyop']['id'];
		
		$this->Dailyop->save(array(
			"best_of_weight"=>$this->request->data['Dailyop']['best_of_weight'],
			"best_of"=>$this->request->data['Dailyop']['best_of']
		));
		
		return $this->redirect(base64_decode($this->request->data['Dailyop']['postback']));

	}
	
	public function assigned() {
		
		$ids = $this->Dailyop->getAssignedPostIds();
		
		$posts = array();
		
		foreach($ids as $id) {
			
			$posts[] = $this->Dailyop->validatePostStatus($this->Dailyop->returnPost(array("Dailyop.id"=>$id['Dailyop']['id']),$this->isAdmin(),false));
			
		}
		
		$this->set(compact("posts"));
		
	}

	
	
	
	
	
	
	
	
	
	
	
}