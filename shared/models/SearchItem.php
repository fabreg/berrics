<?php

/**
* 
*/
class SearchItem extends AppModel {
	

	public function insertItem($data) {
		
		//do a check to see if we insert or update
		$chk = $this->find("first",array(
			"conditions"=>array(
				"SearchItem.model"=>$data['model'],
				"SearchItem.foreign_key"=>$data['foreign_key']
			)
		));

		$this->create();

		if(isset($chk['SearchItem']['id'])) $this->id = $chk['SearchItem']['id'];

		$this->save($data);

		return $this->id;

	}

	public function formatString($s,$strict = true) {
		
		 $final = array();
	    foreach (array_filter(preg_split('/[\s\'-]+/', $s)) as $word) {
	            if ($strict) {
	            	  $final[] = "+\"$word\"";
	            } else {
	            	  $final[] = "\"$word\"";
	            }
	            
	    }
	    $s = implode(' ', $final);

	    return $s;

	}

	public function run_search($str,$strict=true,$cond = array()) {
		
		$token = "ft-search-".md5($str).md5(serialize($cond));

		if(($result = Cache::read($token,"1min")) === false) {

			$query = $this->formatString($str,$strict);

			$match = "MATCH(keywords) AGAINST('{$query}')";

			$match_bool = "MATCH(keywords) AGAINST('{$query}' IN BOOLEAN MODE)";

			$result = $this->find("all",array(
							"fields"=>array(
								"*",
								"{$match} AS `Score`"
							),
							"conditions"=>array_merge(array(
								$match_bool
							),$cond),
							"order"=>array(
								"Score"=>"DESC"
							)
						));

			//Cache::write($token,$result,"1min");

		}

		return $result;

	}

}