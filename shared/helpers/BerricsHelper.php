<?php

class BerricsHelper extends AppHelper {
	
	public $helpers = array("Html","Media","Session","Number");
	
	public function beforeRender() {
				
		/**
		 * Add a currency format to the Number helper.  Makes reusing
		 * currency formats easier.
		 *
		 * {{{ $number->addFormat('NOK', array('before' => 'Kr. ')); }}}
		 * 
		 * You can now use `NOK` as a shortform when formatting currency amounts.
		 *
		 * {{{ $number->currency($value, 'NOK'); }}}
		 *
		 * Added formats are merged with the following defaults.
		 *
		 * {{{
		 *	array(
		 *		'before' => '$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
		 *		'decimals' => '.', 'negative' => '()', 'escape' => true
		 *	)
		 * }}}
		 *
		 * @param string $formatName The format name to be used in the future.
		 * @param array $options The array of options for this format.
		 * @return void
		 * @see NumberHelper::currency()
		 * @access public
		 */
		
		$this->Number->addFormat("CAD",array(
			"before"=>"$","after"=>" ","escape"=>false
		));
		$this->Number->addFormat("BRL",array(
			"before"=>"BRL ","after"=>" ","escape"=>false,"decimals"=>","
		));
	}
	
	public function currency($c,$n) {
			
		
		return $this->Number->currency($c,$n);
		
	}
	
	public function displayDailyopMedia($d) {
		
		//make some sort cuts to the ORM
		$m = $d['DailyopMediaItem'][0]['MediaFile'];
		$dop = $d['Dailyop'];
		$display = '';

	
		 switch($m['media_type']) {

		 	case "piclink":
		 	case "pic":
		 	case "img":

		 		$display = $this->Media->mediaThumb(array(
		 		
		 			"MediaFile"=>$m,
		 			"w"=>700,
		 			"h"=>400,
		 			"zc"=>0
		 		
		 		),array(
		 		
		 			"display_weight"=>$d['DailyopMediaItem'][0]['display_weight']
		 		
		 		));

		 	break;
		 	case "bcove":
	 	
		 			$display = $this->Media->mediaThumb(array(
			 		
			 			"MediaFile"=>$m,
			 			"w"=>700,
			 			"h"=>400,
			 			"zc"=>0
			 		
			 		))."<div class='play-button'></div><div class='overlay'></div>";
			 		
			 		if(preg_match('/(playstation)/i',$_SERVER['HTTP_USER_AGENT'])) {
			 			
			 			$display = "<div class='ps3-video-post-bit' onclick=\"ps3VideoPostBit('".$dop['id']."','".$m['id']."');\" id='ps3-video-div-".$dop['id']."'>{$display}</div>";
			 			
			 		}

			break;
		 	case "flash":
		 		
		 		$swf_file = $m['file'];	
		 		$display = "<div class='dailyop-swf-file' file='http://img.theberrics.com/{$swf_file}'></div>";
		 	
		 	break;
		 }
		 
		 $link = false;
		 //now do some special stuff
		 switch($m['media_type']) {
		 	
		 	case "piclink":
		 		//$link = $this->Html->link($display,$m['legacy_link'],array("escape"=>false));
		 		$link = $m['legacy_link'];
		 	break;
		 	default:
		 		
		 	break;
		 }
		 
		 //check to see if the post has a direct link
		 if(strlen($dop['url'])>0) {
		 	
		 	$link = $dop['url'];
		 	
		 	$target = 'target="'.$dop['window_target'].'" rel="override-link"';
		 	
		 } 
		 
		 if($dop['link_to_post_url']==1) {
		 	
		 	$link = $this->dailyopsPostUrl($d);
		 	$target = $dop['window_target'];
		 	if(!isset($this->params['section'])) {
				
				$display = "<a href='{$link}' class='link-to-post-override' target='{$target}'>".$display."</a>";
			
			}
		 	
		 }
		 
		 if(!empty($dop['url'])) {
		 	
		 	$link = $dop['url'];
		 	$target = $dop['window_target'];
		 	$display = "<a href='{$link}' class='link-to-post-override' target='{$target}'>".$display."</a>";
		 	
		 }
		
		 
		//build some more options
		$opts = array(
		
			"link_to_post"=>1,
			"link"=>$link
		
		);
		
		
		//should we do a click thru on this?
		
	
		 
		 
		 //put the content in a div
		// $out = $this->Html->div("dailyop_media_item",$display,array("media_type"=>$m['media_type'],"media_file_id"=>$m['id'],"pre"=>$m['preroll'],"post"=>$m['postroll'],"dailyop_id"=>$dop['id']));
		 $out = $this->mediaFileDiv($display,array(
		 
		 	"MediaFile"=>$m,
		 	"Dailyop"=>$dop
		 
		 ),$opts);
	
		 
		return $out;
		 
	}
	
