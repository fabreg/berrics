<?php

class Tools {
	
	
	
	public static function safeUrl($text) {
		
		$text = strtolower(trim(preg_replace('/[^\w\d_ -]/si', '', $text)));
		
		$text = str_replace(" ","-",$text);
		
		return $text;
		
	}
	
	
	
}

