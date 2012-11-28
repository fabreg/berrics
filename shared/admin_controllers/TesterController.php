<?php

App::import("Controller","LocalApp");

class TesterController extends LocalAppController {
	
	public $uses = array();
	
	public $components = array("Email");
	
	public function beforeFilter() {

		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
		$this->initPermissions();
		
		if(!isset($_SERVER['DEVSERVER'])) {
			
			//die(":=)");
			
		}
		
	}
	
	public function test_dom() {
		
		$str = "
		
			<html>
				<body>
					<DailyopsPost>1252</DailyopsPost>
				</body>
			</html>
		
		";
		
		$dom = new DOMDocument();
		
		@$dom->loadHTML($str);
		
		$dailyops = $dom->getElementsByTagName("dailyopspost");
		
		die(print_r($dailyops));
		
		
	}
	
	public function dump_session() {
		
		
		die(pr($this->Session->read()));
		
	}
	
	public function check_session($cookie = false) {
		

		die(json_encode($this->Auth->user()));
		
	}
	
	public function flex() {
		
		$this->loadModel("User");
		
		$data = $this->User->find("all",array(
		
			"contain"=>array(),
			"limit"=>100
		
		));
				
		die(json_encode($data));
	
	}
	
	
	public function email() {
		
		App::import("Component","Email");
		App::import("Controller","Controller");
		
		$this->loadModel("EmailMessage");
		
		$email =& new EmailComponent(null);
		$ctr =& new Controller();
		$email->initialize($ctr);
		
		$msg = $this->EmailMessage->find("all");
		
		foreach($msg as $m) {
			
			
			$email->reset();
			
			$email->to = $m['CanteenOrder']['email'];
			$email->subject = "Canteen Order Confirmation";
			$email->from = "Do Not Reply <noreply@theberrics.com>";
			$email->template = $m['EmailMessage']['template'];
			$email->sendAs = "html";
			$ctr->set(compact("m"));
			$email->send();
			die();
		}	
		
		//die(pr($this->Session->read()));
	}
	
	public function dfp() {
		
		App::import("Vendor","DFPUser",array("file"=>"Google/Api/Ads/Dfp/Lib/DfpUser.php"));
		$path = dirname(__FILE__) . '/../../..';
		set_include_path(get_include_path() . PATH_SEPARATOR . $path);
			try {
		  // Get DfpUser from credentials in "../auth.ini"
		  // relative to the DfpUser.php file's directory.
		  $user = new DfpUser();
		
		  // Log SOAP XML request and response.
		  $user->LogDefaults();
		
		  // Get the CreativeService.
		  $creativeService = $user->GetCreativeService('v201104');
		
		  // Set the ID of the advertiser (company) that all creatives will be
		  // assigned to.
		  $advertiserId = (float) '1917';
		
		  // Create an array to store local image creative objects.
		  $imageCreatives = array();
		
		  for ($i = 0; $i < 5; $i++) {
		    $imageCreative = new ImageCreative();
		    $imageCreative->name = 'Image creative #' . $i;
		    $imageCreative->advertiserId = $advertiserId;
		    $imageCreative->destinationUrl = 'http://google.com';
		    $imageCreative->imageName = 'image.jpg';
		    $imageCreative->imageByteArray =
		        MediaUtils::GetBase64Data('http://www.google.com/intl/en/adwords/'
		            . 'select/images/samples/inline.jpg');
		    $imageCreative->size = new Size(300, 250);
		
		    $imageCreatives[] = $imageCreative;
		  }
		
		  // Create the image creatives on the server.
		  $imageCreatives = $creativeService->createCreatives($imageCreatives);
		
		  // Display results.
		  if (isset($imageCreatives)) {
		    foreach ($imageCreatives as $creative) {
		      // Use instanceof to determine what type of creative was returned.
		      if ($creative instanceof ImageCreative) {
		        print 'An image creative with ID "' . $creative->id
		            . '", name "' . $creative->name
		            . '", and size {' . $creative->size->width
		            . ', ' . $creative->size->height . "} was created and\n"
		            . ' can be previewed at: ' . $creative->previewUrl . "\n";
		      } else {
		        print 'A creative with ID "' . $creative->id
		            . '", name "' . $creative->name
		            . '", and type "' . $creative->CreativeType
		            . "\" was created.\n";
		      }
		    }
		  } else {
		    print "No creatives created.\n";
		  }
		} catch (Exception $e) {
		  print $e->getMessage() . "\n";
		}
				
	}
	
	
	public function batb() {
		
		//get all the batb 4 post
		
		$this->loadModel("Dailyop");
		$this->loadModel("MediaFile");
		$posts = $this->Dailyop->find("all",array(
		
			
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>7
			),
			"contain"=>array(
			
				"DailyopMediaItem"=>array(
					"MediaFile"
				)
			
			)
		
		
		));
		
		$ids = Set::extract("/DailyopMediaItem/MediaFile/id",$posts);
		