	public function dailyopsPostLink($label = false,$dop = false,$options = array()) {
	
		$link = $this->Html->link($label,$this->dailyopsPostUrl($dop),$options);
		
		return $link;
		
	}
	
	public function dailyopsPostUrl($dop) {
		
		return "/".$dop['DailyopSection']['uri']."/".$dop['Dailyop']['uri'];
		
	}
	
	public function mediaFileDiv($content = '', $dataSet = array(), $options = array()) {
		
		ClassRegistry::init("MediaFile");

		$m = $dataSet['MediaFile'];
		$d = false;
		$opt = array();
		$allowed = array("id","preroll","postroll","media_type");
		$ads = Arr::videoAdUrls(false);
		$adLabels = Arr::adLabels();
		
		$m = MediaFile::formatVideoAdUrls($m);
		
		if($dataSet['Dailyop']) {
			
			//$opt['Dailyop'] = $dataSet['Dailyop'];
			$opt['dailyop_id'] = $options['dailyop_id'] = $dataSet['Dailyop']['id'];
		}
		
		foreach($m as $k=>$v) {
			
			if(in_array($k,$allowed)) {
				
				$opt['MediaFile'][$k]=$v;
				
			}
			
		}

		$options['media_file'] 			= json_encode($opt);
		$options['media_type'] 			= $m['media_type'];
		$options['media_file_id'] 		= $m['id'];
		$options['slide_show'] 			= $dataSet['Dailyop']['slide_show'];
		$options['dailyop_section_id'] 	= $dataSet['Dailyop']['dailyop_section_id'];
		$options['publish_date'] 		= $dataSet['Dailyop']['publish_date'];
		
		
		//new parameters
		
		//dailyops id
		(isset($dataSet['Dailyop']['id'])) ? 
						$options['dailyop_id'] = $dataSet['Dailyop']['id']:'';

		//pass in the session
		$options['xid'] = CakeSession::id();
						
		
		return $this->Html->div("dailyop_media_item",$content,$options);
		
	}
	
	

	public function datePaginatorMenuData($startDate = false,$endDate = false) {
		
		$checkDate = $endDate;
		
		$menu = array();
		
		while($checkDate != $startDate) {
			
			//get the month and year for the array key
			$arrayKey = date("Y-m-01",strtotime($checkDate));
			
			$menu[$arrayKey][] = date("Y-m-d",strtotime($checkDate));
			
			$checkDate = date("Y-m-d",strtotime("+1 Day",strtotime($checkDate)));
			
			
		}
		
		return $menu;
		
	}
	
	public function dailyopsArchiveMenu($params = false) {
		
		$data = array_reverse($this->datePaginatorMenuData(date("Y-m-d"),"2007-12-07"));
		
		$out = '';
		
		$px = 0;
		
		$left = '';
		
		foreach($data as $k=>$v) {
			
			$year = date("Y",strtotime($k));
			
			$month = date("m",strtotime($k));
			
			if($params['action'] == "archives" && $params['controller'] == "dailyops" && strlen($left)<=0) {
				
				$p_date = $params['pass'][0];
				
				$p_year = date("Y",strtotime($p_date));
				
				$p_month = date("m",strtotime($p_date));
				
				if($p_year == $year && $p_month == $month) {
					
					
					$left = "left:-".$px."px; ";
					
					
				}
				
			}
			
			
			$out .="<div class='month'>";
			$out .= date("F.Y",strtotime($k));
			$out .="<ul>";
			
			$res = array_reverse($v);
			
			foreach($res as $key=>$val) {
				
				$link = $this->Html->link(date("d",strtotime($val)),array("controller"=>"dailyops","action"=>"archives",$val));
				
				$out .= $this->Html->tag("li",$link);
				
			}
			$out .= "</ul>";
			$out .= "</div>";
			$px += 630;
			
		}
		
		return "<div style='width:{$px}px; {$left}' class='scroller'>".$out."</div>";;
		
		
	}
	
	
	public function monthYearHeader($date_time = false,$options = array()) {
		
		
		/*$month = strtolower(date("M",strtotime($date_time)));
		$year = date("y",strtotime($date_time));
		
		$src = "http://img.theberrics.com/i.php?src=/date-img/{$month}{$year}.png&h={$h}";
		
		return $this->Html->image($src,$options);*/
		
		$year = date("Y",strtotime($date_time));
		
		$month = date("F",strtotime($date_time));
		
		$div = "<div class='section-date-heading'>";
		
		$div .= strtoupper($month)." ".$year;
		
		$div .= "</div>";
		
		return $div;
		
		
	}
	
