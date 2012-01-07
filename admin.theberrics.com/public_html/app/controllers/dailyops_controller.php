<?php

App::import("Controller","AdminApp");

class DailyopsController extends AdminAppController {

	var $name = 'Dailyops';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	public function search() {
		
		if(count($this->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"search"=>true
				);
				
				
				foreach($this->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						$url[$k.".".$kk]=urlencode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}
		

		
		
	}
	
	function index() {
		$this->Dailyop->recursive = 0;
		
		$this->paginate['Dailyop'] = array(
		
			"limit"=>"50",
			"order"=>array("Dailyop.publish_date"=>"DESC")
		
		);
		
		
		if(isset($this->params['named']['Dailyop.name'])) {
			
			$this->paginate['Dailyop']['conditions']['Dailyop.name LIKE'] = "%".str_replace(" ","%",$this->params['named']['Dailyop.name'])."%";
			$this->data['Dailyop']['name'] = $this->params['named']['Dailyop.name'];
			
		}
		if(isset($this->params['named']['Dailyop.sub_title'])) {
			
			$this->paginate['Dailyop']['conditions']['Dailyop.sub_title LIKE'] = "%".str_replace(" ","%",$this->params['named']['Dailyop.sub_title'])."%";
			$this->data['Dailyop']['sub_title'] = $this->params['named']['Dailyop.sub_title'];
			
		}
		if(isset($this->params['named']['Dailyop.DailyopSection'])) {
			
			$this->paginate['Dailyop']['conditions']['DailyopSection.id'] = $this->params['named']['Dailyop.DailyopSection'];
			$this->data['Dailyop']['DailyopSection'] = $this->params['named']['Dailyop.DailyopSection'];
			
		}
		
		
		$dailyopSections = $this->Dailyop->DailyopSection->find("list",array("order"=>array("DailyopSection.name"=>"ASC")));
		
		$this->set(compact("dailyopSections"));
		
		$this->set('dailyops', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dailyop', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('dailyop', $this->Dailyop->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Dailyop->create();
			
			//create the URL
			
			if(!empty($this->data['Dailyop']['sub_title'])) {
				
				$this->data['Dailyop']['uri'] = Tools::safeUrl($this->data['Dailyop']['sub_title']).".html";
				
			} else {
				
				$this->data['Dailyop']['uri'] = Tools::safeUrl($this->data['Dailyop']['name']).".html";
				
			}
			
			
			
			$this->data['Dailyop']['user_id'] = $this->user_id_scope;
			$this->data['Dailyop']['news_post'] = 0;
			
			$this->data['Dailyop']['publish_date'] = date("Y-m-d",strtotime("+20 Days"));
			
			if ($this->Dailyop->save($this->data)) {
				//$this->Session->setFlash(__('The dailyop has been saved', true));
				
				return $this->flash("Dailyops Post Added Successfully","/dailyops/edit/".$this->Dailyop->id);
				
				
			} else {
				$this->Session->setFlash(__('The dailyop could not be saved. Please, try again.', true));
			}
		}
		$dailyopSections = $this->Dailyop->DailyopSection->returnSelectList();
		$this->set(compact('users', 'dailyopSections', 'mediaFiles', 'tags'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dailyop', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$this->data['Tag'] = $this->Dailyop->Tag->parseTags($this->data['Tag']['Tag']);
			
			//fix the publish date
			
			$this->data['Dailyop']['publish_date'] = $this->data['Dailyop']['pub_date']." ".$this->data['Dailyop']['pub_time'].":00";
			
			//safe uri
			//$this->data['Dailyop']['uri'] = Tools::safeUrl($this->data['Dailyop']['uri']);
			
			//are we setting a featured post?
			
			if($this->data['Dailyop']['featured_archive'] == 1) {
				
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
			if($this->data['Dailyop']['news_post'] == 1) {
				
				$this->data['Dailyop']['hidden'] = 1;
				$this->data['Dailyop']['promo'] = 1;
				
			}
			
			$redir_self = false;
			
			if(isset($this->data['AddNewTextBlock'])) {
				
				$this->Dailyop->DailyopTextItem->addNewTextBlock($this->data['Dailyop']['id']);
				
				$redir_self = true;
				
			}
			
			$this->Dailyop->id = $this->data['Dailyop']['id'];
			
			if ($this->Dailyop->saveAll($this->data)) {
				
				if(isset($this->data['DeleteTextItem'])) {
				
					foreach($this->data['DeleteTextItem'] as $kk=>$vv) {
						
						$this->Dailyop->DailyopTextItem->delete($kk);
						
					}
					
					$redir_self = true;
				}
				
				
				if(isset($this->data['AttachMedia'])) {
					
					foreach($this->data['AttachMedia'] as $kk=>$vv) {
						
						return $this->redirect(array("controller"=>"media_files","action"=>"attach_media","DailyopTextItem","media_file_id",$kk,base64_encode($this->here)));
						
					}
					
					
				}
				
				if(isset($this->data['RemoveMediaItem'])) {
					
					foreach($this->data['RemoveMediaItem'] as $kk=>$vv) {
						
						$this->Dailyop->DailyopTextItem->removeMediaItem($kk);
						
					}
					
					$redir_self = true;
					
				}
					
				if($redir_self) {
					
					$this->data['Dailyop']['postback'] = base64_encode("/dailyops/edit/".$this->data['Dailyop']['id']."/#text-items");
					
				}
					
				$this->Session->setFlash(__('The post has been saved', true));
				
				if(isset($this->data['Dailyop']['postback'])) {
					
					return $this->flash("Updated",base64_decode($this->data['Dailyop']['postback']));
				}
				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Dailyop->returnPost(array("Dailyop.id"=>$id),$this->isAdmin(),true);
		}
		
		//fix the date stuff
		
		$this->data['Dailyop']['pub_date'] = date('Y-m-d',strtotime($this->data['Dailyop']['publish_date']));
		
		$this->data['Dailyop']['pub_time'] = date("H:i",strtotime($this->data['Dailyop']['publish_date']));
		
		
		//$users = $this->Dailyop->User->userSelectList();
		$dailyopSections = $this->Dailyop->DailyopSection->returnSelectList();
		$unifiedStores = $this->Dailyop->UnifiedStore->find("list",array("order"=>array("UnifiedStore.shop_name"=>"ASC")));
		//$mediaFiles = $this->Dailyop->MediaFile->find('list');
		
		$themes = $this->returnThemes();
		
		$episodes = $this->returnTitleEpisodes();
		
		$this->set(compact('users', 'dailyopSections', 'mediaFiles',"themes","episodes","unifiedStores"));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for dailyop', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Dailyop->delete($id)) {
			$this->Session->setFlash(__('Dailyop deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Dailyop was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	public function attach_media($id) {
		
		//get the daily ops post
		
		$dop = $this->Dailyop->find("first",array(
		
			"conditions"=>array(
				"Dailyop.id"=>$id
			),
			"contain"=>array(
				"DailyopSection"
			)
		
		));
		
		
		
		$this->set(compact("dop"));

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
	
	public function ajax_add_meta() {
		
		if(count($this->data)>0) {
			
			$this->loadModel("Meta");
			
			$meta_id = $this->Meta->addMeta($this->data['NewMeta']['key'],$this->data['NewMeta']['val']);

			$this->Dailyop->id = $this->data['NewMeta']['dailyop_id'];
			
			$this->data['Meta'][] = $meta_id;
			
			
			
			$this->Dailyop->save(array(
				
				"Meta"=>$this->data['Meta']
			
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
		
		$path = "/home/sites/berrics.dev/theberrics.com/public_html/app/webroot/theme";
		
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
		
		if(count($this->data)>0) {
			
			$this->data['Dailyop']['publish_date'] = date("Y-m-d 00:00:00",strtotime("+30 Days"));
			$this->data['Dailyop']['dailyop_section_id'] = 65;
			$this->data['Dailyop']['uri'] = Tools::safeUrl($this->data['Dailyop']['name']).".html";
			$this->data['Dailyop']['news_post'] = 1;
			$this->data['Dailyop']['active'] = 0;
			$this->data['Dailyop']['hidden'] = 1;
			$this->data['Dailyop']['promo'] = 1;
			$this->data['Dailyop']['user_id'] = $this->user_id_scope;
			
			$this->Dailyop->save($this->data);
			
			return $this->redirect("/dailyops/manage_news");
			
		}
		
		
	}
	
	
	public function manage_news() {
		
		$this->paginate['Dailyop'] = array(
		
			"conditions"=>array(
				"Dailyop.news_post"=>1
			),
			"order"=>array(
				"Dailyop.publish_date"=>"DESC",
				"Dailyop.display_weight"=>"ASC"
			),
			"limit"=>50	
			
		
		);
		
		
		if(isset($this->params['named']['search'])) {
			
			if(isset($this->params['named']['Dailyop.misc_category'])) {
				
				$this->data['Dailyop']['misc_category'] = $this->paginate['Dailyop']['conditions']['Dailyop.misc_category'] = $this->params['named']['Dailyop.misc_category'];
				 
			}
			
			if(isset($this->params['named']['Dailyop.publish_date'])) {
				
				$this->paginate['Dailyop']['conditions'][] = "DATE(Dailyop.publish_date) = '{$this->params['named']['Dailyop.publish_date']}'";
				
				$this->data['Dailyop']['publish_date'] = $this->params['named']['Dailyop.publish_date'];
				
			}
			
		}
		
		
		
		$this->set("posts",$this->paginate("Dailyop"));
		
		
	}
	
	public function search_news() {
		
		$url = array(
		
			"action"=>"manage_news",
			"search"=>true
		);
		
		
		foreach($this->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
		
		return $this->redirect($url);
		
		
		
	}
	
	public function updateDisplayWeight() {
		//die(pr($this->data));	
		$this->Dailyop->id = $this->data['Dailyop']['id'];
		
		$this->Dailyop->save(array(
			"display_weight"=>$this->data['Dailyop']['display_weight']
		));
		
		return $this->redirect(base64_decode($this->data['Dailyop']['postback']));
		
		
	}
	public function updateBestOfWeight() {
		//die(pr($this->data));	
		$this->Dailyop->id = $this->data['Dailyop']['id'];
		
		$this->Dailyop->save(array(
			"best_of_weight"=>$this->data['Dailyop']['best_of_weight'],
			"best_of"=>$this->data['Dailyop']['best_of']
		));
		
		return $this->redirect(base64_decode($this->data['Dailyop']['postback']));

	}

	
	
	
	
	
	
	
	
	
	
	
}