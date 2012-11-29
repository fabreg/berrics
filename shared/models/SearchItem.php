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

	public function formatString($s) {
		
		 $final = array();
	    foreach (array_filter(preg_split('/[\s\'-]+/', $s)) as $word) {
	            $final[] = "+$word";
	    }
	    $s = implode(' ', $final);

	    return $s;

	}

	public function run_search($str) {
		
		$token = "ft-search-".md5($str);

		if(($result = Cache::read($token,"1min")) === false) {

			$query = $this->formatString($str);

			$match = "MATCH(title,sub_title,keywords) AGAINST('{$query}')";

			$match_bool = "MATCH(title,sub_title,keywords) AGAINST('{$query}' IN BOOLEAN MODE)";

			$result = $this->find("all",array(
							"fields"=>array(
								"*",
								"{$match} AS `Score`"
							),
							"conditions"=>array(
								$match_bool
							),
							"order"=>array(
								"Score"=>"DESC"
							)
						));

			//Cache::write($token,$result,"1min");

		}

		return $result;

	}

}