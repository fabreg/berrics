<?php
class DailyopSection extends AppModel {
	var $name = 'DailyopSection';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Dailyop' => array(
			'className' => 'Dailyop',
			'foreignKey' => 'dailyop_section_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	var $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'dailyop_sections_tags',
			'foreignKey' => 'dailyop_section_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	
	public function returnSelectList() {
		
		return $this->find('list',array(
			
			"order"=>array(
				"DailyopSection.name"=>"ASC"
			)
		
		));
		
	}
	
	
	
	public static function directives() {
		
		$a = array(
			
			"image_gallery"=>"Image Gallery",
			"commander"=>"BATCOM,RECRUIT,UN",
			"recruits"=>"Recruits",
			"trickipedia"=>"Trickipedia",
			"batb"=>"Battle at the Berrics",
			"batb4"=>"Battle at the Berrics 4",
			"batb5"=>"Battle at the berrics 5",
			"batb6"=>"Battle at the berrics 6",
			"trajectory"=>"Trajectory",
			"bangyoself"=>"Bang Yoself 3",
			"news"=>"Aberrican News",
			"newsv2"=>"Aberrican News V2",
			"younited_nations"=>"YOUnited Nations",
			"theotis"=>"31 Days Of Theotis",
			"berrics_records"=>"For The Record",
			"sls_voting"=>"Street League Voting",
			"yn3_voting"=>"YOUnited Nations 3 Voting",
			"levis"=>"Levis 511 Contest",
			"bones_new_ground"=>"Bones New Ground Video",
			"primitive_pain_is_beauty"=>"Primitive - Pain is Beauty",
			"interrogation"=>"Interrogation Controller",
			"evan_smith_experience"=>"Evan Smith Experience",
			"mtn_dew"=>"Mtn Dew",
			"progression"=>"Progression Controller",
			"watch_this"=>"Watch This Controller",
			"deathwish_video"=>"Deathwish Video Controller"
			
		);
		
		return $a;
		
	}
	
	public function returnSections() {
		
		if(($sections = Cache::read("dop_sections","1min")) === false) {
			
			$cond = array("DailyopSection.active"=>1);
			
			if(preg_match('/(dev\.|v3\.)/i',$_SERVER{'HTTP_HOST'})) {

				$cond = array(
						"OR"=>array(
							array("DailyopSection.active"=>1),
							array("DailyopSection.id"=>array("100"))
						)
					);

			}

			$sections = $this->find("all",array(	
				"conditions"=>$cond,
				"contain"=>array(),
				"order"=>array("DailyopSection.name"=>"ASC")
			));
			
			Cache::write("dop_sections",$sections,"1min");
			
		}
		
		return $sections;
		
	}

}