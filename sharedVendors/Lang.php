<?php


class Lang {
	
	public static $instance = false;
	
	public static $phrase = false;
	
	private function __construct() {
		
		
	}
	
	public static function instance() {
		
		if(!self::$instance) {
			
			self::$instance = new self();
			
		}
		
		return self::$instance;
		
	}
	
	public static function returnSection($section= false, $locale = 'en_us') {
		
		$token = "lang_phrase_section_".$section."_".$locale;
		
		if(($sec = Cache::read($token,"1min")) === false) {
			
			$sec = self::phraseModel()->returnSection($section,$locale);
			
			Cache::write($token,$sec,"1min");
		}
		
		return $sec;
		
	}
	
	public static function phraseModel() {
		
		if(!self::$phrase) {
			
			//App::import("Model","Phrase");
			
			//self::$phrase = new Phrase();
			
			self::$phrase = ClassRegistry::init("Phrase");
			
		}
		
		return self::$phrase;
		
	}
	
	public static function p($section = "CommonFields",$phrase,$locale = "en_us") {
		
		$section = self::returnSection($section,$locale);
		
		if(isset($section[$phrase])) {
			
			return $section[$phrase];
			
		} else {
			
			return $phrase;
			
		}
		
	}
	

	
	
}


?>