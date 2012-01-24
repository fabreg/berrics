<?php

class BerricsHelper extends AppHelper {
	
	public $helpers = array("Html","Media","Session");
	
	
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
		$options['xid'] = $this->Session->id();
						
		
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
	
	
}

?>