<?php

class MediaHelper extends AppHelper {
	
	
	public $helpers = array("Html");
	
	
	public function mediaThumb($opt = array(),$attr = array()) {
		
		
		//check some stuff
		
		if(empty($opt['zc'])) {
			
			$opt['zc'] = 0;
			
		}
		
		$m = $opt['MediaFile'];
		
		switch($m['media_type']) {
			
			case "bcove":
				$opt['src'] = "/video/stills/".$m['file_video_still'];
			break;
			case "piclink":
				$opt['src'] = "/images/".$m['file'];
			break;
			case "image":
			case "img":
			case "pic":
				$opt['src']="/images/".$m['file'];
			break;
			default:
				
				if((preg_match('/(etw)/i',$m['file']) || preg_match('/(emot)/i',$m['file'])) && preg_match('/(\.swf)/i',$m['file'])) {
					
					$opt['src'] = "/images/eotw-thumb.jpg";
					
				} else {
					
					return "We haven't handled ".$m['media_type']." yet";
					
				}
				
				
				
			break;
		}
		
		$size = '';
		
		if(isset($opt['h'])) {
			
			$size .="&h=".$opt['h'];
			
		} else {
			
			//$size .="&h=1000";
			
		}
		
		if(isset($opt['w'])) {
			
			$size .= "&w=".$opt['w'];
			
		} else {
			
		//	$size.="&w=1000";
			
		}
		
		$proto = 'http';
		if(preg_match('/^(https)/i',$_SERVER['SCRIPT_URI'])) {
			
			$proto = 'https';
			
		}
		
		$attr['border'] = 0;
		
		//return the thumbnail
		return $this->Html->image("{$proto}://img.theberrics.com/i.php?src=".$opt['src']."&zc=".$opt['zc'].$size,$attr);
			
	}
	
	public function mediaThumbSrc($opt = array(),$options = array()) {
		
		$m = $opt['MediaFile'];
		
		$size = '';
		if(isset($opt['h'])) {
			
			$size .="&h=".$opt['h'];
			
		} 
		
		if(isset($opt['w'])) {
			
			$size .= "&w=".$opt['w'];
			
		} 
		
		switch($m['media_type']) {
			
			case "bcove":
				$opt['src'] = "/video/stills/".$m['file_video_still'];
			break;
			case "piclink":
				$opt['src'] = "/images/".$m['file'];
			break;
			case "image":
			case "img":
				$opt['src']="/images/".$m['file'];
			break;
			default:
				
					return "We haven't handled ".$m['media_type']." yet";
					
			break;
		}
		
		return "http://img.theberrics.com/i.php?src=".$opt['src'].$size;
		
	}
	
	public function adminMediaThumbLink($opt = array()) {
		
		
		$thumb = $this->mediaThumb($opt);
		
		//now lets make the link
		
		$m = $opt['MediaFile'];
		
		switch($m['media_type']) {
			
			case "bcove":
			break;
			
		}
		
		return $thumb;
		
	}
	
	
	public function soundcloudUrl($url = false) {
		
		$params = array(
			
			"url"=>$url,
			"format"=>"json"
		);
		
		$curl = curl_init("http://soundcloud.com/oembed");
		
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_POST,true);
		curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($params));
		
		$vars = curl_exec($curl);
		curl_close($curl);
		
		$vars = json_decode($vars);
		
		return $vars->html;
		
	}
	
	public function sectionIcon($s = array(),$options = array()) {
		
		$section = $s['DailyopSection'];
		
		$def_dark = 'c16882e007c5c7a773acd7c5e8869ab7.png';
		$def_light = '4500e4037738e13c0c18db508e18d483.png';
		
		$img = array();
	
		if(isset($s['dark']) && $s['dark'] == true) {
			
			$img['src'] = $section['icon_dark_file'];
			
		} else {
			
			$img['src'] = $section['icon_light_file'];
			
		}
		
		if(isset($s['w'])) {
			
			$img['w'] = $s['w'];
			
		}
		
		if(isset($s['h'])) {
			
			$img['h'] = $s['h'];
			
		}
		
		//check for emtyp
		
		if(empty($img['src'])) {
			
			switch($s['dark']) {
				
				case true:
					$img['src'] = $def_dark;
				break;
				default:
					$img['src'] = $def_light;
				break;
			}
			
		}
		
				
		$proto = 'http';
		
		if(preg_match('/(https)/i',$_SERVER['SCRIPT_URI'])) {
			
			$proto = 'https';
			
		}
		echo $this->Html->image("{$proto}://img.theberrics.com/i.php?src=/berrics-icons/".$img['src']."&w=".$img['w']."&h=".$img['h'],$options);
		
	}
	
	
	public function brandLogoThumb($b = array(),$opt = array()) {
		
		
		$brand = $b['Brand'];
		
		$img = array();
		
		if(isset($b['w'])) {
			
			$img['w'] = $b['w'];
			
		}
		
		if(isset($b['h'])) {
			
			$img['h'] = $b['h'];
			
		}
		
		$img['src'] = "/brand-logos/".$brand['image_logo'];
		
		$src = "http://img.theberrics.com/i.php?".http_build_query($img);
		
		return $this->Html->image($src,$opt);
		
	}
	
	public function productThumb($canteenImage = array(),$size = array(),$opt = array()) {
		
		$size['src'] = "/product-img/".$canteenImage['file_name'];
		
		$query = http_build_query($size);
		
		$proto = 'http';
		
		if(preg_match('/^(https)/i',$_SERVER['SCRIPT_URI'])) {
			
			$proto = 'https';
			
		}
		
		return "<img src='{$proto}://img.theberrics.com/i.php?".$query."' border='0' />";
		
	}
	
	public function productListThumb($canteen_product = array(),$size = array(), $opt = array()) {
		
		//determine which file we should be showing
		$img = false;
		$img = Set::extract("/CanteenProductImage[thumb_image=1]/",$canteen_product);
		
		if(count($img)<=0) $img = Set::extract("CanteenProductImage[front_image=1]/",$canteen_product);
		
		if(count($img)<=0) $img[0] = $canteen_product['CanteenProductImage'][0];

		$size['src'] = "/product-img/".$img[0]['file_name'];
		
		$q = http_build_query($size);
		
			
		$proto = 'http';
		
		if(preg_match('/^(https)/i',$_SERVER['SCRIPT_URI'])) {
			
			$proto = 'https';
			
		}
		
		return "<img alt='' border='0' src='{$proto}://img.theberrics.com/i.php?{$q}'/>";
		
	}
	
	
	
	
}


?>