<?php

class MediaHelper extends AppHelper {
	
	
	public $helpers = array("Html");
	
	
	public function mediaThumb($opt = array(),$attr = array()) {
		
		
		//check some stuff
		
		if(empty($opt['zc'])) {
			
			$opt['zc'] = 0;
			
		}

		$empty_img = '/loading-imgs/loading-lazy.jpg';
		$lazy_w = false;
		$lazy_h = false;
		
		$m = $opt['MediaFile'];
		
		switch($m['media_type']) {
			
			case "bcove":
				$img_key = '';

				if(isset($opt['type'])) $img_key = $opt['type'];

				switch($img_key) {

					case 'slim':
						$opt['src'] = "/video/stills-slim/".$m['file_video_still_slim'];
						$lazy_w = 700;
						$lazy_h = 200;
					break;
					case 'large':
						$opt['src'] = "/video/stills-large/".$m['file_video_still_large'];
					break;
					default:
						$opt['src'] = "/video/stills/".$m['file_video_still'];
					break;


				}
				
				
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
			$height = $opt['h'];

			if(!$lazy_h) $lazy_h = $opt['h'];

		} else {
			
			//$size .="&h=1000";
			
		}
		
		if(isset($opt['w'])) {
			
			$size .= "&w=".$opt['w'];
			$width = $opt['w'];
			if(!$lazy_w) $lazy_w = $opt['w'];
		} else {
			
		//	$size.="&w=1000";
			
		}
		
		$proto = 'http';
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == true) {
			
			$proto = 'https';
			
		}
		
		$attr['border'] = 0;

		$img_src_str = "{$proto}://img01.theberrics.com/i.php?src=".$opt['src']."&zc=".$opt['zc'].$size;
		
		if(isset($opt['lazy']) && $opt['lazy'] == true) {

			$sz = '';
			if($lazy_w) $sz.="&w=".$lazy_w;
			if($lazy_h) $sz.= "&h=".$lazy_h;

			$attr['data-original'] = $img_src_str;


			$img_src_str = "//img.theberrics.com/i.php?src=".$empty_img."&zc=1".$sz;


			$attr['class'] = "lazy ".$attr['class'];
			if(isset($lazy_w)) $attr['width'] = $lazy_w;
			if(isset($lazy_h)) $attr['height'] = $lazy_h;
		//	if(isset($height)) $attr['height'] = "height";

		}
		
		//return the thumbnail
		return $this->Html->image($img_src_str,$attr);
			
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
		

		return "http://img01.theberrics.com/i.php?src=".$opt['src'].$size;

		
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

		if(isset($s['color']) && $s['color'] == true) {

			$img['src'] = $section['icon_color_file'];

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
	
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == true) {
			
			$proto = 'https';
			
		}
		echo $this->Html->image("{$proto}://img01.theberrics.com/i.php?src=/berrics-icons/".$img['src']."&w=".$img['w']."&h=".$img['h'],$options);
		
	}

	public function sectionHeading($d = array(),$options=array()) {
		
		$section = $d['DailyopSection'];

		$img = array();

		$img['src'] = $section['section_heading_file'];

		if(isset($d['w'])) {
			
			$img['w'] = $d['w'];
			
		}
		
		if(isset($d['h'])) {
			
			$img['h'] = $d['h'];
			
		}

		$proto = 'http';
	
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == true) {
			
			$proto = 'https';
			
		}
		return $this->Html->image("{$proto}://img01.theberrics.com/i.php?src=/section-headings/".$img['src']."&w=".$img['w']."&h=".$img['h'],$options);

	}
	
	public function styleCodeImage($image,$opts = array()) {
		
		
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
		
		
		$file = $brand['image_logo'];
		
		if(isset($b['canteen']) && $b['canteen'] == true)
			$file = $brand['canteen_logo'];
		
		$img['src'] = "/brand-logos/".$file;
		
		$src = "http://img01.theberrics.com/i.php?".http_build_query($img);
		
		return $this->Html->image($src,$opt);
		
	}
	
	public function productThumb($canteenImage = array(),$size = array(),$opt = array()) {
		
		$lazy_query = http_build_query($size);

		$size['src'] = "/product-img/".$canteenImage['file_name'];
		
		$query = http_build_query($size);
		
		$proto = 'http';
		
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == true) {
			
			$proto = 'https';
			
		}
		
		return "<img  src='//img.theberrics.com/i.php?".$query."' border='0' alt='' />";
		
	}
	
	public function productListThumb($canteen_product = array(),$size = array(), $opt = array()) {
		
		//determine which file we should be showing
		$img = false;
		$img = Set::extract("/CanteenProductImage[thumb_image=1]/",$canteen_product);
		
		if(count($img)<=0) $img = Set::extract("CanteenProductImage[front_image=1]/",$canteen_product);
		
		if(count($img)<=0) $img[0] = $canteen_product['CanteenProductImage'][0];

		$lazy_query = http_build_query($size);


		$size['src'] = "/product-img/".$img[0]['file_name'];
		
		$q = http_build_query($size);
		
			
		$proto = 'http';
		
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == true) {
			
			$proto = 'https';
			
		}
		
		$lazy = false;

		if($size['lazy'] == true) $lazy = true;

		if($lazy) {

			return "<img src='//img.theberrics.com/i.php?src=/loading-imgs/loading-lazy.jpg' class='lazy' alt='' border='0' data-original='//img.theberrics.com/i.php?{$q}'  />";

		} else {

			return "<img class='lazy' alt='' border='0' src='//img.theberrics.com/i.php?{$q}'/>";

		}

		
		
	}
	
	
	public function profileThumb($img=array(),$opt = array(),$attr = array()) {
		
		//the file
		
		$opt['src'] = "/profile-img/".$img['file_name'];
		
		
		//check some stuff
		
		if(empty($opt['zc'])) {
			
			$opt['zc'] = 0;
			
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
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == true) {
			
			$proto = 'https';
			
		}
		
		$attr['border'] = 0;
		
		$src = "{$proto}://img01.theberrics.com/i.php?src=".$opt['src']."&zc=".$opt['zc'].$size;
		
		if(isset($opt['lazy'])) {
			
			$attr['data-original'] = $src;
			$src ="/img/layou/blk-px.png";
			
			
		}
		
		//return the thumbnail
		return $this->Html->image($src,$attr);
			
	}
	
	public function promoCodeIcon($promoCode,$opt = array(),$attr = array()) {
		
		//the file
		
		$opt['src'] = "/canteen-promo-icons/".$promoCode['icon_file'];
		
		
		//check some stuff
		
		if(empty($opt['zc'])) {
			
			$opt['zc'] = 0;
			
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
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == true) {
			
			$proto = 'https';
			
		}
		
		$attr['border'] = 0;
		
		//return the thumbnail
		return $this->Html->image("{$proto}://img01.theberrics.com/i.php?src=".$opt['src']."&zc=".$opt['zc'].$size,$attr);
			
	}

	public function unifiedEmployeeThumb($data,$opt = array()) {

		$employee = $data['UnifiedStoreEmployee'];

		$query['src'] = "/unified-employees/".$employee['image_file'];
		$query['w'] = (isset($data['w'])) ? $data['w']:'';
		$query['h'] = (isset($data['h'])) ? $data['h']:'';
		$query['zc'] = (isset($data['zc'])) ? $data['zc']:0;

		//no border!
		$opt['border'] = 0;

		$img = $this->Html->image("//img.theberrics.com/i.php?".http_build_query($query),$opt);

		return $img;

	}
	
}


?>