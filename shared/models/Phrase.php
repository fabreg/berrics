<?php

class Phrase extends AppModel {
	var $name = 'Phrase';
	
	public static $en_us = array();
	
	public static $sections = array();
	
	public $actsAs = array(
	
		"Translate"=>array(
	
			"value"
	
		)	
	
	);
	
	var $locale = 'en_us';
	
	var $validate = array(
		'section' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'token' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'value' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	public function setLanguage($locale = 'en_us') {
		
		$this->locale = $locale;
		
	}
	
	public function returnEnSection($section) {
	
		if(Set::check(self::$en_us,$section)) {
			
			return self::$en_us[$section];
			
		}	
		
		
		$token = "phrase_secton_".$section;
		
		$old_locale = $this->locale;
		
		$this->setLanguage("en_us");
		
		$data = $this->find("all",array(
			
			"conditions"=>array(
			
				"Phrase.section"=>$section
		
			)
		));
		
		$d = array();
		
		foreach($data as $v) {
			
			$d[$v['Phrase']['token']] = $v['Phrase']['value'];
			
		}
		
		self::$en_us[$section] = $d;
		
		$this->setLanguage($old_locale);
		
		return self::$en_us[$section];
		
	}
	
	public function returnSection($section,$locale = 'en_us') {
		
		$en_us = $this->returnEnSection($section);
		
		//get the us version of the section first
		if($locale == 'en_us') {
			
			return $en_us;
			
		}
		
		//query up the languages
		if(Set::check(self::$sections,$section.".".$locale)) {
			
			return self::$sections[$section][$locale];
			
		} else {
			
			$old_locale = $this->locale;
			
			$this->setLanguage($locale);
			
			$lang = $this->find("all",array(
			
				"conditions"=>array(
			
					"Phrase.section"=>$section
			
				)
			
			));
			
			
			$this->setLanguage($old_locale);
			
			foreach($en_us as $k=>$v) {
				
				$p = Set::extract("/Phrase[token=/".$k."/i]/value",$lang);
				
				if(count($p)>0) {
					
					$en_us[$k]=$p[0];
					
				}
				
			}
			
			//cache the data
			self::$sections[$section][$locale]=$en_us;
			
		}
		
		return self::$sections[$section][$locale];
		
	}
}
?>