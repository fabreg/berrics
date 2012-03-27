<?php

class InstagramImageItem extends AppModel {
	
	
	public function returnInstagramRecent($User = array(),$limit = 20,$page = 1) {
		
		if(empty($User['instagram_account_num'])) return false;
		
		$token = "instagram-recent-".$User['id']."-{$limit}-{$page}";
		
		if(($data = Cache::read($token,"5min")) === false) {
			
			App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
		
			$i = InstagramApi::berricsInstance();
		
			$recent = $i->instagram->getUserRecent($User['instagram_account_num']);	
			
			$recent = json_decode($recent,true);
			
			SysMsg::add(array(
				"category"=>"Instragram",
				"title"=>"Referesh Instagram Feed: ".$User['instagram_handle'],
				"from"=>"InstagramImageItem"
			));
			
			//die(addslashes(serialize()));
			
			foreach($recent['data'] as $k=>$v) {
				
				//check to see if there is an instagra object
				$check = $this->find("first",array(
					"conditions"=>array("InstagramImageItem.instagram_object_id"=>$v['id'])
				));
				
				if(!isset($check['InstagramImageItem']['id'])) {
	
					$this->create();
					$this->save(array(
						"instagram_object_id"=>$v['id'],
						"active"=>1
					));
					$obj_id = $this->id;
					
				} else {
					
					$obj_id = $check['InstagramImageItem']['id'];
					
				}
				
				$this->create();
				$this->id  = $obj_id;
				
				$d = array(
					"created_time"=>date('Y-m-d H:i:s',$v['created_time']),
					"link"=>$v['link'],
					"likes"=>$v['likes']['count'],
					"instagram_object_id"=>$v['id'],
					"caption"=>$v['caption']['text'],
					"filter"=>$v['filter'],
					"images"=>serialize($v['images']),
					"instagram_account_num"=>$v['user']['id']
				);
				
				$this->save($d);
				
			}
			
			$data = $this->find("all",array(
				"conditions"=>array("InstagramImageItem.instagram_account_num"=>$User['instagram_account_num']),
				"order"=>array(
					"InstagramImageItem.created_time"=>"DESC"
				),
				"limit"=>$limit
			));
			
			Cache::write($token,$data,"5min");
			
		}
		
		return $data;
		
	}
	
}