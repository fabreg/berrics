<?php

class TesterShell extends AppShell {
	
	public $uses = array("Dailyop","SearchItem");
	
		

	public function search_items() {
		
		$post_ids = $this->Dailyop->find("all",array(
			"fields"=>array("Dailyop.id"),
			"contain"=>array(),
			"order"=>array("Dailyop.id"=>"ASC")
		));

		foreach($post_ids as $id) {

			$id = $id['Dailyop']['id'];
			
			$post = $this->Dailyop->returnPost(array(
				"Dailyop.id"=>$id
			),true);

			$sd = $this->Dailyop->extractSearchValues($post);

			$this->SearchItem->insertItem($sd);

			$this->out("Dailyops Post: {$id} | {$post['Dailyop']['name']} - {$post['Dailyop']['sub_title']}");

		}

	}
	
}