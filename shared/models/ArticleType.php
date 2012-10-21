<?php

class ArticleType extends AppModel {

	public static function sortWeights() {
		
		$a = array();
		
		for($i=1;$i<=99;$i++) {
			
			$a[$i]=$i;
			
			
		}
		
		return $a;
		
	}
	
}

