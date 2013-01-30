<?php

class TesterShell extends AppShell {
	
	public $uses = array("Dailyop","SearchItem","Tag","DailyopsTag");
	
		

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

	public function dc_report() {
		
		//battle at the berrics 3 4 5 6
		/*$posts = $this->Dailyop->find("all",array(
					"conditions"=>array(
						"Dailyop.dailyop_section_id"=>array(
							38,7,74,83
						)
					),
					"contain"=>array(
						"DailyopMediaItem"=>array(
								"MediaFile",
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
								"limit"=>1
							)
					)
				));*/
		$posts = $this->Dailyop->find("all",array(
					"conditions"=>array(
						"OR"=>array(
							array("Dailyop.name LIKE"=>"%dc%"),
							array("Dailyop.sub_title LIKE"=>"%dc%")
						)
					),
					"contain"=>array(
						"DailyopMediaItem"=>array(
								"MediaFile",
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
								"limit"=>1
						)
					)
				));
		$ids = Set::extract("/DailyopMediaItem/MediaFile/id",$posts);

		$id_str = '';

		foreach ($ids as $v) {
			
			$id_str .= "'{$v}',";

		}

		die($id_str);

	}

	public function dc_report_() {
		
		//$this->loadModel('Tag');
		//$this->loadModel('DailyopsTag');
		
		//$ids = '9,10,19,34,42,132,167,220,339,504,621,780,847,849,892,1005,1082,1190,2136,2208,2266,2743,2839,2883,2964,3674,3753,4201';

		//$ids = '9,10,19,34,42,68,69,132,167,220,339,504,621,780,847,849,892,962,1000,1003,1005,1082,1190,1552,1659,2089,2136,2146,2208,2209,2266,2390,2405,2441,2743,2839,2883,2930,2938,2964,2966,2967,3064,3065,3066,3067,3068,3069,3392,3674,3753,4201,4203';


		$keys = array(
							"Steve Berra",
							"Berra",
							"Chris Cole",
							"Rob Dyrdek",
							"Colin Mckay",
							"Josh Kalis",
							"Mikemo Capaldi",
							"Mike mo capaldi",
							"mikey taylor",
							"matt miller",
							"danny way",
							"felipe gustavo",
							"evan smith",
							"davis torgerson",
							"marquise henry",
							"nyjah huston",
							"wes kremer",
							"batb",
							"babt3",
							"batb4",
							"batb5",
							"batb6",
							"batbIII",
							"batbIV",
							"batbv",
							"batbvi"
						);

		$or = array();

		foreach ($keys as $k => $v) {
			
			$or[] = array(
				"Tag.name LIKE"=>"%".str_replace(" ", "%", $v)."%"
			); 

		}

		//die(pr($or));

		$tags = $this->Tag->find("all",array(
					
					"conditions"=>array("OR"=>$or),
					"contain"=>array(
						"Dailyop"=>array(
							"DailyopMediaItem"=>array(
								"MediaFile",
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
								"limit"=>1
							)
						)
					)
				));
		

		$ids = Set::extract("/Dailyop/DailyopMediaItem/MediaFile/id",$tags);

		$mids = array();

		foreach($ids as $v) {

			$mids[$v] = $v;

		}
		
		$mids = array_values($mids);
		
		$id_str = "";

		foreach($mids as $v) $id_str .= "'{$v}',";

		$id_str = rtrim($id_str,",");

		die($id_str);

		die(implode(",",$mids));


		$posts = $this->Dailyop->find("all",array(
					"conditions"=>array(
						"OR"=>array(
							array("Dailyop.name LIKE"=>"%dc%"),
							array("Dailyop.sub_title LIKE"=>"%dc%")
						)
					),
					"contain"=>array(
						"DailyopMediaItem"=>array(
								"MediaFile",
								"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
								"limit"=>1
						)
					)
				));

		$ids = Set::extract("/DailyopMediaItem/MediaFile/id",$posts);



		$id_str = implode(",", $ids);

		die($id_str);

	}
	
}