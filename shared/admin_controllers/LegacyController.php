<?php

App::import("Controller","LocalApp");

class LegacyController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
	}
	
	
	public function  index() {
		
		
		
		
	}
	
	
	public function import_dailyops() {
		//die("script halted");
		set_time_limit(10000);
		
		$this->loadModel("DailyLegacy");
		
		$this->loadModel("Dailyop");	
		
		$legacy_data = $this->DailyLegacy->find("all",array(
		
			"order"=>array("DailyLegacy.id"=>"DESC")
		
		));
				
		//loop thru the data and fix the timestamps into mysql timestamps
		
		$dump_array = array();
		
		foreach($legacy_data as $k=>$v) {
			
			$check = $this->Dailyop->find("first",array(
				"conditions"=>array(
					"Dailyop.legacy_id"=>$v['DailyLegacy']['id']
				),
				"contain"=>array()
			));
			
			//die(pr($check));
			
			if(!empty($check['Dailyop']['id'])) {
				print("Already got it, skipping");
				continue;
				
				
			} else {
				
				$fixed_ts = date("Y-m-d G:i:s",$v['DailyLegacy']['time']);
			
				$legacy_data[$k]['DailyLegacy']['created'] = $legacy_data[$k]['DailyLegacy']['modified'] = $fixed_ts;
				
				//pr($v);
				
				$dop = $v['DailyLegacy'];
				
				//make a new data array to insert into the master
				
				$data = array(
				
					"legacy_id"=>$dop['id'],
					"created"=>$fixed_ts,
					"modified"=>$fixed_ts,
					"publish_date"=>$fixed_ts,
					"text_content"=>stripslashes($dop['text']),
					"name"=>$dop['title'],
					"active"=>"1",
					"uri"=>Tools::safeUrl($dop['title']).".html",
					"user_id"=>'4d6428e7-0e18-44e7-afee-42f40ab5431b',
					"sub_title"=>$dop['subtitle']
				
				);
				
				
				//pr($data);
				
				$this->Dailyop->create();
				
				$this->Dailyop->save($data);

				pr("New Record Inserted");
					
			}
				
				
			
		}
		
		die('stop');
		
		$this->set(compact("legacy_data"));
		
	}
	
	public function import_media() {
		
		$this->loadModel("Media");
		
		$this->loadModel("MediaFile");
				
		$legacy_media = $this->Media->find("all");
		
		foreach($legacy_media as $k=>$v) {
			
			
			$check = $this->MediaFile->find("first",array(
				
				"conditions"=>array(
					"MediaFile.legacy_id"=>$v['Media']['id']
				),
				"contain"=>array()
			
			));
			
			if(!empty($check['MediaFile']['id'])) {
				
				print("Already got it, skipping");
				continue;
				
			} else {
				
					
				$e = $v['Media'];			
				
				$data = array(
				
					"legacy_id"=>$e['id'],
					"file"=>$e['filename'],
					"media_type"=>$e['type'],
					"legacy_type"=>$e['type'],
					"legacy_entry"=>$e['entry'],
					"brightcove_id"=>$e['video_id'],
					"brightcove_player_id"=>$e['player_id'],
					"legacy_link"=>$e['link'],
					"width"=>$e['width'],
					"height"=>$e['height']
				
				);
				
				$this->MediaFile->create();
				
				$this->MediaFile->save($data);

				print("inserted new: ".$v['Media']['id']);
				
			}
			
		}
		
		die('stop');
		
		
		$this->set(compact("legacy_media"));
		
	}
	
	public function fix_media_stuff() {
		
		$this->loadModel("MediaFile");
		$this->loadModel("Media");
		$this->loadModel("Dailyop");
		
		//get all the media files 
		$files = $this->MediaFile->find("all",array(
			"conditions"=>array("MediaFile.process_legacy"=>0),
			"contain"=>array()
		
		));
		
		foreach($files as $file) {
			
			if(!empty($file['MediaFile']['legacy_entry'])) {
				
				$post = $this->Dailyop->find("first",array(
					"conditions"=>array(
						"Dailyop.legacy_id"=>$file['MediaFile']['legacy_entry']
					),
					"contain"=>array()
				));
				
			} else {
				
				$post = false;
				
			}
			if(is_array($post) && count($post)>0) {
				
				//now lets update the date on craete/modified on the media file based on the post
				
				$mediaUpdate = array();
				
				$mediaUpdate['created'] = $mediaUpdate['modified'] = $post['Dailyop']['created'];
				
				//let's build the join row for the meida file
				
				$this->Dailyop->DailyopMediaItem->create();
				$this->Dailyop->DailyopMediaItem->save(array(
				
					"dailyop_id"=>$post['Dailyop']['id'],
					"media_file_id"=>$file['MediaFile']['id'],
					"featured"=>1
					
				
				));
				
				//update the media date widht the daily ops date
				$this->MediaFile->create();
				
				$this->MediaFile->id = $file['MediaFile']['id'];
				$this->MediaFile->save(
					array(
					
						"created"=>$post['Dailyop']['created'],
						"modified"=>$post['Dailyop']['modified'],
						"process_legacy"=>1
					
					)
				);
				
			}
			
			
			
		}
		
		
		
		
		
	}
	
	public function fix_media_dates() {
		
		
		
	}
	
	
	public function fix_slashes() {
		
		$this->loadModel("Dailyop");
		
		$dop = $this->Dailyop->find("all");
		
		foreach($dop as $v) {
			
			
			$this->Dailyop->id = $v['Dialyop']['id'];
			
			$data = array(
			
				
			
			);
			
			
		}
		
	}
	
	private function _import_video_screens() {
		
		$this->loadModel("MediaFile");
		
		
		$files = $this->MediaFile->find("all",array(
		
			"contain"=>array(),
			"conditions"=>array(
				"MediaFile.media_type"=>"bcove",
				"MediaFile.file_video_still"=>NULL
			),
			"limit"=>5
		
		));
		
		//lets save some thumbs
		
		$bc = BCAPI::instance()->bc;
		
		$cwd = getcwd();
		
		chdir("/home/sites/berrics/img.theberrics.com/public_html/video/stills/");
		
		//mkdir("testing");
		
		//die();
		//die(getcwd());
		
		foreach($files as $file) {
			
			$bc_file = $bc->find("videobyid",array("video_id"=>$file['MediaFile']['brightcove_id']));
			
			die(pr($bc_file));
			
			$tmp = array();
				
			exec("wget -O ".$file['MediaFile']['id'].".jpg ".$bc_file->videoStillURL,$tmp);
			
			//update the media file with the file_video_still
			pr($tmp);
			
			$this->MediaFile->create();
			
			$this->MediaFile->id = $file['MediaFile']['id'];
			
			$this->MediaFile->save(array("file_video_still"=>$file['MediaFile']['id'].".jpg"));
			
			
		}
		
		chdir($cwd);
		
		//die(pr($files));
		
	}
	
	public function fix_video_size() {
		
		$this->loadModel("Media");
		$this->loadModel("MediaFile");
		
		$files = $this->Media->find("all");
		
		foreach($files as $file) {
			
			$height = $file['Media']['height'];
			$width = $file['Media']['width'];
			
			$this->MediaFile->updateAll(
				array(
					"MediaFile.width"=>$width,
					"MediaFile.height"=>$height
				),
				array(
					"MediaFile.legacy_id"=>$file['Media']['id']
				)
				
			);
			
			
		}
		
		
		
	}
	
	public function fix_subtitles() {
		
		//get all the legacy media that we have
		
		$this->loadModel("Dailyop");
		$this->loadModel("DailyLegacy");
		
		$l = $this->DailyLegacy->find("all");
		
		
		
		foreach($l as $v) {
			
			$d = $v['DailyLegacy'];
			if(!empty($d['subtitle'])) {
				
				$this->Dailyop->create();
				
				$this->Dailyop->updateAll(
					array("sub_title"=>"'".$d['subtitle']."'"),
					array("legacy_id"=>$d['id'])
				);
				
				
			}
			
			
		}
		
	}
	
	public function fix_yoon_urls() {
		
		$this->loadModel("Dailyop");
		
		$d = $this->Dailyop->find("all",array(
			
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>14
			),
			"contain"=>array()
		
		));
		
		
		foreach($d as $v) {
			
			$this->Dailyop->create();
			
			$this->Dailyop->id = $v['Dailyop']['id'];
			
			$this->Dailyop->save(array(
				"uri"=>Tools::safeUrl($v['Dailyop']['sub_title']).".html"
			));
			
		}
		
	}
	
	
	public function batb3() {
		$a = array();
		for($i=0;$i<=110;$i++) {
			
			
			$a[] = $this->grab_battle($i);
			
		}
		
		foreach($a as $k=>$v) {

			if(count($v)<1) {
				
				unset($a[$k]);
				
			} else {
				
				$a[$k]['title'] = $v['lefskater']." vs. ".$v['rigskater'];
				
			}
			
		}
		
		pr($a);
		exit;
		
	}
	
	
	
	
	public function grab_trick($tid) {
		
		

			switch ($tid) {
				
					case 1:
						$trickname = "FRONTSIDE NOSEGRIND";
						$personname = "CHRIS ROBERTS";
						$bcove_video = "26655786001";
						
						break;
						
					case 2:
						$trickname = "360 FLIP";
						$personname = "KELLY HART";
						$bcove_video = "26655787001";
						
						break;
						
					case 3:
						$trickname = "BACKSIDE BIGSPIN";
						$personname = "ERIK ELLINGTON";
						$bcove_video = "26663208001";
						
						break;
						
					case 4:
						$trickname = "BACKSIDE KICKFLIP";
						$personname = "STEVE BERRA";
						$bcove_video = "26654882001";
						
						break;
						
					case 5:
						$trickname = "HEELFLIP";
						$personname = "LUIS TOLENTINO";
						$bcove_video = "26654881001";
						
						break;
						
					case 6:
						$trickname = "POP SHUVIT";
						$personname = "GARRETT HILL";
						$bcove_video = "26655781001";
						
						break;
						
					case 7:
						$trickname = "HEELFLIP SHUVIT";
						$personname = "CHICO BRENES";
						$bcove_video = "26663207001";
						
						break;
						
					case 8:
						$trickname = "BACKSIDE SMITH GRIND";
						$personname = "MIKE BARKER";
						$bcove_video = "26655779001";
						
						break;
						
					case 9:
						$trickname = "HARDFLIP";
						$personname = "BRYAN HERMAN";
						$bcove_video = "27291208001";
						
						break;
						
					case 10:
						$trickname = "FRONTSIDE FLIP";
						$personname = "ANDREW REYNOLDS";
						$bcove_video = "26655782001";
						
						break;
						
					case 11:
						$trickname = "NO COMPLY";
						$personname = "GIOVANNI REDA";
						$bcove_video = "26663205001";
						
						break;
						
					case 12:
						$trickname = "NOLLIE BACKSIDE FLIP";
						$personname = "JIMMY CAO";
						$bcove_video = "26654877001";
						
						break;
						
					case 13:
						$trickname = "KICKFLIP";
						$personname = "LIZARD KING";
						$bcove_video = "26655772001";
						
						break;
						
					case 14:
						$trickname = "NOLLIE FLIP";
						$personname = "BENNY FAIRFAX";
						$bcove_video = "26654879001";
						
						break;
						
					case 15:
						$trickname = "BACKSIDE HEELFLIP";
						$personname = "JOEY BREZINSKI";
						$bcove_video = "26663206001";
						
						break;
						
					case 16:
						$trickname = "FRONTSIDE HALFCAB FLIP";
						$personname = "GREG LUTZKA";
						$bcove_video = "26654887001";
						
						break;
						
					case 17:
						$trickname = "NOLLIE BACKSIDE HEELFLIP";
						$personname = "CODY MCENTIRE";
						$bcove_video = "26655789001";
						
						break;
						
					case 18:
						$trickname = "HALFCAB HEELFLIP";
						$personname = "DANNY SUPA";
						$bcove_video = "25481800001";
						
						break;
						
					case 19:
						$trickname = "SWITCH BIGSPIN HEELFLIP";
						$personname = "BILLY MARKS";
						$bcove_video = "25482413001";
						
						break;
						
					case 20:
						$trickname = "NOLLIE CROOKED GRIND";
						$personname = "SIERRA FELLERS";
						$bcove_video = "25487903001";
						
						break;
						
					case 21:
						$trickname = "FRONTSIDE 360";
						$personname = "DANIEL CASTILLO";
						$bcove_video = "25487407001";
						
						break;
						
					case 22:
						$trickname = "BACKSIDE TAILSLIDE";
						$personname = "ERIC KOSTON";
						$bcove_video = "25487337001";
						
						break;
						
					case 23:
						$trickname = "FRONTSIDE NOLLIE HEELFLIP";
						$personname = "JAVIER NUNEZ";
						$bcove_video = "25487419001";
						
						break;
						
					case 24:
						$trickname = "FRONTSIDE NOSEBLUNTSLIDE";
						$personname = "JOSH KALIS";
						$bcove_video = "25487892001";
						
						break;
						
					case 25:
						$trickname = "BACKSIDE LIPSLIDE";
						$personname = "ELI REED";
						$bcove_video = "25487893001";
						
						break;
						
					case 26:
						$trickname = "FRONTSIDE OLLIE";
						$personname = "STEVE NESSER";
						$bcove_video = "25487390001";
						
						break;
						
					case 27:
						$trickname = "FRONTSIDE TAILSLIDE";
						$personname = "JERON WILSON";
						$bcove_video = "26453740001";
						
						break;
						
					case 28:
						$trickname = "BACKSIDE NOSEGRIND";
						$personname = "NICK MCLOUTH";
						$bcove_video = "26464052001";
						
						break;
							
					case 29:
						$trickname = "OLLIE";
						$personname = "ANDREW BROPHY";
						$bcove_video = "26464045001";
						
						break;
							
					case 30:
						$trickname = "FILMING";
						$personname = "CHASE GABOR";
						$bcove_video = "26453719001";
						
						break;	
					
					case 31:
						$trickname = "FRONTSIDE BIGSPIN";
						$personname = "JUSTIN BROCK";
						$bcove_video = "26446814001";
						
						break;	
					
					case 32:
						$trickname = "INWARD HEELFLIP";
						$personname = "WIEGER VAN WAGENINGEN";
						$bcove_video = "26532407001";
						
						break;	
					
					case 33:
						$trickname = "FRONTSIDE NOLLIE KICKFLIP";
						$personname = "SHANE O'NEILL";
						$bcove_video = "27282680001";
						
						break;
					
					case 34:
						$trickname = "FAKIE 5-0";
						$personname = "BEN FISHER";
						$bcove_video = "27222677001";
						
						break;
								
					case 35:
						$trickname = "SWITCH FRONTSIDE FLIP";
						$personname = "RODRIGO PETERSEN";
						$bcove_video = "28019489001";
						
						break;
								
					case 36:
						$trickname = "FRONTSIDE NOSESLIDE";
						$personname = "KARL WATSON";
						$bcove_video = "28664092001";
						
						break;
								
					case 37:
						$trickname = "KICKFLIP BS 50-50";
						$personname = "MANNY SANTIAGO";
						$bcove_video = "29376487001";
						
						break;
								
					case 38:
						$trickname = "FRONTSIDE LIPSLIDE";
						$personname = "HEATH KIRCHART";
						$bcove_video = "30113834001";
						
						break;
								
					case 39:
						$trickname = "HALFCAB FLIP";
						$personname = "DONOVAN STRAIN";
						$bcove_video = "31703191001";
						
						break;
								
					case 40:
						$trickname = "FRONTSIDE FEEBLE GRIND";
						$personname = "MIKEY TAYLOR";
						$bcove_video = "33195043001";
						
						break;
								
					case 41:
						$trickname = "FAKIE 360 FLIP";
						$personname = "MARK APPLEYARD";
						$bcove_video = "34348938001";
						
						break;
								
					case 42:
						$trickname = "BACKSIDE BLUNTSLIDE";
						$personname = "TOMMY SANDOVAL";
						$bcove_video = "35183366001";
						
						break;
								
					case 43:
						$trickname = "BACKSIDE WALLRIDE";
						$personname = "RICHIE JACKSON";
						$bcove_video = "36465949001";
						
						break;
								
					case 44:
						$trickname = "BACKSIDE HURRICANE";
						$personname = "PATRICK MELCHER";
						$bcove_video = "37794238001";
						
						break;
								
					case 45:
						$trickname = "FRONTSIDE SALAD GRIND";
						$personname = "GARETH STEHR";
						$bcove_video = "40161288001";
						
						break;
								
					case 46:
						$trickname = "SWITCH HEELFLIP";
						$personname = "JOSIAH GATLYN";
						$bcove_video = "42542428001";
						
						break;
								
					case 47:
						$trickname = "FAKIE KICKFLIP";
						$personname = "JOSH KALIS";
						$bcove_video = "43680618001";
						
						break;
								
					case 48:
						$trickname = "BACKSIDE NOSEBLUNTSLIDE";
						$personname = "KENNY ANDERSON";
						$bcove_video = "44599994001";
						
						break;
						
					case 49:
						$trickname = "BACKSIDE 360";
						$personname = "CHRIS COLE";
						$bcove_video = "45621197001";
						
						break;
						
					case 50:
						$trickname = "DOUBLE KICKFLIP";
						$personname = "KERRY GETZ";
						$bcove_video = "46467024001";
						
						break;
						
					case 51:
						$trickname = "NOLLIE FRONTSIDE NOSEGRIND";
						$personname = "MARQUISE HENRY";
						$bcove_video = "47746699001";
						
						break;
						
					case 52:
						$trickname = "SWITCH FRONTSIDE HEELFLIP";
						$personname = "BRANDON BIEBEL";
						$bcove_video = "49537584001";
						
						break;
						
					case 53:
						$trickname = "BACKSIDE FEEBLE GRIND";
						$personname = "ERIC KOSTON";
						$bcove_video = "53271467001";
						
						break;
						
					case 54:
						$trickname = "FRONTSIDE POP SHUVIT";
						$personname = "MARTY MURAWSKI";
						$bcove_video = "55099504001";
						
						break;
						
					case 55:
						$trickname = "FRONTSIDE CROOKED GRIND";
						$personname = "RYAN GALLANT";
						$bcove_video = "57232931001";
						
						break;
						
					case 56:
						$trickname = "NOLLIE";
						$personname = "TUUKKA KORHONEN";
						$bcove_video = "58452658001";
						
						break;
						
						
					case 57:
						$trickname = "BACKSIDE CROOKED GRIND";
						$personname = "GUY MARIANO";
						$bcove_video = "60383006001";
						
						break;
						
						
					case 58:
						$trickname = "FRONTSIDE SMITH GRIND";
						$personname = "RYAN SMITH";
						$bcove_video = "61353319001";
						
						break;
						
						
					case 59:
						$trickname = "NOLLIE HEELFLIP";
						$personname = "MATT MILLER";
						$bcove_video = "62234714001";
						
						break;
						
						
					case 60:
						$trickname = "NOLLIE FRONTSIDE 360";
						$personname = "PJ LADD";
						$bcove_video = "63320977001";
						
						break;
						
						
					case 61:
						$trickname = "BACKSIDE NOSESLIDE";
						$personname = "FELIX ARGUELLES";
						$bcove_video = "64437077001";
						
						break;
						
						
					case 62:
						$trickname = "FRONTSIDE 5-0 GRIND";
						$personname = "CHRIS ROBERTS";
						$bcove_video = "65670572001";
						
						break;
						
						
					case 63:
						$trickname = "BACKSIDE 5-0 GRIND";
						$personname = "CLINT PETERSON";
						$bcove_video = "66674173001";
						
						break;
						
						
					case 64:
						$trickname = "FAKIE BIGSPIN";
						$personname = "SPENCER HAMILTON";
						$bcove_video = "68082368001";
						
						break;
						
						
					case 65:
						$trickname = "SWITCH BACKSIDE FLIP";
						$personname = "LUCAS PUIG";
						$bcove_video = "70913359001";
						
						break;
						
						
					case 66:
						$trickname = "SWITCH 360 FLIP";
						$personname = "ZERED BASSETT";
						$bcove_video = "72201612001";
						
						break;
						
						
					case 67:
						$trickname = "NOSE MANUAL";
						$personname = "JOEY BREZINSKI";
						$bcove_video = "73283548001";
						
						break;
						
						
					case 68:
						$trickname = "PIVOT TO FAKIE";
						$personname = "CHANY JEANGUENIN";
						$bcove_video = "74576295001";
						
						break;
						
						
					case 69:
						$trickname = "SWITCH POP SHUVIT";
						$personname = "WILL FYOCK";
						$bcove_video = "76047919001";
						
						break;
						
						
					case 70:
						$trickname = "FAKIE MANUAL";
						$personname = "RONNIE CREAGER";
						$bcove_video = "77689385001";
						
						break;
						
						
					case 71:
						$trickname = "SWITCH BACKSIDE BIGSPIN";
						$personname = "WALKER RYAN";
						$bcove_video = "78976501001";
						
						break;
						
						
					case 72:
						$trickname = "LASER FLIP";
						$personname = "TOREY PUDWILL";
						$bcove_video = "80424018001";
						
						break;
						
						
					case 73:
						$trickname = "360 POP SHUVIT";
						$personname = "SHANE O'NEILL";
						$bcove_video = "82750083001";
						
						break;
						
						
					case 74:
						$trickname = "BACKSIDE 180 NOSEGRIND";
						$personname = "BRANDON DEL BIANCO";
						$bcove_video = "84506547001";
						
						break;
						
						
					case 75:
						$trickname = "HALF CAB";
						$personname = "MIKE VALLELY";
						$bcove_video = "86212590001";
						
						break;
						
						
					case 76:
						$trickname = "NOLLIE INWARD HEELFLIP";
						$personname = "BILLY MARKS";
						$bcove_video = "89215610001";
						
						break;
						
						
					case 77:
						$trickname = "SWITCH CROOKED GRIND";
						$personname = "CHAD TIM TIM";
						$bcove_video = "90527543001";
						
						break;
						
						
					case 78:
						$trickname = "NOLLIE LASER FLIP";
						$personname = "PRINCE GILCHRIST";
						$bcove_video = "96230110001";
						
						break;
						
						
					case 79:
						$trickname = "SWITCH HEELFLIP SHUVIT";
						$personname = "RICHARD ANGELIDES";
						$bcove_video = "97742151001";
						
						break;
						
						
					case 80:
						$trickname = "SWITCH BACKSIDE HEELFLIP";
						$personname = "ADELMO JR";
						$bcove_video = "105058086001";
						
						break;
						
						
					case 81:
						$trickname = "FRONTSIDE BOARDSLIDE";
						$personname = "MIKEY TAYLOR";
						$bcove_video = "109295653001";
						
						break;
						
						
					case 82:
						$trickname = "NOLLIE NOSESLIDE";
						$personname = "DANNY MONTOYA";
						$bcove_video = "180225674001";
						
						break;
						
						
					case 83:
						$trickname = "FAKIE BIGFLIP";
						$personname = "CHICO BRENES";
						$bcove_video = "272038880001";
						
						break;
						
						
					case 84:
						$trickname = "IMPOSSIBLE";
						$personname = "DAVID GONZALEZ";
						$bcove_video = "385276396001";
						
						break;
						
						
					case 85:
						$trickname = "SWITCH KICKFLIP";
						$personname = "STEFAN JANOSKI";
						$bcove_video = "497248516001";
						
						break;
						
						
					case 86:
						$trickname = "NOLLIE BACKSIDE 360";
						$personname = "KEVIN ROMAR";
						$bcove_video = "593479178001";
						
						break; 
						
						
					case 87:
						$trickname = "SWITCH FRONTSIDE TAILSLIDE";
						$personname = "KELLY HART";
						$bcove_video = "599649401001";
						
						break; 
						
						
					case 88:
						$trickname = "FAKIE BACKSIDE NOSEGRIND";
						$personname = "DARYL ANGEL";
						$bcove_video = "605087343001";
						
						break; 
						
						
					case 89:
						$trickname = "NOLLIE HARDFLIP";
						$personname = "FELIPE GUSTAVO";
						$bcove_video = "608590127001";
						
						break; 
						
						
					case 90:
						$trickname = "FAKIE FRONTSIDE NOSEGRIND";
						$personname = "BRANDON BIEBEL";
						$bcove_video = "613949735001";
						
						break; 
						
						
					case 91:
						$trickname = "SWITCH BACKSIDE TAILSLIDE";
						$personname = "MORGAN SMITH";
						$bcove_video = "619426331001";
						
						break; 
						
						
					case 92:
						$trickname = "CABALLERIAL";
						$personname = "ZACH LYONS";
						$bcove_video = "632232188001";
						
						break; 
						
						
					case 93:
						$trickname = "NOLLIE BIGSPIN HEELFLIP";
						$personname = "LEWIS MARNELL";
						$bcove_video = "640798947001";
						
						break; 
						
						
					case 94:
						$trickname = "FAKIE HEELFLIP";
						$personname = "LUIS TOLENTINO";
						$bcove_video = "648735932001";
						
						break; 
						
						
					case 95:
						$trickname = "NOLLIE 360 FLIP";
						$personname = "PAUL RODRIGUEZ";
						$bcove_video = "656541241001";
						
						break; 
						
						
					case 96:
						$trickname = "FRONTSIDE BLUNTSLIDE";
						$personname = "DARRELL STANTON";
						$bcove_video = "665092358001";
						
						break; 
						
						
					case 97:
						$trickname = "BACKSIDE OVERCROOK";
						$personname = "SEAN MALTO";
						$bcove_video = "676585947001";
						
						break; 
						
						
					case 98:
						$trickname = "BIGSPIN FLIP";
						$personname = "MARK APPLEYARD";
						$bcove_video = "684755585001";
						
						break; 
						
						
					case 99:
						$trickname = "FAKIE INWARD HEELFLIP";
						$personname = "DANNY SUPA";
						$bcove_video = "692359353001";
						
						break; 
						
						
					case 100:
						$trickname = "NOLLIE FRONTSIDE BOARDSLIDE";
						$personname = "KENNY HOYLE";
						$bcove_video = "701091369001";
						
						break; 
						
						
					case 101:
						$trickname = "SWITCH HARDFLIP";
						$personname = "RODRIGO TX";
						$bcove_video = "709791250001";
						
						break; 
						
						
					case 102:
						$trickname = "FRONTSIDE 180 NOSEGRIND";
						$personname = "JAMIE THOMAS";
						$bcove_video = "718589781001";
						
						break;  
						
						
					case 103:
						$trickname = "SWITCH FRONTSIDE BIGSPIN";
						$personname = "CHRIS TROY";
						$bcove_video = "726392157001";
						
						break;  
						
						
					case 104:
						$trickname = "FRONTSIDE BIGSPIN HEELFLIP";
						$personname = "JOHNNY LAYTON";
						$bcove_video = "737301414001";
						
						break;  
						
						
					case 105:
						$trickname = "FRONTSIDE HALF CAB HEELFLIP";
						$personname = "JIMMY CARLIN";
						$bcove_video = "753729592001";
						
						break;  
						
						
					case 106:
						$trickname = "FRONTSIDE HALF CAB NOSESLIDE";
						$personname = "PAUL SHIER";
						$bcove_video = "760800175001";
						
						break;  
						
						
					case 107:
						$trickname = "FAKIE FRONTSIDE CROOKED GRIND";
						$personname = "MIKE MO CAPALDI";
						$bcove_video = "773105762001";
						
						break;  
						
						
					case 108:
						$trickname = "NOLLIE 180 SWITCH CROOKED GRIND";
						$personname = "KARL WATSON";
						$bcove_video = "781191688001";
						
						break;  
						
						
					case 109:
						$trickname = "BENNETT GRIND";
						$personname = "MATT BENNETT";
						$bcove_video = "791212342001";
						
						break;  
						
						
					case 110:
						$trickname = "NOLLIE NOSE MANUAL";
						$personname = "ENRIQUE LORENZO";
						$bcove_video = "798533653001";
						
						break;  
						
						
					case 111 :
						$trickname = "KICKFLIP BACKSIDE NOSESLIDE";
						$personname = "TOM ASTA";
						$bcove_video = "807091410001";
						
						break;  
						
						
					case 112 :
						$trickname = "SWITCH FRONTSIDE 360";
						$personname = "LUAN OLIVEIRA";
						$bcove_video = "817639531001";
						
						break;  
						
						
					case 113 :
						$trickname = "FAKIE OLLIE TAILSLIDE";
						$personname = "RONNIE CREAGER";
						$bcove_video = "827372003001";
						
						break;  
						
						
					case 114 :
						$trickname = "FRONTSIDE DISASTER";
						$personname = "STEVE NESSER";
						$bcove_video = "847262656001";
						
						break;  
						
						
					case 115 :
						$trickname = "NOLLIE BACKSIDE 180";
						$personname = "DAVIS TORGERSON";
						$bcove_video = "867397458001";
						
						break;  
						
						
					case 116 :
						$trickname = "BACKSIDE DISASTER";
						$personname = "KENNY ANDERSON";
						$bcove_video = "900527584001";
						
						break;  
						
						
					case 117: 
						$trickname = "SWITCH FRONTSIDE POP SHUVIT";
						$personname = "SAMMY BAPTISTA";
						$bcove_video = "909908521001";
						
						break;
					case 118:
						$trickname = "FAKIE OLLIE BACKSIDE CROOKED GRIND";
						$personname = "KEVIN COAKLEY";
						$bcove_video = "919762885001";
			
					break;
						
						
				
				}
						
			return compact(
				
				"tid",
				"trickname",
				"personname",
				"bcove_video"
			
			);
		
		
	}
	
	public function import_tricks() {
		
		
		$this->loadModel("Dailyop");
		$this->loadModel("MediaFile");
		/*
		//grab all the trickpedia posts
		$posts = $this->Dailyop->find("all",array(
			
			"conditions"=>array(
				"DailyopSection.id"=>4
			),
			"contain"=>array(
				"DailyopSection",
				"DailyopMediaItem"=>array(
					"MediaFile"
				)
			)
		
		));
		*/
		
		///Grab The Trick

				$tid = 118;
				$trick = $this->grab_trick($tid);

				
				$mediaData = array(
					"MediaFile"=>array(
						"brightcove_id"=>$trick['bcove_video'],
						"name"=>$trick['trickname']." ".$trick['personname'],
						"media_type"=>"bcove"
					)
				);
				
				$this->MediaFile->create();
				$this->MediaFile->save($mediaData);
				
				$media_file_id = $this->MediaFile->id;
		
		/*
		foreach($posts as $p) {
		
			$uri = $p['DailyopMediaItem'][0]['MediaFile']['legacy_link'];

			//extract the tid from the url
			
			$qs = parse_url($uri,PHP_URL_QUERY);
			
			$tid = str_replace("tid=","",$qs);
			
			pr("Query String: ".$tid);
			
			if($tid > 1) {
				
				///Grab The Trick
				$trick = $this->grab_trick($tid);
				
				$mediaData = array(
					"MediaFile"=>array(
						"brightcove_id"=>$trick['bcove_video'],
						"name"=>$trick['trickname']." ".$trick['personname'],
						"media_type"=>"bcove"
					)
				);
				
				$this->MediaFile->create();
				$this->MediaFile->save($mediaData);
				
				$media_file_id = $this->MediaFile->id;
				
				
				
			}
			
		}
		
		*/
		
	}
	
	public function fix_media_file_name() {
		
		$this->loadModel("MediaFile");
		
		$videos = $this->MediaFile->find("all",array(
		
			"contain"=>array(
				"DailyopMediaItem"=>array("Dailyop")
			)
		
		));
		
		foreach($videos as $v) {
			
			$d = $v['DailyopMediaItem'][0]['Dailyop'];
			
			$this->MediaFile->create();
			$this->MediaFile->id = $v['MediaFile']['id'];
			
			$this->MediaFile->save(array(
				"preroll"=>1,
				"name"=>$d['name']." ".$d['sub_title']
			));
			
		}
		
		
	}
	
	
	public function ajax_insert_trick() {
		
		
		
	}
	
	
	
	public function fix_trickipedia() {
		
		
		$this->loadModel("Dailyop");
				
		$posts = $this->Dailyop->find("all",array(
		
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>4,
				"Dailyop.publish_date < NOW()",
				"Dailyop.active"=>1
			),
			"contain"=>array(
		
				"DailyopMediaItem"=>array(
		
					"MediaFile"=>array("User")	
		
				),
				"Meta"		
			
			),
			"order"=>array(
				
				"Dailyop.publish_date"=>"DESC"
			
			)

		));
		
		
		foreach($posts as $post) {
		
			$user = $post['DailyopMediaItem'][0]['MediaFile']['User'][0];
					
			$name = $user['first_name']." ".$user['last_name'];
			
			$meta = Set::extract("/Meta[key=/trick/i]/val",$post);
			
			$uri = Tools::safeUrl($meta[0]).".html";	
			
			$this->Dailyop->create();
			
			$this->Dailyop->id = $post['Dailyop']['id'];
			
			$this->Dailyop->save(array(
			
				"uri"=>$uri
			
			));
			
			echo $uri;
			echo "<br />";
			
		}
		
		
	}
	
	
	
	public function import_batb3() {
		
		
		$this->loadModel("MediaFile");
		$this->loadModel("Dailyop");
		
		for($i = 1; $i<=130; $i++) {
			
			
			
			$battle = $this->grab_battle($i);
			
			
			if(count($battle)>0) {
				
				
				$name = "BATB3 ".$battle['lefskater']." VS ".$battle['rigskater'];
				
				//check to see if we have the pregame
				if(isset($battle['pregame']) && !empty($battle['pregame'])) {
					
					//insert the pregame
					$this->MediaFile->create();
					
					$preGame = array(
						"brightcove_id"=>$battle['pregame'],
						"name"=>$name." PRE-GAME"
					);
					
					$this->MediaFile->save($preGame);
					
					$media_file_id = $this->MediaFile->id;
					
					$postData = array(
						"Dailyop"=>array(
							"name"=>"Battle at the Berrics 3 PRE-GAME",
							"sub_title"=>$battle['lefskater']." VS ".$battle['rigskater'],
							"publish_date"=>"2010-01-02 00:00:00"
						
					));
					
					
					$postData['Tag'] = $this->Dailyop->Tag->parseTags("battle at the berrics 3,".$battle['lefskater'].",".$battle['rigskater'].",pregame");
					
					
					$postData['DailyopMediaItem'] = array(
					
						"media_file_id"=>$media_file_id,
						"display_weight"=>1
					
					);
					
					$this->Dailyop->create();
					
					$this->Dailyop->save($postData);
					
					print "PreGame <br />";
					pr($postData);
					pr($preGame);
					
				}
				
				//check the battle
				if(isset($battle['battle']) && !empty($battle['battle'])) {
					
					
					$this->MediaFile->create();
					
					$battleVid =array(
						"brightcove_id"=>$battle['battle'],
						"name"=>$name." BATTLE"
					);
					
					$this->MediaFile->save($battleVid);
					
					$media_file_id = $this->MediaFile->id;
					//make the post
					$postData = array(
						"Dailyop"=>array(
							"name"=>"Battle at the Berrics 3 BATTLE",
							"sub_title"=>$battle['lefskater']." VS ".$battle['rigskater'],
							"publish_date"=>"2010-01-02 00:00:00"
						
					));
					
					$postData['Tag'] = $this->Dailyop->Tag->parseTags("battle at the berrics 3,".$battle['lefskater'].",".$battle['rigskater'].",battle");
					
					
					$postData['DailyopMediaItem'] = array(
					
						"media_file_id"=>$media_file_id,
						"display_weight"=>1
					
					);
					
					$this->Dailyop->create();
					
					$this->Dailyop->save($postData);
					print "Battle <br />";
					pr($postData);
					pr($battleVid);
					
					
				}
				
				//check for a post game video
				
				if(isset($battle['postgame']) && !empty($battle['postgame'])) {
					
					
					
					$this->MediaFile->create();
					
					$battleVid =array(
						"brightcove_id"=>$battle['postgame'],
						"name"=>$name." POST-GAME"
					);
					
					$this->MediaFile->save($battleVid);
					$media_file_id = $this->MediaFile->id;
					//make the post
					$postData = array(
						"Dailyop"=>array(
							"name"=>"Battle at the Berrics 3 POST-GAME",
							"sub_title"=>$battle['lefskater']." VS ".$battle['rigskater'],
							"publish_date"=>"2010-01-02 00:00:00"
						
					));
					
					$postData['Tag'] = $this->Dailyop->Tag->parseTags("battle at the berrics 3,".$battle['lefskater'].",".$battle['rigskater'].",postgame");
					
					
					$postData['DailyopMediaItem'] = array(
					
						"media_file_id"=>$media_file_id,
						"display_weight"=>1
					
					);
					$this->Dailyop->create();
					
					$this->Dailyop->save($postData);
					
					print "POST GAME <br />";
					pr($postData);
					pr($battleVid);	
					
				}
				
				
				
			}
			
			
			
			
		}
		
		die('');
		
	}
	
	

	public function grab_battle($bat) {
				switch ($bat) {
		
						case 1:
							// CHRIS COLE vs JOEY BREZINSKI
							$lefskater = "CHRIS COLE";
							$rigskater = "JOEY BREZINSKI";
							$pregame = "88749660001";
							$battle = "88866983001";
							$postgame = "88952333001";
							$lefboard = "dec_zero_cole";
							$rigboard = "dec_cli_joey1";
							$rigboardb = "dec_cli_joey2";
							break;
							
						case 2:
							// JOHNNY LAYTON vs DANNY GARCIA
							$lefskater = "JOHNNY LAYTON";
							$rigskater = "DANNY GARCIA";
							$pregame = "88954758001";
							$battle = "88956370001";
							$postgame = "89058198001";
							$lefboard = "dec_toy_jlay";
							$rigboard = "dec_hab_dgar";
							break;
							
						case 3:
							// GILBERT CROCKETT vs SHANE O'NEILL
							$lefskater = "GILBERT CROCKETT";
							$rigskater = "SHANE O'NEILL";
							$pregame = "90086309001";
							$battle = "90108513001";
							$postgame = "90196659001";
							$lefboard = "dec_aws_gilbert";
							$rigboard = "dec_skm_shane";
							break;
							
						case 4:
							// GREG LUTZKA vs ERIC KOSTON
							$lefskater = "GREG LUTZKA";
							$rigskater = "ERIC KOSTON";
							$pregame = "90191328001";
							$battle = "90206750001";
							$postgame = "90284267001";
							$lefboard = "dec_drk_lutzka";
							$rigboard = "dec_gir_koston";
							break;
							
						case 5:
							// BENNY FAIRFAX vs CESAR FERNANDEZ
							$lefskater = "BENNY FAIRFAX";
							$rigskater = "CESAR FERNANDEZ";
							$pregame = "91446963001";
							$battle = "91448090001";
							$postgame = "94524775001";
							$lefboard = "dec_ste_benny";
							$rigboard = "dec_rog_cesar";
							break;
							
						case 6:
							// JOSIAH GATLYN vs PJ LADD
							$lefskater = "JOSIAH GATLYN";
							$rigskater = "PJ LADD";
							$pregame = "94967587001";
							$battle = "94524774001";
							$postgame = "95047615001";
							$lefboard = "dec_ste_josiah";
							$rigboard = "dec_pla_pj01";
							$rigboardb = "dec_pla_pj02";
							$rigboardc = "dec_pla_pj03";
							break;
							
						case 7:
							// PAUL RODRIGUEZ vs SEAN MALTO
							$lefskater = "PAUL RODRIGUEZ";
							$rigskater = "SEAN MALTO";
							$pregame = "97243439001";
							$battle = "97262367001";
							$postgame = "97265459001";
							$lefboard = "dec_pla_prod";
							$rigboard = "dec_girl_malto";
							break;
							
						case 8:
							// CORY KENNEDY vs JIMMY CAO
							$lefskater = "CORY KENNEDY";
							$rigskater = "JIMMY CAO";
							$pregame = "97262369001";
							$battle = "97284420001";
							$postgame = "97284422001";
							$lefboard = "dec_girl_cory";
							$rigboard = "dec_sk8_jimmy";
							break;
							
						case 9:
							// MIKE MO CAPALDI vs PETER RAMONDETTA
							$lefskater = "MIKE MO CAPALDI";
							$rigskater = "PETER RAMONDETTA";
							$pregame = "103344835001";
							$battle = "103344830001";
				//			$postgame = "";
							$lefboard = "dec_girl_mikemo2";
							$rigboard = "dec_real_pete";
							break;
							
						case 10:
							// BRANDON BIEBEL vs MARK APPLEYARD
							$lefskater = "BRANDON BIEBEL";
							$rigskater = "MARK APPLEYARD";
							$pregame = "102900699001";
							$battle = "102906221001";
				//			$postgame = "";
							$lefboard = "dec_girl_biebel";
							$rigboard = "dec_thu_apples";
							break;
							
						case 11:
							// MARC JOHNSON vs RICK HOWARD
							$lefskater = "MARC JOHNSON";
							$rigskater = "RICK HOWARD";
							$pregame = "107236031001";
							$battle = "107250713001";
				//			$postgame = "";
							$lefboard = "dec_cho_mj";
							$rigboard = "dec_girl_rick";
							break;
							
						case 12:
							// MARTY MURAWSKI vs TOREY PUDWILL
							$lefskater = "MARTY MURAWSKI";
							$rigskater = "TOREY PUDWILL";
							$pregame = "107250729001";
							$battle = "107780776001";
							$postgame = "107706722001";
							$lefboard = "dec_blu_marty";
							$rigboard = "dec_pla_torey";
							break;
							
						case 13:
							// KELLY HART vs ERIK ELLINGTON
							$lefskater = "KELLY HART";
							$rigskater = "ERIK ELLINGTON";
							$pregame = "111317827001";
							$battle = "111310873001";
							$postgame = "111317828001";
							$lefboard = "dec_exp_kelly";
							$rigboard = "dec_dea_ellington";
							break;
							
						case 14:
							// BILLY MARKS vs DAVID GONZALEZ
							$lefskater = "BILLY MARKS";
							$rigskater = "DAVID GONZALEZ";
							$pregame = "111324639001";
							$battle = "111310872001";
				//			$postgame = "";
							$lefboard = "dec_toy_billy";
							$rigboard = "dec_flip_david01";
							$rigboardb = "dec_flip_david02";
							break;
							
						case 15:
							// CHICO BRENES vs DENNIS BUSENITZ
							$lefskater = "CHICO BRENES";
							$rigskater = "DENNIS BUSENITZ";
							$pregame = "129297201001";
							$battle = "129297352001";
							$postgame = "129297335001";
							$lefboard = "dec_cho_chico";
							$rigboard = "dec_real_busenitz";
							break;
							
						case 16:
							// STEVE BERRA vs HEATH KIRCHART
							$lefskater = "STEVE BERRA";
							$rigskater = "HEATH KIRCHART";
							$pregame = "142421612001";
							$battle = "142421611001";
							$postgame = "155399786001";
							$lefboard = "dec_aws_berra";
							$rigboard = "dec_aws_heath";
							break;
							
						case 17:
							// CHRIS COLE vs JOHNNY LAYTON
							$lefskater = "CHRIS COLE";
							$rigskater = "JOHNNY LAYTON";
							$pregame = "326300771001";
							$battle = "330286598001";
							$postgame = "326300781001";
							$lefboard = "dec_zero_cole";
							$rigboard = "dec_toy_jlay";
							break;
							
						case 18:
							// SHANE O'NEILL vs ERIC KOSTON
							$lefskater = "SHANE O'NEILL";
							$rigskater = "ERIC KOSTON";
							$pregame = "343001565001";
							$battle = "342980423001";
							$postgame = "342995042001";
							$lefboard = "dec_skm_shane";
							$rigboard = "dec_gir_koston2";
							break;
							
						case 19:
							// MARC JOHNSON vs TOREY PUDWILL
							$lefskater = "MARC JOHNSON";
							$rigskater = "TOREY PUDWILL";
							$pregame = "441755874001";
							$battle = "441755182001";
							$postgame = "472433663001";
							$lefboard = "dec_cho_mj";
							$rigboard = "dec_pla_torey";
							break;
							
						case 20:
							// PAUL RODRIGUEZ vs CHICO BRENES
							$lefskater = "PAUL RODRIGUEZ";
							$rigskater = "CHICO BRENES";
							$pregame = "458670033001";
							$battle = "458670032001";
							$postgame = "488229413001";
							$lefboard = "dec_pla_prod";
							$rigboard = "dec_cho_chico";
							break;
							
						case 21:
							// MIKE MO CAPALDI vs MARK APPLEYARD
							$lefskater = "MIKE MO CAPALDI";
							$rigskater = "MARK APPLEYARD";
							$pregame = "579550378001";
							$battle = "581589876001";
							$postgame = "579641882001";
							$lefboard = "dec_girl_mikemo2";
							$rigboard = "dec_thu_apples";
							break;
							
						case 22:
							// BENNY FAIRFAX vs PJ LADD
							$lefskater = "BENNY FAIRFAX";
							$rigskater = "PJ LADD";
							$pregame = "591069649001";
							$battle = "591069648001";
							$postgame = "591788390001";
							$lefboard = "dec_ste_benny";
							$rigboard = "dec_pla_pj02";
							$rigboardb = "dec_pla_pj03";
							break;
							
						case 23:
							// CORY KENNEDY vs KELLY HART
							$lefskater = "CORY KENNEDY";
							$rigskater = "KELLY HART";
							$pregame = "591851945001";
							$battle = "591851949001";
							$postgame = "591953011001";
							$lefboard = "dec_girl_cory";
							$rigboard = "dec_exp_kelly";
							break;
							
						case 24:
							// CHRIS COLE vs SHANE O'NEILL
							$lefskater = "CHRIS COLE";
							$rigskater = "SHANE O'NEILL";
							$pregame = "602818356001";
							$battle = "602818355001";
							$postgame = "602829417001";
							$lefboard = "dec_zero_cole";
							$rigboard = "dec_skm_shane";
							break;
							
						case 25:
							// DAVID GONZALEZ vs HEATH KIRCHART
							$lefskater = "DAVID GONZALEZ";
							$rigskater = "HEATH KIRCHART";
							$pregame = "606461033001";
							$battle = "606474305001";
							$postgame = "606472894001";
							$lefboard = "dec_flip_david01";
							$lefboardb = "dec_flip_david02";
							$rigboard = "dec_aws_heath";
							break;
							
						case 26:
							// PJ LADD vs CORY KENNEDY
							$lefskater = "PJ LADD";
							$rigskater = "CORY KENNEDY";
							$pregame = "607007602001";
							$battle = "607008891001";
							$postgame = "607597595001";
							$lefboard = "dec_pla_pj02";
							$lefboardb = "dec_pla_pj03";
							$rigboard = "dec_girl_cory";
							break;
							
						case 27:
							// MIKE MO CAPALDI vs TOREY PUDWILL
							$lefskater = "MIKE MO CAPALDI";
							$rigskater = "TOREY PUDWILL";
							$pregame = "610813777001";
							$battle = "610793734001";
							$postgame = "610813778001";
							$lefboard = "dec_girl_mikemo2";
							$rigboard = "dec_pla_torey";
							break;
							
						case 28:
							// PAUL RODRIGUEZ vs DAVID GONZALEZ
							$lefskater = "PAUL RODRIGUEZ";
							$rigskater = "DAVID GONZALEZ";
							$pregame = "616453139001";
							$battle = "616453142001";
							$postgame = "616455745001";
							$lefboard = "dec_pla_prod";
							$rigboard = "dec_flip_david01";
							$rigboardb = "dec_flip_david02";
							break;
				
						case 29:
							// SHANE O'NEILL vs PJ LADD
							$lefskater = "SHANE O'NEILL";
							$rigskater = "PJ LADD";
							$pregame = "621892125001";
							$battle = "621923864001";
				//			$postgame = "0000";
							$lefboard = "dec_skm_shane";
							$rigboard = "dec_pla_pj01";
							break;
							
						case 30:
							// TOREY PUDWILL vs PAUL RODRIGUEZ
							$lefskater = "TOREY PUDWILL";
							$rigskater = "PAUL RODRIGUEZ";
							$pregame = "621923865001";
							$battle = "621892122001";
				//			$postgame = "0000";
							$lefboard = "dec_pla_torey";
							$rigboard = "dec_pla_prod";
							break;
							
						case 31:
							// SHANE O'NEILL vs TOREY PUDWILL
							$lefskater = "SHANE O'NEILL";
							$rigskater = "TOREY PUDWILL";
				//			$pregame = "625417708001";
							$battle = "621892121001";
				//			$postgame = "0000";
							$lefboard = "dec_skm_shane";
							$rigboard = "dec_pla_torey";
							break;
							
						case 32:
							// PJ LADD VS PAUL RODRIGUEZ
							$lefskater = "PJ LADD";
							$rigskater = "PAUL RODRIGUEZ";
							$pregame = "621923867001";
							$battle = "622785935001";
							$postgame = "622777688001";
							$lefboard = "dec_pla_pj01";
							$rigboard = "dec_pla_prod";
							break;
							
						// UNSANCTIONED EVENTS	
						case 100:
							// STEVE BERRA vs BILLY MARKS
							$lefskater = "STEVE BERRA";
							$rigskater = "BILLY MARKS";
							$battle = "111741420001";
							$lefboard = "dec_aws_berra";
							$rigboard = "dec_toy_billy";
							break;
							
						case 101:
							// JOEY BREZINSKI vs CHICO BRENES
							$lefskater = "JOEY BREZINSKI";
							$rigskater = "CHICO BRENES";
							$battle = "597347448001";
							$lefboard = "dec_cli_joey01";
							$rigboard = "dec_cho_chico";
							break;
							
						case 102:
							// PJ LADD vs RONNIE CREAGER
							$lefskater = "PJ LADD";
							$rigskater = "RONNIE CREAGER";
							$battle = "597337067001";
							$lefboard = "dec_pla_pj02";
							$rigboard = "dec_fill";
							break;
							
						case 103:
							// CHICO BRENES vs PJ LADD
							$lefskater = "CHICO BRENES";
							$rigskater = "PJ LADD";
							$battle = "597337072001";
							$lefboard = "dec_cho_chico";
							$rigboard = "dec_pla_pj03";
							break;		
				
				

				
		}
		
			$c = compact(
							"lefskater",
							"rigskater",
							"pregame",
							"battle",
							"postgame",
							"lefboard",
							"rigboard"
				);	
				return $c;
			if(count($c)>0) {
				
				return $c;
				
			} else {
				
				return false;
				
			}
				
	}
	
	
	public function import_old_images() {
		
		
		
		$this->loadModel("MediaFile");
		
		$vids = $this->MediaFile->find("all",array(
		
			"conditions"=>array(
				"MediaFile.process_flv"=>1,
				"MediaFile.file LIKE"=>"%.swf",
				"MediaFile.media_type"=>"bcove"
			),
			"contain"=>array()
		
		));
		//die(pr($vids));
		//path to images
		$tmpPath = "/tmp/legacy.stills/";
		$imgPath = "/home/sites/berrics/img.theberrics.com/public_html/video/stills/";
		
		foreach($vids as $vid) {
			
			///get the extension
			$match = str_replace(".swf",".jpg",$vid['MediaFile']['file']);
			$match = str_replace("swf/","",$match);

			
			$newFile = $vid['MediaFile']['id'].".jpg";

			//copy the new file
			//if(!copy($tmpPath.$match,$imgPath.$newFile)) die("FUCK!");
				
			//exec("cp {$tmpPath}{$match} {$imgPath}{$newFile}");
			
			//print "cp {$tmpPath}{$match} {$imgPath}{$newFile}";
			//update the media file
			
			$this->MediaFile->create();
			
			$this->MediaFile->id = $vid['MediaFile']['id'];
			
			$this->MediaFile->save(array(
			
				"file_video_still"=>$match
			
			));
			
			
			print "Media FIle: ".$newFile;
			print "<br />";
			
		
			
			
		}
		
	}
	
	
	
	public function fix_reda_urls() {
		
		$this->loadModel("Dailyop");
		
		
		$posts = $this->Dailyop->find("all",array(
		
			"conditions"=>array(
		
				"Dailyop.dailyop_section_id"=>3	
		
			),
			"contain"=>array()
		
		));
		
		
		
		foreach($posts as $post) {
			
			
		//	$uri = date("M-",strtotime($post['Dailyop']['publish_date'])).date("Y",strtotime($post['Dailyop']['publish_date']))."-".$post['Dailyop']['uri'];
			
			
			//$uri = strtolower($post['Dailyop']['uri']);
			
			//$uri = str_replace("wednesdays-with-reda","",$post['Dailyop']['uri']);
			
			$uri = date("M-d-Y-h",strtotime($post['Dailyop']['publish_date']))."-".$post['Dailyop']['sub_title'];
			
			$uri = Tools::safeUrl($uri).".html";
			
			$this->Dailyop->create();
			
			$this->Dailyop->id = $post['Dailyop']['id'];
			
			$this->Dailyop->save(array(
			
				"uri"=>$uri
			
			));
			
			
		}
		
		
		
		
	}
	
	public function grab_battle4($id = false) {
		
		
		switch ($id) {
				case 101:
					$skaters = "ISHOD WAIR vs SHANE O'NEILL";
					$pregame = "814602980001";
					$battle = "814579435001";
					break;
				case 102:
					$skaters = "DAVIS TORGERSON vs SEWA KROETKOV";
					$pregame = "814579386001";
					$battle = "814579433001";
					break;
				case 103:
					$skaters = "PETER RAMONDETTA vs RODRIGO TX";
					$pregame = "823099029001";
					$battle = "823099037001";
					break;
				case 104:
					$skaters = "ERIC KOSTON vs MARK APPLEYARD";
					$pregame = "824195961001";
					$battle = "824195956001";
					break;
				case 105:
					$skaters = "BILLY MARKS vs BENNY FAIRFAX";
					$pregame = "837144957001";
					$battle = "837496395001";
					break;
				case 106:
					$skaters = "DENNIS BUSENITZ vs WADE DESARMO";
					$pregame = "837144953001";
					$battle = "837496392001";
					break;
				case 107:
					$skaters = "TOREY PUDWILL vs LUAN OLIVEIRA";
					$pregame = "856957246001";
					$battle = "856957244001";
					break;
				case 108:
					$skaters = "PJ LADD vs ALBERT NYBERG";
					$pregame = "856957245001";
					$battle = "856650990001";
					break;
				case 109:
					$skaters = "CORY KENNEDY vs DAVID GONZALEZ";
					$pregame = "877794776001";
					$battle = "877864555001";
					break;
				case 110:
					$skaters = "TOMMY SANDOVAL vs MORGAN SMITH";
					$pregame = "877864556001";
					$battle = "877864553001";
					break;
				case 111:
					$skaters = "TOM ASTA vs ALEX MIZUROV";
					$pregame = "897697817001";
					$battle = "897733820001";
					break;
				case 112:
					$skaters = "CHRIS COLE vs WILLOW";
					$pregame = "897697812001";
					$battle = "898544207001";
					break;
				case 113:
					$skaters = "PAUL RODRIGUEZ vs DANILO CEREZINI";
					$pregame = "906442448001";
					$battle = "906442445001";
					break;
				case 114:
					$skaters = "RONNIE CREAGER vs ENRIQUE LORENZO";
					$pregame = "906449705001";
					$battle = "906424891001";
					break;
				case 115:
					$skaters = "MIKEMO CAPALDI vs LEM VILLEMIN";
					$pregame = "915576050001";
					$battle = "915543558001";
					break;
				case 116:
					$skaters = "JIMMY CARLIN vs FELIPE GUSTAVO";
					$pregame = "915543576001";
					$battle = "915543557001";
				break;
					
				case 201:
					$skaters = "ERIC KOSTON vs DENNIS BUSENITZ";
					$pregame = "934537560001";
					$battle = "934544985001";
				break;
				case 202:
					$skaters = "CHRIS COLE vs BENNY FAIRFAX";
					$pregame = "935294751001";
					$battle = "935271735001";
				break;
				case 203;
					$skaters = "DAVIS TORGERSON vs SHANE O'NEILL";
					$pregame = "943303961001";
					$battle = "943302591001";
				break;
				case 204:
					$skaters = "MORGAN SMITH vs ALEX MIZUROV";
					$pregame = "944262985001";
					$battle = "944284476001";
				break;
					
			
				default:
					$skaters = false;
					$pregame = false;
					$battle = false;
				break;
		}
					
		return compact("skaters","pregame","battle");
		
	}
	
	public function import_batb4() {
			
		$this->loadModel("MediaFile");
		
		for($i = 100;$i<250;$i++) {
			
			$battle = $this->grab_battle4($i);
			
			if(!empty($battle['skaters'])) {
				
				$this->MediaFile->create();
				
				$this->MediaFile->save(array(
				
					"name"=>$battle['skaters']." PREGAME",
					"brightcove_id"=>$battle['pregame'],
					"media_type"=>"bcove"
				));
				
				
				$this->MediaFile->create();
				
				$this->MediaFile->save(array(
					"name"=>$battle['skaters']." Battle",
					"brightcove_id"=>$battle['battle'],
					"media_type"=>"bcove"
				));
				
				
			}
			
			
		}
		
	}
	
	
	public function fix_email_urls() {
		
		$this->loadModel("Dailyop");
		
		//15
		
		$posts = $this->Dailyop->find("all",array(
		
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>15
			),
			"contain"=>array()
		
		));
		
		foreach($posts as $v) {
			
			
			
			$uri = Tools::safeUrl(date("F-jS-Y",strtotime($v['Dailyop']['publish_date']))).".html";
			
			$this->Dailyop->create();
			$this->Dailyop->id = $v['Dailyop']['id'];
			
			$this->Dailyop->save(array(
			
				"uri"=>$uri
			
			));
			
		}
		
		
		
	}
	
	
	
}


?>