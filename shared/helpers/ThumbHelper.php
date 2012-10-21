<?php

class ThumbHelper extends AppHelper {
	
	
	public $helpers = array("Phpthumb");
	/**
	 * Generates a thumbnail from an image file in the WEBROOT path.
	 * $opt['src'] = "img/file.jpg"
	 * @param Array $opt
	 * @return String
	 */
	public function imgThumb($opt = array()) {
		
		
		//help out some of our incoming opts
		
		$opt['src'] = WWW_ROOT.$opt['src'];
		
		
		
		$defaults = array(
				        	'save_path' => WWW_ROOT . 'cache/img',
				        	'display_path' => '/cache/img',
				        	'error_image_path' => '/img/error.jpg', 
				    		
				        );
				        
		$options = array_merge($opt,$defaults);
		
		
		$thumbnail = $this->Phpthumb->generate(
				        $options
				    );
		
		return $thumbnail['src'];
		
	}
	
	public function tmpThumb($opt = array()) {
		
		
		//help out some of our incoming opts
		
		//$opt['src'] = TMP.$opt['src'];
		
		
		
		$defaults = array(
				        	'save_path' => WWW_ROOT . 'cache/img',
				        	'display_path' => '/cache/img',
				        	'error_image_path' => '/img/error.jpg', 
				    		"ar"=>"L"
				        );
				        
		$options = array_merge($opt,$defaults);
		
		
		$thumbnail = $this->Phpthumb->generate(
				        $options
				    );
		
		return $thumbnail['src'];
		
		
		
	}
	
	public function remoteImgThumb($opt = array()) {
		
		//help out some of our incoming opts
		
		//$opt['src'] = WWW_ROOT.$opt['src'];
		
		
		
		$defaults = array(
				        	'save_path' => WWW_ROOT . 'cache/img',
				        	'display_path' => '/cache/img',
				        	'error_image_path' => '/img/error.jpg', 
				    		
				        );
				        
		$options = array_merge($opt,$defaults);
		
		
		$thumbnail = $this->Phpthumb->generate(
				        $options
				    );
				    
		die(pr($this->Phpthumb));
		
		return $thumbnail['src'];
		
	}
	
	
	
}


?>