		foreach($ids as $id) {
			
			$this->MediaFile->create();
			$this->MediaFile->id = $id;
			$this->MediaFile->save(array(
			
				"preroll"=>"BATB4PreRoll"
			
			));
			
			
		}
		
	}
	
	function json() {
		
		
		$str="preRoll({ pixel:'http://pagead2.googlesyndication.com/pagead/imgad/CAAyCFxjiFjFFVlZQNjl6ewE/879366/dot.gif', video:'http://dev.theberrics.com/file/telegraph_postroll.mp4', click:'http://adclick.g.doubleclick.net/aclk%3Fsa%3Dl%26ai%3DBU4Y783KaTYqeE4axcN24-M4HAQB7ABABGAEguWAoBDABOAFQwJmG3gVYnpGU-SqIAQGQAQCyAQpnb29nbGUuY29tugEJNzI4eDkwX2FzwAECyAEJ2gEnaHR0cDovL3d3dy5nb29nbGUuY29tL2FkbWFuYWdlci9wcmV2aWV3wAIC4AIBqAMBuAQB%26preview%3D%26num%3D1%26sig%3DAGiWqtxpr0Bo2fk4090kWBvGOXjOy7UMag%26client%3Dca-gfp-rama1%26adurl%3Dhttp://www.yahoo.com' });";
		
		header("Content-type:text/javascript");
		
		die($str);
		
	}
	
	
	public function index() {
		
		$bc = BCAPI::instance();
		
		$test = $bc->bc->find("videobyid",array("video_id"=>801201216001));
		
		die(pr($test));
		
		pr($bc);
		
		
	}
	
	public function info() {
		
		die(phpinfo());
		
	}
	
	public function thumb() {
		
		
		
		
	}
	
	public function bc() {
		
		$this->loadModel("MediaFile");
		
		$bc = BCAPI::instance();
		
		//upload a video
		
		$file = "/tmp/chaz.mp4";
		
		
		try {
			
			$res = $bc->bc->createMedia("video",$file,array("name"=>"Testing","H264NoProcessing"=>TRUE),array("H264NoProcessing"=>TRUE,"preserve_source_rendition"=>TRUE));
			
		}
		
		catch(BCMAPIException $e) {
			
			pr($e);
			
		}
		
		$this->MediaFile->create();
		
		$this->MediaFile->save(array(
			"name"=>"Testing 2",
			"brightcove_id"=>$res,
			"media_type"=>"bcove"
		
		));
		
		pr($res);
		
	}
	
	public function page_views($date = false) {
	
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		
		$this->loadModel("FactPageView");
		$this->loadModel("PageView");
		$this->loadModel("DimLocation");
		$this->loadModel("DimRequest");
		$this->loadModel("DimDmaCode");
		$this->loadModel("DimDate");
		$this->loadModel("DimDomain");
		
		ini_set('memory_limit', '512M');
		set_time_limit(0);
		
		$this->run_etl();
		
		$loop = true;
		
		while($loop) {
			
			AppModel::$forceMaster = true;
			
			$pageViews = $this->PageView->find("all",array(
		
				"conditions"=>array(
				"DATE(PageView.created) = '{$date}'"
				),
				"limit"=>5000,
				"order"=>array("PageView.created"=>"DESC")
			
			));
			
			if(count($pageViews)>0) {
				
				//lets process the rows
				foreach($pageViews as $p) {
					
					$row = array();
					
					//set some of the data
					$row['session'] = $p['PageView']['session'];
					
					if(empty($row['session'])) {
						
						continue;
						
					}
					
					$row['mobile'] = $p['PageView']['mobile'];
					
					$row['legacy_id'] = $p['PageView']['id'];
					
					//locate DimLocation
					$row['dim_location_id'] = $this->DimLocation->returnLocationId($p['PageView']['geo_country'],$p['PageView']['geo_region']);
					
					//locate Dim Request
					$row['dim_request_id'] = $this->DimRequest->returnRequestId($p['PageView']['domain_name'].$p['PageView']['script_url']);
					
					//Locate Dim Date
					$row['dim_date_id'] = $this->DimDate->returnDateId($p['PageView']['created']);
					
					$row['dim_domain_id'] = $this->DimDomain->returnDomainId($p['PageView']['domain_name']);
					
					if(!empty($p['PageView']['geo_dma_code'])) {
								
						$row['dim_dma_code_id'] = $this->DimDmaCode->returnDmaCodeId($p['PageView']['geo_dma_code']);
						
					}
					
					$this->FactPageView->create();
					
					$this->FactPageView->save($row);
					
					
				}
				
				$this->PageView->query(
					"DELETE FROM page_views WHERE DATE(created) = '{$date}' ORDER BY created DESC LIMIT 5000"
				);
				
				$this->mem();
				unset($pageViews);
				$this->mem();
				//die("stop".memory_get_usage());
				
				
			} else {
				
				$loop = false;
				continue;
				
			}
			
				
		}
		
		
		echo memory_get_peak_usage();
		//die(pr($pageViews));
		
		
		//die(pr($requests));
		
		

		return $this->render();
		die(pr($data));
		
		
	}
	
	private function run_etl($date = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		
		//populate the dimensions
		$this->populateDimDomains($date);
		$this->populateDimLocations($date);
		$this->populateDimDates($date);
		$this->populateDimRequests($date);
		
		//extract traffic rows and build relationships
		
		
		
		
	}
	
	public function populateFactPageViews($date = false) {
		
		
		
	}
	
	
	private function populateDimDomains($date = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		
		$this->mem();
		
		$this->loadModel("PageView");
		
		$this->loadModel("DimDomain");

		//get the distint domain names from the page views
		
		$domains = $this->PageView->query(
			"SELECT distinct(domain_name) FROM page_views WHERE DATE(created) = '{$date}'"
		);
		
		foreach($domains as $domain) {
			
			//check the table
			$check = $this->DimDomain->find("first",array(
				
				"conditions"=>array(
					"DimDomain.domain_name"=>$domain['page_views']['domain_name']
				)
			
			));
			
			if(empty($check['DimDomain']['id'])) {
				
				$this->DimDomain->create();
				$this->DimDomain->save(array(
				
					"domain_name"=>$domain['page_views']['domain_name']
					
				));
				
			}
			
			unset($check);
			
			
		}
		
		unset($domains);
		
	}
	
	
	private function populateDimLocations($date = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		
		$this->loadModel("PageView");
		
		$this->loadModel("DimLocation");
		
		$locs = $this->PageView->query(
		
			"SELECT DISTINCT(geo_region),geo_country,geo_region_name FROM page_views WHERE DATE(created) = '{$date}'"
		
		);
		
		foreach($locs as $loc) {
			
			$check = $this->DimLocation->find("first",array(
			
				"conditions"=>array(
					"DimLocation.country_code"=>$loc['page_views']['geo_country'],
					"DimLocation.region_name"=>$loc['page_views']['geo_region_name'],
					"DimLocation.region_code"=>$loc['page_views']['geo_region']
				)
			
			));
			
			if(empty($check['DimLocation']['id'])) {
				$this->DimLocation->create();
			
				$this->DimLocation->save(array(
			
					"country_code"=>$loc['page_views']['geo_country'],
					"region_name"=>$loc['page_views']['geo_region_name'],
					"region_code"=>$loc['page_views']['geo_region']
				
				));
					
			}
			
			unset($check);
			
		}
		$this->mem();
		unset($locs);
		$this->mem();	
	}
	
	private function populateDimDates($date = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		
		$this->loadModel("PageView");
		
		$this->loadModel("DimDate");
		
		$hour = 0;
		
		for($hour = 0;$hour <= 23; $hour++) {
			
			
			$hrf = str_pad($hour, 2, 0, STR_PAD_LEFT);
			
			$day = date("d",strtotime($date));
			
			$month = date("m",strtotime($date));
			
			$year = date("Y",strtotime($date));
			
			$check = $this->DimDate->find('first',array(
				
				"conditions"=>array(
			
					"DimDate.report_hour"=>$hrf,
					"DimDate.report_month"=>$month,
					"DimDate.report_year"=>$year,
					"DimDate.report_day"=>$day		
			
				)
			
			));
			
			
			if(empty($check['DimDate']['id'])) {
				
				
				$this->DimDate->create();
				
				$this->DimDate->save(array(
				
					"report_date"=>$date,
					"report_hour"=>$hrf,
					"report_month"=>$month,
					"report_day"=>$day,
					"report_year"=>$year
				
				));
				
			}
			
			
			
		}
		
		
		
	}
	
	
	private function populateDimRequests($date = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
			$this->mem();
		
		$this->loadModel("DimRequest");
		$this->loadModel("PageView");
		
		$requests = $this->PageView->query(
			"select distinct(script_url),domain_name FROM page_views where DATE(created) = '{$date}'"
		);
		
		//die(pr($requests));
		
		foreach($requests as $req) {
			
			//do a row check
			
			$check = $this->DimRequest->find("first",array(
				"conditions"=>array(
					"DimRequest.request_uri"=>$req['page_views']['domain_name'].$req['page_views']['script_url']
				)
			));
			
			if(empty($check['DimRequest']['id'])) {
				
				
				$this->DimRequest->create();
				
				$this->DimRequest->save(array(
					"request_uri"=>$req['page_views']['domain_name'].$req['page_views']['script_url']
				));
				
				
			}
			
			
		}
			$this->mem();
		
		unset($requests);
			$this->mem();
		
	}
	
	
	public function dma() {
		
		$str ='662,ABILENE-SWEETWATER
525,ALBANY GA
532,ALBANY-SCHENECTADY-TROY
790,ALBUQUERQUE-SANTA FE
644,ALEXANDRIA LA
583,ALPENA
634,AMARILLO
743,ANCHORAGE
524,ATLANTA
520,AUGUSTA
635,AUSTIN
800,BAKERSFIELD
512,BALTIMORE
537,BANGOR
716,BATON ROUGE
692,BEAUMONT-PORT ARTHUR
821,BEND OR
756,BILLINGS
746,BILOXI-GULFPORT
502,BINGHAMTON
630,BIRMINGHAM (ANN AND TUSC)
559,BLUEFIELD-BECKLEY-OAK HILL
757,BOISE
506,BOSTON (MANCHESTER)
736,BOWLING GREEN
514,BUFFALO
523,BURLINGTON-PLATTSBURGH
754,BUTTE-BOZEMAN
767,CASPER-RIVERTON
637,CEDAR RAPIDS-WTRLO-IWC&DUB
648,CHAMPAIGN&SPRNGFLD-DECATUR
519,CHARLESTON SC
564,CHARLESTON-HUNTINGTON
517,CHARLOTTE
584,CHARLOTTESVILLE
575,CHATTANOOGA
759,CHEYENNE-SCOTTSBLUFF
602,CHICAGO
868,CHICO-REDDING
515,CINCINNATI
598,CLARKSBURG-WESTON
510,CLEVELAND-AKRON (CANTON)
752,COLORADO SPRINGS-PUEBLO
546,COLUMBIA SC
604,COLUMBIA-JEFFERSON CITY
522,COLUMBUS GA (OPELIKA AL)
535,COLUMBUS OH
673,COLUMBUS-TUPELO-WEST POINT
600,CORPUS CHRISTI
623,DALLAS-FT. WORTH
682,DAVENPORT-R.ISLAND-MOLINE
542,DAYTON
751,DENVER
679,DES MOINES-AMES
505,DETROIT
606,DOTHAN
676,DULUTH-SUPERIOR
765,EL PASO (LAS CRUCES)
565,ELMIRA (CORNING)
516,ERIE
801,EUGENE
802,EUREKA
649,EVANSVILLE
745,FAIRBANKS
724,FARGO-VALLEY CITY
513,FLINT-SAGINAW-BAY CITY
866,FRESNO-VISALIA
571,FT. MYERS-NAPLES
670,FT. SMITH-FAY-SPRNGDL-RGRS
509,FT. WAYNE
592,GAINESVILLE
798,GLENDIVE
773,GRAND JUNCTION-MONTROSE
563,GRAND RAPIDS-KALMZOO-B.CRK
755,GREAT FALLS
658,GREEN BAY-APPLETON
518,GREENSBORO-H.POINT-W.SALEM
545,GREENVILLE-N.BERN-WASHNGTN
567,GREENVLL-SPART-ASHEVLL-AND
647,GREENWOOD-GREENVILLE
636,HARLINGEN-WSLCO-BRNSVL-MCA
566,HARRISBURG-LNCSTR-LEB-YORK
569,HARRISONBURG
533,HARTFORD & NEW HAVEN
710,HATTIESBURG-LAUREL
766,HELENA
744,HONOLULU
618,HOUSTON
691,HUNTSVILLE-DECATUR (FLOR)
758,IDAHO FALLS-POCATELLO (JCKSN)
527,INDIANAPOLIS
718,JACKSON MS
639,JACKSON TN
561,JACKSONVILLE
574,JOHNSTOWN-ALTOONA-ST COLGE
734,JONESBORO
603,JOPLIN-PITTSBURG
747,JUNEAU
616,KANSAS CITY
557,KNOXVILLE
702,LA CROSSE-EAU CLAIRE
582,LAFAYETTE IN
642,LAFAYETTE LA
643,LAKE CHARLES
551,LANSING
749,LAREDO
839,LAS VEGAS
541,LEXINGTON
558,LIMA
722,LINCOLN & HASTINGS-KRNY
693,LITTLE ROCK-PINE BLUFF
803,LOS ANGELES
529,LOUISVILLE
651,LUBBOCK
503,MACON
669,MADISON
737,MANKATO
553,MARQUETTE
813,MEDFORD-KLAMATH FALLS
640,MEMPHIS
711,MERIDIAN
528,MIAMI-FT. LAUDERDALE
617,MILWAUKEE
613,MINNEAPOLIS-ST. PAUL
687,MINOT-BISMARCK-DICKINSON
762,MISSOULA
686,MOBILE-PENSACOLA (FT WALT)
628,MONROE-EL DORADO
828,MONTEREY-SALINAS
698,MONTGOMERY-SELMA
570,MYRTLE BEACH-FLORENCE
659,NASHVILLE
622,NEW ORLEANS
501,NEW YORK
544,NORFOLK-PORTSMTH-NEWPT NWS
740,NORTH PLATTE
633,ODESSA-MIDLAND
650,OKLAHOMA CITY
652,OMAHA
534,ORLANDO-DAYTONA BCH-MELBRN
631,OTTUMWA-KIRKSVILLE
632,PADUCAH-CAPE GIRARD-HARSBG
804,PALM SPRINGS
656,PANAMA CITY
597,PARKERSBURG
675,PEORIA-BLOOMINGTON
504,PHILADELPHIA
753,PHOENIX (PRESCOTT)
508,PITTSBURGH
820,PORTLAND OR
500,PORTLAND-AUBURN
552,PRESQUE ISLE
521,PROVIDENCE-NEW BEDFORD
717,QUINCY-HANNIBAL-KEOKUK
560,RALEIGH-DURHAM (FAYETVLLE)
764,RAPID CITY
811,RENO
556,RICHMOND-PETERSBURG
573,ROANOKE-LYNCHBURG
538,ROCHESTER NY
611,ROCHESTR-MASON CITY-AUSTIN
610,ROCKFORD
862,SACRAMNTO-STKTON-MODESTO
576,SALISBURY
770,SALT LAKE CITY
661,SAN ANGELO
641,SAN ANTONIO
825,SAN DIEGO
807,SAN FRANCISCO-OAK-SAN JOSE
855,SANTABARBRA-SANMAR-SANLUOB
507,SAVANNAH
819,SEATTLE-TACOMA
657,SHERMAN-ADA
612,SHREVEPORT
624,SIOUX CITY
725,SIOUX FALLS(MITCHELL)
588,SOUTH BEND-ELKHART
881,SPOKANE
619,SPRINGFIELD MO
543,SPRINGFIELD-HOLYOKE
638,ST. JOSEPH
609,ST. LOUIS
555,SYRACUSE
530,TALLAHASSEE-THOMASVILLE
539,TAMPA-ST. PETE (SARASOTA)
581,TERRE HAUTE
547,TOLEDO
605,TOPEKA
540,TRAVERSE CITY-CADILLAC
531,TRI-CITIES TN-VA
789,TUCSON (SIERRA VISTA)
671,TULSA
760,TWIN FALLS
709,TYLER-LONGVIEW(LFKN&NCGD)
526,UTICA
626,VICTORIA
625,WACO-TEMPLE-BRYAN
511,WASHINGTON DC (HAGRSTWN)
549,WATERTOWN
705,WAUSAU-RHINELANDER
548,WEST PALM BEACH-FT. PIERCE
554,WHEELING-STEUBENVILLE
627,WICHITA FALLS & LAWTON
678,WICHITA-HUTCHINSON PLUS
577,WILKES BARRE-SCRANTON
550,WILMINGTON
810,YAKIMA-PASCO-RCHLND-KNNWCK
536,YOUNGSTOWN
771,YUMA-EL CENTRO
596,ZANESVILLE';
		
		
		$this->loadModel("DimDmaCode");
		
		$dmas = explode("\n",$str);
		
		$dma = array();
		
		$i = 0;
		
		foreach($dmas as $v) {
			
			$tmp = explode(",",$v);
			
			$dma[$i]['dma_code'] = $tmp[0];
			$dma[$i]['dma_name'] = $tmp[1];
			
			$i++ ;
			
		}
		
		
		foreach($dma as $v) {
			
			$this->DimDmaCode->create();
			
			$this->DimDmaCode->save(array(
				"dma_code"=>$v['dma_code'],
				"dma_location"=>$v['dma_name']
			));
			
		}
		
	}
	
	private function mem() {
		
			echo memory_get_usage();
			echo "<br />";
		
	}
	
	public function shell() {
		
		$out = '';
		
		system('echo "WEB1MH0r5t7Wn" | sudo -u root -S /home/sites/berrics.shell/clear-cache',$out);
		
		die($out);
		
	}
	
	public function uri() {
		
		$this->loadModel("Dailyop");
		
		$posts = $this->Dailyop->find("all",array(
			"contain"=>array()
		));
		
		foreach($posts as $p) {
			
			$this->Dailyop->create();
			
			$this->Dailyop->id = $p['Dailyop']['id'];
			
			$uri = Tools::safeUrl($p['Dailyop']['name']."-".$p['Dailyop']['sub_title']);
			
			$uri = trim($uri,"-");
			
			$this->Dailyop->save(array(
				
				"uri"=>$uri.".html"
			
			));
			
		}
		
		
	}
	
	
	public function sections() {
		
		
		$this->loadModel("DailyopSection");
		
		$s = $this->DailyopSection->find("all",array(
		
			"contain"=>array()		
		
		));
		
		foreach($s as $v) {
			
			$this->DailyopSection->create();
			$this->DailyopSection->id = $v['DailyopSection']['id'];
			
			$this->DailyopSection->save(array(
			
				"uri"=>Tools::safeUrl($v['DailyopSection']['name'])
			
			));
			
		}
		
		
		
	}
	
	public function dupes() {
		
		
		$this->loadModel("Dailyop");
		
		$posts = $this->Dailyop->find('all',array(
		
			"conditions"=>array(),
			"contain"=>array(
		
				"DailyopSection"		
		
			),
			"order"=>array("DailyopSection.name"=>"ASC")	
		
		));
		
		$this->set(compact("posts"));
		
		
	}
	
	
	
	public function dops_to_videos() {
		
		$this->loadModel("Dailyop");
		$this->loadModel("MediaFile");
		$this->loadModel("Tag");
		
		$m = $this->MediaFile->find("all",array(
			
			"conditions"=>array(
				"MediaFile.media_type"=>"bcove",
				"MediaFile.post_process !="=>1
			),
			"contain"=>array(),
			"limit"=>500
		
		));
		
		foreach($m as $v) {
			
			//find the dailyops post the media file is attached to
			
			$items = $this->Dailyop->DailyopMediaItem->find("all",array(
			
				"conditions"=>array(
					"DailyopMediaItem.media_file_id"=>$v['MediaFile']['id']
				),
				"contain"=>array()
			
			));
			
			//get all the ids
			$ids = Set::extract("/DailyopMediaItem/dailyop_id",$items);
			
			//get all the tags
			$dt = $this->Dailyop->find("all",array(
			
				"conditions"=>array(
					"Dailyop.id"=>$ids
				),
				"contain"=>array(
					"Tag"
				)
			
			));
			
			$tags = Set::extract("/Tag/id",$dt);
			
			$tg = array(
				"Tag"=>$tags
			);
			
			$this->MediaFile->create();
			
			$this->MediaFile->id = $v['MediaFile']['id'];
			
			$udata = array(
				"MediaFile"=>array(
				"id"=>$v['MediaFile']['id'],
				"post_process"=>1),
				"Tag"=>$tg
			);
			
			$this->MediaFile->save($udata);

			
		}
		
	}
	
	public function fixRedaUri() {
		
		
	}
	
	public function sftp() {
		
		App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
		
		$srv = ImgServer::instance();
		
		$srv->connect();
		
		$srv->sftp->chdir("/home/sites/berrics/theberrics.com/public_html/app/controllers");
		
		pr($srv->sftp->nlist());
		
		$srv->close();
		
	}
	
	
	
	public function unified() {
		
		$this->loadModel("UnifiedShop");
		
		
		$file = "/tmp/master-shop-list.csv";
		
		$csv = file_get_contents($file);
		
		//$csv = str_replace("\n","@@@",$csv);
		
		$csv_array = explode("\r",$csv);
		
		foreach($csv_array as $val) {
			
			$v = explode(",",$val);

			$data = array(
				"name"=>$v[0],
				"street_address"=>$v[1]." ".$v[2]." ".$v[3],
				"city"=>$v[4],
				"state"=>$v[5],
				"postal_code"=>$v[6],
				"country"=>$v[7],
				"territory"=>$v[8],
				"channel"=>$v[9],
				"contact_name"=>$v[10],
				"phone_number"=>$v[11],
				"contact_email"=>$v[12]
				
			);
			
			
			$this->UnifiedShop->create();
			
			$this->UnifiedShop->save($data);
			
				
		}
		
	}
	
	
	
	public function clients() {
		
		App::import("Vendor","DfpApi",array("file"=>"DfpApi.php"));
		
		
		DFPAPI::instance()->test();
		
		
		
	}
	
	
	public function tag_test() {
		
		$this->loadModel("Tag");
		
		$tags = $this->Tag->find("all",array(
			"conditions"=>array(
				"Tag.name"=>"nick tucker"
			),
			"contain"=>array(
				"User"
			)
		));
		
		print_r($tags);
		die();
	}
	
	
	public function yn3_video() {
		
		/*$this->loadModel("MediaFileUpload");
		
		$uploads = $this->MediaFileUpload->find("all",array(
			"conditions"=>array(
				"MediaFileUpload.model"=>"YounitedNationsEventEntry"
			),
			"contain"=>array()
		));
		
		$vids = array();
		
		foreach($uploads as $v) {
			
			$vids[$v['MediaFileUpload']['foreign_key']][] = $v['MediaFileUpload']['file_name'];
			
		}
		
		foreach($vids as $k=>$v) {
			
			if(!is_dir(TMP."yn3/".$k)) mkdir(TMP."yn3/".$k."-".$v);
			
			foreach($v as $vv) {
				
				
			}
			echo "\n";
			echo "scp root@berricsupload:/home/uploads/".$vv." {$k}";
			
			
		}
		
		die(pr($vids));
		*/
		
		
			//get all the younited nations 3 downloads
		$this->loadModel("YounitedNationsEventEntry");
		
		$this->YounitedNationsEventEntry->bindModel(array(
			"hasMany"=>array(
				"MediaFileUpload"=>array(
					"className"=>"MediaFileUpload",
					"conditions"=>array("MediaFileUpload.model"=>"YounitedNationsEventEntry"),
					"foreignKey"=>"foreign_key"
				)
			)
		));
		
		$entries = $this->YounitedNationsEventEntry->find("all");
		
		foreach($entries as $k=>$v) {
			
			if(count($v['MediaFileUpload'])<1) unset($entries[$k]);
			
		}
		
		foreach($entries as $v) {
			
			$dir = "/yn3/".$v['YounitedNationsEventEntry']['id']."-".preg_replace('/[^a-zA-Z0-9\s]/', "", $v['YounitedNationsPosse']['name']);
			
			//if(!is_dir($dir)) mkdir($dir);
			echo "\n";
			echo "mkdir \"{$dir}\"; \n";
			echo "chmod 777 '{$dir}';";
			
			foreach($v['MediaFileUpload'] as $f) {
				
				echo "\n";
				echo "scp root@uploadserver:/home/uploads/".$f['file_name']." '".$dir."/'";
				
			}
			
		}
		
		die(pr($entries));
		
		
	}
	
	
		
	
	public function test_inv() {
		
	
		$this->loadModel("CanteenShippingRecord");
		
		$file_id = $this->CanteenShippingRecord->ljg_process_pending();
		
		$this->CanteenShippingRecord->ljg_create_orders_file($file_id);
		
		//$this->CanteenShippingRecord->ljg_ftp_file($file_id);
		
	}
	
	
	public function add_sizes() {
		
		$this->loadModel("CanteenProduct");
		
		$cat = 11;
		
		//get all the products in tshirts
		$products = $this->CanteenProduct->find('all',array(
			"conditions"=>array(
				"CanteenProduct.parent_canteen_product_id"=>NULL,
				"CanteenProduct.canteen_category_id"=>array(11,17,18,19)
			),
			"contain"=>array()
		));
		
		foreach($products as $v) {
			
			$d = array(
				"parent_canteen_product_id"=>$v['CanteenProduct']['id'],
				"deleted"=>0,
				"active"=>1,
				"opt_label"=>"Size",
				"opt_value"=>"XXL",
				"display_weight"=>5
			);
			
			$this->CanteenProduct->create();
			
			$this->CanteenProduct->save($d);

			
		}
		
		die();
		
	}
	
	public function xe() {
		
		$this->loadModel("Currency");
		
		//$this->Currency->save_xe_currency_file();
		
		$this->Currency->parse_xe_file();
		
	}
	
	public function test_shipment() {
		
		$this->loadModel("CanteenShippingRecord");
		
		$this->CanteenShippingRecord->process_pending_lajolla();
		
	}
	
	public function get_prod_price() {
		
		$this->loadModel("CanteenProduct");
		
		$product = $this->CanteenProduct->returnProduct(array(
			"conditions"=>array("CanteenProduct.id"=>1000289)
		));
		
		echo "array(";
		
		foreach($product['CanteenProductPrice'] as $p) {
			
			echo "'{$p['currency_id']}'=>{$p['price']},";
			
		}
		
		echo ");";
		
		die();
		
	}
	
	public function fix_product_prices() {
		
		$this->loadModel("CanteenProduct");
		$this->loadModel("CanteenProductPrice");
		
		
		$str = "1000070,1000075,1000080,1000121,1000126,1000131,1000136,1000141,1000146,1000151,1000156,1000161,1000166,1000171,1000176,1000181,1000186,1000191,1000199,1000204,1000209,1000214,1000219,1000224,1000229,1000234,1000239,1000244,1000249,1000254,1000259,1000264,1000274,1000279,1000284,1000289,1000294,1000299,1000304,1000309,1000314,1000334,1000339,1000344";
		
		$prices = array('USD'=>24.95,'GBP'=>15.95,'EUR'=>19.95,'CAD'=>24.95,'AUD'=>24.95,'BRL'=>52.95);
		
		$products = $this->CanteenProduct->find("all",array(
			"conditions"=>array(
				"CanteenProduct.id IN ({$str})"
			),
			"contain"=>array(
				"CanteenProductPrice"
			)
		));
		
		foreach($products as $p) {
			
			foreach($p['CanteenProductPrice'] as $price) {
				
				$this->CanteenProductPrice->create();
				
				$this->CanteenProductPrice->id = $price['id'];
				
				$this->CanteenProductPrice->save(
					array(
						"price"=>$prices[$price['currency_id']]
					)
				);
				
			}
			
		}
		
				
	}
	
	public function test_lajolla_tracking() {
		
		$this->loadModel("CanteenShippingRecord");
		
		$this->CanteenShippingRecord->ljg_get_tracking_files();
		
		//$this->CanteenShippingRecord->ljg_process_tracking_files();
		
	}

	
	
	public function process_queue() {
	
		$this->loadModel("EmailMessage");
		
		//grab 50 emails
		$emails = $this->EmailMessage->find("all",array(
	
				"conditions"=>array(
						"EmailMessage.processed"=>0
				),
				"contain"=>array()
					
		));
	
		SysMsg::add(array(
				"category"=>"Emailer",
				"from"=>"MailerShell",
				"crontab"=>1,
				"title"=>"Emails to processes: ".count($emails)
		));
	
		$success = 0;
	
		foreach($emails as $msg) {
	
			$e = $msg['EmailMessage'];
			//die(print_r($e));
			$this->Email->reset();
			$this->Email->to = "john.c.hardy@gmail.com";
			$this->Email->from = $e['from'];
			$this->Email->subject=$e['subject'];
			//$this->Email->cc = explode(",",$e['cc']);
			$this->Email->bcc = $e['bcc'];
			$this->Email->sendAs = $e['send_as'];
			$this->Email->template = $e['template'];
			$this->Email->smtpOptions = array(
					'port'=>'25',
					'timeout'=>'30',
					'host' => 'smtp.com',
					'username'=>'do.not.reply@theberrics.com',
					'password'=>'artosari',
			);
			
			$this->Email->delivery = 'smtp';
	
			$this->set(compact("msg"));
	
			if($this->Email->send()) {
	
				$this->EmailMessage->create();
				$this->EmailMessage->id = $e['id'];
				$this->EmailMessage->save(array("processed"=>1,"sent_date"=>"NOW()"));
				$success++;
	
			} else {
				//print_r($this->Email);
				
				die($this->Email->smtpError);
				SysMsg::add(array(
						"category"=>"Emailer",
						"from"=>"MailerShell",
						"crontab"=>1,
						"title"=>"Email Failure - Message ID: {$e['id']}"
						));
	
			}
	
		}
	
		SysMsg::add(array(
				"category"=>"Emailer",
				"from"=>"MailerShell",
				"crontab"=>1,
				"title"=>"Email Send Results: Success ({$success}) Total (".count($emails).")"
				));
	
	
	
	
	}
	
	public function test_lajolla() {
		
		
		$this->loadModel("CanteenShippingRecord");
		
		$pending = $this->CanteenShippingRecord->ljg_process_pending();
		
		$this->CanteenShippingRecord->ljg_create_orders_file($pending);
		
		$this->CanteenShippingRecord->ljg_ftp_file($pending);
		
	}

	
	public function test_goog() {
		
		$accessToken = '{"access_token":"ya29.AHES6ZQ9yjVf6xdFjpiLZsfqQIAxDOkm95MMv33GHySZlYNRpsgPrA","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/-qDO6Ug3qj_xnlCqMdhJ0N0zD8QxpZFBI5tFhJtOark","created":1342628689}';
		
		
		App::import("Vendor","GoogleApiClient",array("file"=>"google-api-php-client/src/apiClient.php"));
		App::import("Vendor","GoogleBigqueryApi",array("file"=>"google-api-php-client/src/contrib/apiBigqueryService.php"));
		
		$apiClient = new apiClient();
		$apiClient->setApplicationName("Testing App");
		$apiClient->setClientId("632632109626-oi3e0cvvkbur75r1fe4cg80dbuk4sjds@developer.gserviceaccount.com");
		$apiClient->setClientSecret("dhWNmyamq9LPLfMpWStQbmww");
		$apiClient->setRedirectUri("http://".$_SERVER['HTTP_HOST']."/tester/goog_callback");
		$apiClient->setScopes(array(
					'https://www.googleapis.com/auth/bigquery'
		));
		$apiClient->setApprovalPrompt("auto");
		
		$apiClient->setAccessToken($accessToken);
		
		$bq = new apiBigqueryService($apiClient);
		
		die(pr($bq->jobs->getQueryResults("theberrics.com:site-reports","job_d6238b593ead456f9c8cffa0c1ea2e56")));
		
		die(pr($bq->jobs->get("theberrics.com:site-reports","job_d6238b593ead456f9c8cffa0c1ea2e56")));
		
		
	}

	public function test_youtube() {
		App::import("Vendor","GoogleApiClient",array("file"=>"google-api-php-client/src/Google_Client.php"));
		App::import("Vendor","GoogleApiClient",array("file"=>"google-api-php-client/src/contrib/Google_YoutubeService.php"));
		
		$apiClient = new Google_Client();
		$apiClient->setApplicationName("Testing App");
		$apiClient->setClientId("632632109626-oi3e0cvvkbur75r1fe4cg80dbuk4sjds@developer.gserviceaccount.com");
		$apiClient->setClientSecret("dhWNmyamq9LPLfMpWStQbmww");
		$apiClient->setRedirectUri("http://".$_SERVER['HTTP_HOST']."/tester/goog_callback");
		$apiClient->setScopes(array(
				'https://www.googleapis.com/auth/youtube'
		));
		$apiClient->authenticate();
		die();
	}

	public function goog_callback() {
		
		App::import("Vendor","GoogleApiClient",array("file"=>"google-api-php-client/src/Google_Client.php"));
		App::import("Vendor","GoogleApiClient",array("file"=>"google-api-php-client/src/contrib/Google_YoutubeService.php"));
		
		$apiClient = new Google_Client();
		$apiClient->setApplicationName("Testing App");
		$apiClient->setClientId("632632109626-oi3e0cvvkbur75r1fe4cg80dbuk4sjds@developer.gserviceaccount.com");
		$apiClient->setClientSecret("dhWNmyamq9LPLfMpWStQbmww");
		$apiClient->setRedirectUri("http://".$_SERVER['HTTP_HOST']."/tester/goog_callback");
		$apiClient->setScopes(array(
				'https://www.googleapis.com/auth/youtube'
		));
		$apiClient->authenticate();
		
		die($apiClient->getAccessToken());
		
	}
	
	public function test_service() {
		
		App::import("Vendor","GoogleApiClient",array("file"=>"google-api-php-client/src/apiClient.php"));
		App::import("Vendor","GoogleApiClient",array("file"=>"google-api-php-client/src/contrib/apiBigqueryService.php"));
		
		$apiClient = new apiClient();
		$apiClient->setApplicationName("Testing App");
		$apiClient->setClientId("632632109626-oi3e0cvvkbur75r1fe4cg80dbuk4sjds@developer.gserviceaccount.com");
		$apiClient->setClientSecret("dhWNmyamq9LPLfMpWStQbmww");
		$apiClient->setRedirectUri("http://".$_SERVER['HTTP_HOST']."/tester/goog_callback");
		$apiClient->setScopes(array(
				'https://www.googleapis.com/auth/bigquery'
		));
		$apiClient->authenticate();
		
	}

	public function test_bq() {
		
		
		$this->loadModel("Report");
		
		
		$this->Report->refresh_report_status(10);
		
		
	}
	
	public function view_bq($id) {
		
		
		$this->loadModel("Report");
		
		$report = $this->Report->findById($id);
		
		$report['Report']['report_data'] = unserialize($report['Report']['report_data']);
		
		
		die(pr($report));
		
		
	}

	public function run_inventory() {
		
		$this->loadModel("CanteenProduct");
		
		$plist = $this->CanteenProduct->find("all",array(
					"conditions"=>array(

						"CanteenProduct.parent_canteen_product_id"=>null
							
					),
					"contain"=>array(),
					"fields"=>array(
						"CanteenProduct.id"		
					)
				));
		
		$pids = Set::extract("/CanteenProduct/id",$plist);
		
		$products = array();
		
		foreach($pids as $id) {
			
			$products[] = $this->CanteenProduct->returnAdminProduct($id);
			
		}
		$this->set(compact("products"));
		//die(pr($products));
		
		
	}
	
	
	public function test_dfp() {
		
		require_once '/home/sites/berrics.v3/shared/vendors/dfp/src/Google/Api/Ads/Dfp/Lib/DfpUser.php';
		
		if (isset($_REQUEST['oauth_verifier'])) {
			$oauthVerifier = $_REQUEST['oauth_verifier'];
		}
		
		if (!isset($oauthVerifier)) {
			// Set the OAuth consumer key and secret. Anonymous values can be used for
			// testing, and real values can be obtained by registering your application:
			// http://code.google.com/apis/accounts/docs/RegistrationForWebAppsAuto.html
			$oauthInfo = array('oauth_consumer_key' => 'anonymous',
					'oauth_consumer_secret' => 'anonymous');
		
			// Create the DfpUser and set the OAuth info.
			$iniPath = dirname(__FILE__) . '/../';
			$authFile = $iniPath . 'auth.ini';
			$settingsFile = $iniPath . 'settings.ini';
			$user = new DfpUser($authFile, NULL, NULL, NULL, NULL, $settingsFile);
			$user->SetOAuthInfo($oauthInfo);
		
			// Use the URL of the current page as the callback URL.
			$protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
			? 'https://' : 'http://';
			$server = $_SERVER['HTTP_HOST'];
			$path = $_SERVER["REQUEST_URI"];
			$callbackUrl = $protocol . $server . $path;
		
			try {
				// Request a new OAuth token. For a web application, pass in the optional
				// callbackUrl parameter to have the user automatically redirected back
				// to your application after authorizing the token.
				$user->RequestOAuthToken($callbackUrl);
		
				// Get the authorization URL for the OAuth token.
				$location = $user->GetOAuthAuthorizationUrl();
			} catch (OAuthException $e) {
				// Authorization was not granted.
				$error = 'Failed to authenticate: ' .
						str_replace("\n", " ",
								isset($e->lastResponse) ? $e->lastResponse : $e->getMessage());
			}
		} else {
			// Get the user from session.
			session_start();
			$user = new DfpUser();
			session_write_close();
		
			try {
				// Upgrade the authorized token.
				$user->UpgradeOAuthToken($oauthVerifier);
		
				// Set network code.
				$networkService = $user->GetNetworkService();
				$networks = $networkService->getAllNetworks();
				if (sizeof($networks) > 0) {
					$user->SetNetworkCode($networks[0]->networkCode);
				}
		
				$location = 'index.php';
			} catch (OAuthException $e) {
				// Authorization was not granted.
				$error = 'Failed to authenticate: ' .
						str_replace("\n", " ",
								isset($e->lastResponse) ? $e->lastResponse : $e->getMessage());
			}
		}
		
		if (!isset($error)) {
			// Store the user in session.
			session_start();
			die(pr($_SESSION));
			session_write_close();
		
			// Redirect to application home page.
			Header('Location: ' . $location);
		} else {
			// Remove the user from session.
			session_start();
			//ServiceUserManager::RemoveServiceUser($user);
			session_write_close();
		
			// Redirect to application home page.
			Header('Location: index.php?error=' . $error);
		}
		
		
	}


	public function test_product() {

		$this->loadModel("CanteenProduct");

		$p = $this->CanteenProduct->returnAdminProduct(1001028);

		die(print_r($p));

	}

	public function brand_tags() {
		
		$this->loadModel('Tag');
		$this->loadModel('Brand');
		
		$brands = $this->Brand->find('all');

		$count = 0;

		foreach ($brands as $k => $v) {
			

			$tag = $this->Tag->find('first',array(

				"conditions"=>array(
					"Tag.name" => $v['Brand']['name']
				),
				"contain"=>array()

			));

			if(isset($tag['Tag']['id']) && empty($tag['Tag']['brand_id'])) {

				$this->Tag->create();

				$this->Tag->id = $tag['Tag']['id'];

				$this->Tag->save(array(

					"brand_id"=>$v['Brand']['id']

				));

				$count++;

			}

		}

		echo $count;

		die();


	}

	public function yt_callback() {
		
		die(print_r($_SESSION));

	}

	public function yt_channel() {

		// in app/Config/bootstrap.php
		App::uses('CakeLog', 'Log');

		App::import("Vendor","YoutubeApi",array("file"=>"YoutubeApi.php"));

		$yt = new YoutubeApi();

		$videos = $yt->getAllVideos();

		$dump = print_r($videos,true);

		CakeLog::write("debug",$dump);

		die();


	}

	public function yt_upload() {

		App::import("Vendor","YoutubeApi",array("file"=>"YoutubeApi.php"));

		$yt = new YoutubeApi();

		$yt->uploadVideo();



	}

	public function yt_devtags() {
		
		App::import("Vendor","YoutubeApi",array("file"=>"YoutubeApi.php"));

		$yt = new YoutubeApi();

		$videos = $yt->getUploadedVideos();

		die(print_r($videos));

	}

	public function test_dl() {
		
		$this->loadModel('MediaFile');

		$status = $this->MediaFile->downloadVideoToTmp('50875294-d83c-4c57-9e4a-3aec323849cf');
		
		die(print_r($status));

	}

	public function yt_get_video() {
		
		App::import("Vendor","YoutubeApi",array("file"=>"YoutubeApi.php"));

		$yt = new YoutubeApi();

		$video = $yt->returnVideoEntry('hAtJ6Epqd6Y');

		die(print_r($video));


	}

	public function test_video_task() {
		
		$this->loadModel('VideoTask');

		$task = $this->VideoTask->findById(39);

		//$this->VideoTask->youtube_upload($task);
		
		$this->VideoTask->{$task['VideoTask']['task']}($task);

	}

	public function test_tags($value='') {
		$this->loadModel('Dailyop');

		$post = $this->Dailyop->returnPost(array(
			"Dailyop.id"=>"822"
		),1);

		$tags = Set::extract("/Tag/name",$post);
		$tags[] = "Skateboarding";
		$tags[] = "The Berrics";

		die(pr($tags));
		
	}


	public function test_insert_ogv() {
		
		$this->loadModel('MediaFile');
		$this->loadModel('VideoTask');
		

		$file = $this->MediaFile->find("all",array(
			"conditions"=>array(
				"MediaFile.limelight_file LIKE"=>"%.mp4",
				"MediaFile.limelight_file_ogv is null OR MediaFile.limelight_file_ogv=''"
			),
			"contain"=>array(),
			"limit"=>3000
			
		));

		foreach ($file as $k => $v) {
			
			$this->VideoTask->queueTask(array(
				"task"=>"mp4_to_ogv",
				"model"=>"MediaFile",
				"foreign_key"=>$v['MediaFile']['id']
			));

		}

	

	}

	public function test_trending() {
		
		$this->loadModel('TrendingPost');

		$posts = $this->TrendingPost->currentTrending();

		die(print_r($posts));


		

	}


	public function insert_search_items($page = 1) {
		
		$this->loadModel('Dailyop');

		$this->loadModel('SearchItem');
		
		$posts = $this->Dailyop->find("all",array(
					"conditions"=>array(
						"OR"=>array(
							"Dailyop.promo"=>null,
							"Dailyop.promo"=>0
						),
						"Dailyop.active"=>1
					),
					"contain"=>array(
						"Tag"
					),
					"limit"=>1000,
					"page"=>$page,
					"order"=>array(
						"Dailyop.id"=>"ASC"
					)
				));

		foreach($posts as $post) {

			$tags = Set::extract("/Tag/name",$post);
			
			$tags = implode(" ", $tags);

			$kw = $tags." ";

			if(!empty($post['Dailyop']['text_content'])) $kw.= strip_tags($post['Dailyop']['text_content']);

			$this->SearchItem->create();
			$this->SearchItem->save(array(
				"model"=>"Dailyop",
				"foreign_key"=>$post['Dailyop']['id'],
				"title"=>$post['Dailyop']['name'],
				"sub_title"=>$post['Dailyop']['sub_title'],
				"keywords"=>$kw,
				"active"=>$post['Dailyop']['active'],
				"publish_date"=>$post['Dailyop']['publsh_date']
			));

		}


	}



	
}