	public function profileThumb($user,$opts = array()) {
		
		
		
	}
	
	public function parseSplashDom($SplashCreative,$noCache = false) {
		
		$token = "splash-dom-".$SplashCreative['SplashCreative']['id'];
		
		if((($htm = Cache::read($token,"1min")) === false) || $noCache) {
			
			$body = $SplashCreative['SplashCreative']['body_content'];
			
			$dom = new DOMDocument();
			
			//load up the html
			$dom->loadHTML($body);
			
			//get the berrics tags
			
			$btags = $dom->getElementsByTagName("berrics");
			
			if($btags->length<=0) return $body;
			
			$Dailyop = ClassRegistry::init("Dailyop");
			
			foreach($btags as $k=>$e) {
			
				if(!$e->hasAttribute("type")) {
						
					$e->parentNode->removeChild($e);
					continue;
						
				}
			
				switch($e->getAttribute("type")) {
			
					case "post":
						$p = $Dailyop->returnPost(array(
						"Dailyop.id"=>$e->getAttribute("post_id")
						),1);
							
						$tdoc = new DOMDocument();
			
						@$tdoc->loadHTML($this->_View->element("dailyops/post-bit",array("dop"=>$p)));
			
						$e->parentNode->replaceChild($dom->importNode($tdoc->documentElement, TRUE),$e);
			
						unset($tdoc);
							
					break;
			
				}
			
			}
			
			$htm =  $dom->saveHTML($dom->getElementsByTagName("body")->item(0));
			
			$htm = str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $htm);
			
			Cache::write($token,$htm,"1min");
			
		}
		
		return $htm;
		
	}
	

	public function postMediaDiv($Dailyop,$opts = array()) {
		
		$template = $Dailyop['Dailyop']['post_template'];

		if(isset($opts['MediaFile'])) {

			$MediaFile = $opts['MediaFile'];

		} else {

			$MediaFile = $Dailyop['DailyopMediaItem'][0]['MediaFile'];

		}

		

		$opts = array_merge(array(
			"data-media-file-id"=>$MediaFile['id'],
			"data-dailyop-id"=>$Dailyop['Dailyop']['id'],
			"data-media-type"=>$MediaFile['media_type'],
			"class"=>"post-media-div"
		),$opts);

		//check for lazy load
		$lazy = false;
		if(isset($opts['lazy'])) {

			$lazy = $opts['lazy'];

		}

		unset($opts['lazy']);

		if($this->request->is("mobile")) {
			$poster = $this->Media->mediaThumbSrc(array(
					"MediaFile"=>$MediaFile,
					"w"=>"700",
					"type"=>$template
				));
			$img = "<video poster='{$poster}' class='mobile-video-tag'></div>";

		} else {

			$img = $this->Media->mediaThumb(array(
					"MediaFile"=>$MediaFile,
					"w"=>"700",
					"type"=>$template,
					"lazy"=>$lazy
				));

		}

		$img = $this->Media->mediaThumb(array(
					"MediaFile"=>$MediaFile,
					"w"=>"700",
					"type"=>$template,
					"lazy"=>$lazy
				));
		
		switch(strtolower($MediaFile['media_type'])) {

			case 'img':

				$hover = "<div class='img-hover'></div>";
				$img = $hover.$img;

				if(!empty($Dailyop['Dailyop']['url'])) {

					$href=$Dailyop['Dailyop']['url'];
					$target = $Dailyop['Dailyop']['window_target'];
					

					$img = "<a href='{$href}' target='{$target}' >{$img}</a>";

				}
			break;
			case "bcove":
				$hover = "<div class='play-button'></div><div class='video-hover'></div>";
				$img = $hover.$img;
			break;


		}

		return $this->Html->tag("div",$img,$opts);

	}

	public function parseTagLinks($tags) {
		
		$o = '';

		foreach ($tags as $k => $t) {
			
			if(isset($t['Tag'])) $t = $t['Tag'];

			$url = "/tags/{$t['slug']}";

			if(isset($t['User']['id']) && !empty($t['User']['profile_uri']))
					$url = "/profiles/".$t['User']['profile_uri']; 

			$o.= $this->Html->link(strtoupper($t['name']),$url)."&nbsp;";
		}

		return $o;

	}
	
}

?>