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
					"limit"=>500,
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

	public function test_featured() {
		
		$this->loadModel('TrendingPost');

		$post = $this->TrendingPost->featuredPost();

		die(print_r($post));
		

	}

	public function test_preg() {
		
		$str = "/news/tewte/etwsdf/twer/date:2012-03-12/asadsf/adsfasdf";

		$s = preg_replace('/(\/date:)([0-9]{4})(\-)([0-9]{2})(\-)([0-9]{2})/','/@TEST@',$str);

		die($s);


	}

	public function test_related() {
		
		$this->loadModel('Dailyop');

		$post = $this->Dailyop->returnPost(array(
					"Dailyop.id"=>6367
				));
		
		$this->Dailyop->getRelatedItems($post);

	}

	public function txt_yoself_report() {
		
		

		$this->loadModel('Dailyop');

		$posts = $this->Dailyop->find("all",array(
				"conditions"=>array(
					'Dailyop.dailyop_section_id'=>'10',
					"DATE(Dailyop.publish_date) > '2011-12-15'"
				),
				"contain"=>array(
					"DailyopMediaItem"=>array(
						"MediaFile",
						"limit"=>1,
						"order"=>array("DailyopMediaItem.display_weight"=>"ASC")
					)
				)
			));

		$ids = array();

		foreach ($posts as $k => $v) {
			
			$ids[] = $v['DailyopMediaItem'][0]['MediaFile']['id'];

		}
		CakeSession::delete("MediaFileReportQueue");
		CakeSession::write("MediaFileReportQueue",$ids);

		die(print_r(CakeSession::read()));

	}


	public function dc_report() {
		
		$this->loadModel('Tag');
		$this->loadModel('DailyopsTag');
		
		$ids = '9,10,19,34,42,132,167,220,339,504,621,780,847,849,892,1005,1082,1190,2136,2208,2266,2743,2839,2883,2964,3674,3753,4201';

		$keys = array(
							"Steve Berra",
							"Berra",
							"Chris Cole",
							"Rob Dyrdek",
							"Colin Mckay",
							"Josh Kalis",
							"Mikemo Capaldi",
							"Mike mo capaldi",
							"mikey taylor",
							"matt miller",
							"danny way",
							"felipe gustavo",
							"evan smith",
							"davis torgerson",
							"marquise henry",
							"nyjah huston",
							"wes kremer",
							"batb",
							"babt3",
							"batb4",
							"batb5",
							"batb6",
							"batbIII",
							"batbIV",
							"batbv",
							"batbvi"

						);

		$or = array();

		foreach ($keys as $k => $v) {
			
			$or[] = array(
				"Tag.name LIKE"=>"%".str_replace(" ", "%", $v)."%"
			); 

		}

		//die(pr($or));

		$tags = $this->Tag->find("all",array(
					
					"conditions"=>array("OR"=>$or),
					"contain"=>array(
						
					)
				));
		//die(pr($tags));

		$ids = Set::extract("/Tag/id",$tags);

		$id_str = implode(",", $ids);

		die($id_str);

	}

	public function user_profile_check() {
		
		$this->loadModel('User');

		$total = $this->User->find('count');

		for($i=1;$i<$total;$i++) {

			echo $i;
			echo "<br />";

		}

	}

	public function check_batb_scores($value='') {

		$this->loadModel('BatbVote');
		
		$votes = $this->BatbVote->find("all",array(
					"conditions"=>array(
						"BatbVote.batb_match_id"=>510,
						"BatbVote.winner_letters"=>4,
						"BatbVote.letters_points"=>0,
						"BatbVote.match_points >"=>0
					),
					//'limit'=>1
				));

		die(pr($votes));

	}


	public function recalc_batb_user($user_id = false) {
		
		$event_id = 50019;

		$this->loadModel('BatbEvent');

		$result = $this->BatbEvent->calcUser($user_id,$event_id);

		die();

	}

	public function disambig_users() {
		
		$this->loadModel('User');
		
		$users = $this->User->find("all",array(
					"fields"=>array(
						"COUNT(*) as total",
						"User.email",
						"User.created"
					),
					"conditions"=>array(
						"OR"=>array(
							"User.email !="=>"none@none.com",
							"User.email !="=>''
						)
					),
					"contain"=>array(),
					"group"=>array("User.email HAVING COUNT(User.id) > 1"),
					"order"=>array("total"=>"DESC","User.created"=>"DESC")
				));

		$emails = Set::extract("/User/email",$users);

		$usr_check = $this->User->find("all",array(
				"fields"=>array(
					"User.email",
					"User.created",
					"User.id"
				),
				"conditions"=>array(
					"User.email"=>$emails,
					//"YEAR(User.created) >=2012"
				),
				"contain"=>array()
		));

		$uids = Set::extract("/User/id",$usr_check);

		die(pr($uids));

		die(pr($usr_check));

		die(pr($emails));

	}

	public function super_report() {
		$str = "4d6ed945-69a0-45e6-837f-37a20ab5431b,4d6ed946-6d7c-4258-916e-37a20ab5431b,4d6ed946-9a34-4b01-ad83-37a20ab5431b,4d6ed946-281c-4753-8bf3-37a20ab5431b,4d6ed946-cdbc-40be-8378-37a20ab5431b,4d6ed946-41dc-49a3-9cd1-37a20ab5431b,4d6ed946-9b88-4c63-a611-37a20ab5431b,4d781010-f1bc-45c5-88a4-3b5c0ab5431b,4d781010-30b4-41ca-a57b-3b5c0ab5431b,4d781010-521c-499c-bc09-3b5c0ab5431b,4d781010-741c-47aa-954a-3b5c0ab5431b,4d781010-2384-4fed-9c46-3b5c0ab5431b,4d781010-d030-46b0-957d-3b5c0ab5431b,4d781010-7aa4-4eac-8c7a-3b5c0ab5431b,4d8c07b0-5fd4-457f-9329-684d0ab5431b,4d8c07b0-dd7c-4573-bb16-684d0ab5431b,4dd44fd4-8304-4270-85d0-6e5c0ab5431b,4dd44fd4-1a9c-4f98-9010-6e5c0ab5431b,4dd44fd4-6f68-4b83-82ec-6e5c0ab5431b,4dd44fd4-f954-4791-87b4-6e5c0ab5431b,4d8c07b0-8efc-41d7-a6a9-684d0ab5431b,4d8c07b0-bec4-4a21-955c-684d0ab5431b,4d8c07b0-8bb8-463f-920b-684d0ab5431b,4dd44fd4-c9f4-4170-a1e7-6e5c0ab5431b,4dd44fd4-9774-4a22-89f9-6e5c0ab5431b,4dd44fd4-499c-41ad-9c35-6e5c0ab5431b,4d8c07b0-4fe0-4fa8-b723-684d0ab5431b,4d8c07b0-d024-4cf4-b099-684d0ab5431b,4dd44fd4-0dd0-4c6a-9db6-6e5c0ab5431b,4dd44fd4-2914-4472-bf84-6e5c0ab5431b,4dae0d79-12c0-49de-8e30-09490ab5431b,4dae0d79-f958-4e39-afc8-09490ab5431b,4dd44fd4-4390-4d10-9866-6e5c0ab5431b,4dd44fd4-7a90-4a8a-b1cf-6e5c0ab5431b,4dae0d79-7d90-41c2-b27f-09490ab5431b,4dae0d79-6bac-4103-8f44-09490ab5431b,4dd44fd4-ef6c-4b76-8743-6e5c0ab5431b,4dd44fd4-39f4-487e-81dc-6e5c0ab5431b,4dae0d79-6de0-4ca0-85d2-09490ab5431b,4dae0d78-bce0-4e63-b667-09490ab5431b,4dd44fd4-9354-423d-a122-6e5c0ab5431b,4dd44fd4-5134-4cd9-8a85-6e5c0ab5431b,4dd44fd4-1810-4d11-8b28-6e5c0ab5431b,4dd44fd4-e0e0-4b5e-9309-6e5c0ab5431b,4dae0d78-82e8-4670-b99b-09490ab5431b,4db1aed3-d0ac-42a2-a879-056f0ab5431b,4db1aed3-ee90-4966-9348-056f0ab5431b,4dbaf3c3-8938-4428-bdfd-17b40ab5431b,4dd44fd4-3968-4490-90dd-6e5c0ab5431b,4dd44fd4-9e00-43d7-a2a0-6e5c0ab5431b,4dd44fd4-1be4-4b3e-861b-6e5c0ab5431b,4dc2e694-0edc-4ddc-a7c7-6d530ab5431b,4dd44fd4-52a8-4b8a-b4c1-6e5c0ab5431b,4dd44fd4-0154-4acb-97fb-6e5c0ab5431b,4dd44fd4-a620-4a5d-96a2-6e5c0ab5431b,4dd44fd4-ce90-49ec-a95e-6e5c0ab5431b,4df1290b-381c-4ab0-9c38-186d0ab5431b,4ddf3c7f-8894-4b4d-b820-4d130ab5431b,4df12e86-cf4c-4162-964d-25740ab5431b,4df12ba9-24b4-4511-9787-256e0ab5431b,4dfda3bf-a0f4-4ab6-b010-360f0ab5431b,4ed7ecee-ad2c-4932-b2c4-7a5f323849cf,4dfae6d8-b004-4d5d-8096-03c10ab5431b,4dfd9a13-5d88-4217-a078-36090ab5431b,4ded4df1-bab4-4489-9927-07cb0ab5431b,4ded4f27-7f90-477c-acfa-07ca0ab5431b,4dfa7b09-b08c-4a43-85b7-03c70ab5431b,4dfa7b09-6448-4c6b-924f-03c70ab5431b,4dfa9f35-6138-4e19-9ed8-03bf0ab5431b,4dfa9ed8-b474-4f6d-8747-03bf0ab5431b,4dfa7b09-86f8-4fc8-b8a7-03c70ab5431b,4dfa7b09-c95c-4e78-acfe-03c70ab5431b,4dfa7b09-14e0-4119-81d7-03c70ab5431b,4dfa7b09-aa48-403b-8930-03c70ab5431b,4dd44fd4-831c-43f7-b804-6e5c0ab5431b,4dd44fd4-d81c-4ac5-8567-6e5c0ab5431b,4dd44fd4-acd4-4c7e-b61c-6e5c0ab5431b,4dd44fd4-f450-433f-b738-6e5c0ab5431b,4dd44fd4-d1c8-4f59-ad65-6e5c0ab5431b,4df12aa8-e94c-43d2-9a46-140a0ab5431b,4dd44fd4-3320-4c2d-9f52-6e5c0ab5431b,4df12b27-27c0-40d5-bea8-13f20ab5431b,4dd44fd4-ccf4-496e-b8a5-6e5c0ab5431b,4dd44fd4-4d48-48eb-a2a4-6e5c0ab5431b,4ddf3c3d-ea68-4fb8-9fb8-4cd70ab5431b,4dd44fd4-189c-4ec9-868e-6e5c0ab5431b,4df12e5d-e83c-444f-ae75-140a0ab5431b,4dd44fd4-0788-40d6-8ffe-6e5c0ab5431b,4dfa9f08-ae64-4be2-af71-02eb0ab5431b,4dfa9eb7-c870-438c-973e-02eb0ab5431b,4e054d2e-0cdc-487b-bdb8-4ae5323849cf,4e0edb34-357c-4821-8ff4-3c31323849cf,4e0ed08e-6fd0-4cb9-a153-3c30323849cf,4e0ee337-2e98-4cae-8d21-3c30323849cf,4e0fa402-48e4-4491-8760-3c2f323849cf,4e0fbde8-c73c-4ca7-92d5-41e5323849cf,4e10c4ca-9f80-4fe7-9b5d-7813323849cf,4e10cb79-1b3c-4701-918a-432c323849cf,4e10cf52-f5d0-4ed4-b5a6-7814323849cf,4e124765-0ef0-4bce-a1ef-7c0d323849cf,4e12bc66-fdd8-4899-8ca7-7d98323849cf,4e1675cb-5774-40ca-9dee-2ab5323849cf,4d6ed943-58b8-43ed-8a12-37a20ab5431b,4d6ed943-e7cc-4657-90af-37a20ab5431b,4d6ed943-7070-4002-a499-37a20ab5431b,4d6ed943-31a0-4286-bbfc-37a20ab5431b,4d6ed943-7158-4b3e-8796-37a20ab5431b,4d6ed945-aff8-4405-9fe0-37a20ab5431b,4d6ed945-5944-47e9-ac08-37a20ab5431b,4d6ed945-8340-41cb-b0d7-37a20ab5431b,4d6ed945-12b8-4f19-812b-37a20ab5431b,4d6ed945-8674-4676-bd24-37a20ab5431b,4d6ed945-6520-4438-bd81-37a20ab5431b,4d6ed945-fb6c-4b48-8d62-37a20ab5431b,4d6ed945-5d2c-406a-a5d1-37a20ab5431b,4d6ed945-af50-4f16-bb68-37a20ab5431b,4d6ed945-7148-4ef1-bc1f-37a20ab5431b,4d6ed945-d49c-47a7-a01a-37a20ab5431b,4d6ed945-fd8c-423d-87c2-37a20ab5431b,4d6ed945-42e0-43f9-9692-37a20ab5431b,4d6ed945-fac0-45a8-a81f-37a20ab5431b,4d6ed945-5004-4afc-b249-37a20ab5431b,4d6ed945-f174-4bfc-94ec-37a20ab5431b,4d6ed945-e2b0-4a67-a79f-37a20ab5431b,4d6ed945-1724-42e9-a46c-37a20ab5431b,4d6ed945-636c-4b1b-bfb5-37a20ab5431b,4d6ed945-7fe8-46b8-9519-37a20ab5431b,4d6ed945-5000-4e68-9ca3-37a20ab5431b,4d6ed945-d648-4d69-8593-37a20ab5431b,4d6ed945-2d1c-4e94-ae4f-37a20ab5431b,4d6ed945-919c-4809-9603-37a20ab5431b,4d6ed945-e870-4ff1-a54e-37a20ab5431b,4d6ed945-29c8-42d9-8fc2-37a20ab5431b,4d6ed945-6fd0-49b2-b81e-37a20ab5431b,4d6ed945-b9c0-4b24-8031-37a20ab5431b,4d6ed945-fa48-4a4f-adca-37a20ab5431b,4d6ed945-ece0-452b-b398-37a20ab5431b,4d6ed945-4864-4353-8cef-37a20ab5431b,4d6ed945-c5e4-4135-8dec-37a20ab5431b,4d6ed945-235c-48fe-968d-37a20ab5431b,4d6ed945-d6c4-4028-a5d0-37a20ab5431b,4d6ed945-42b0-4edc-b439-37a20ab5431b,4d6ed945-be7c-4853-bffc-37a20ab5431b,4d6ed945-c550-4a6c-ba51-37a20ab5431b,4d6ed945-65b0-4d3a-b4a7-37a20ab5431b,4d6ed945-b964-4d3e-8d08-37a20ab5431b,4d6ed945-f288-45e0-8987-37a20ab5431b,4d6ed945-3d40-41f8-9234-37a20ab5431b,4d6ed945-1df8-4355-b8ae-37a20ab5431b,4d6ed945-0b40-4767-91ae-37a20ab5431b,4d6ed945-8e68-4cff-8663-37a20ab5431b,4d6ed945-a8c4-46bd-908a-37a20ab5431b,4d6ed945-1320-4cdc-bb03-37a20ab5431b,4d6ed945-ce74-4efd-9e18-37a20ab5431b,4d6ed945-7160-4138-b54a-37a20ab5431b,4d6ed945-4424-4a34-925a-37a20ab5431b,4d6ed945-7d44-411a-ba94-37a20ab5431b,4d6ed945-4440-482f-8668-37a20ab5431b,4d6ed945-93a8-4fd7-b6f9-37a20ab5431b,4d6ed945-cfec-49c6-a32f-37a20ab5431b,4d6ed945-14c8-415c-8b02-37a20ab5431b,4d6ed945-623c-457a-9062-37a20ab5431b,4d6ed945-cb38-47be-a1b9-37a20ab5431b,4d6ed945-2464-4b67-a026-37a20ab5431b,4d6ed945-1268-4ef1-a53e-37a20ab5431b,4d6ed945-55b4-4f01-a02c-37a20ab5431b,4d6ed945-eb4c-4ccd-8bba-37a20ab5431b,4d6ed945-1cb4-4b18-a390-37a20ab5431b,4d6ed945-7900-4103-8038-37a20ab5431b,4d6ed945-dde4-4ee2-a0bd-37a20ab5431b,4d6ed945-bab4-48ef-8fbe-37a20ab5431b,4d6ed945-3af0-4210-b472-37a20ab5431b,4d6ed945-0edc-45f6-8a7c-37a20ab5431b,4d6ed945-2c1c-4ac6-9ee5-37a20ab5431b,4d6ed945-ca38-4832-a838-37a20ab5431b,4d6ed945-cd88-4e66-98d7-37a20ab5431b,4d6ed945-2588-4470-9e4d-37a20ab5431b,4d6ed945-92a0-4d6e-9f45-37a20ab5431b,4d6ed945-f2d4-4407-b5b6-37a20ab5431b,4d6ed945-4c64-4d6b-b351-37a20ab5431b,4d6ed945-a720-48bd-8ef5-37a20ab5431b,4d6ed945-f37c-4db2-a484-37a20ab5431b,4d6ed945-95e4-4d15-9cd8-37a20ab5431b,4d6ed945-5390-45e9-9c3f-37a20ab5431b,4d6ed945-bb94-4e9d-97eb-37a20ab5431b,4d6ed945-190c-474a-acf0-37a20ab5431b,4d6ed945-76e8-4a80-9a53-37a20ab5431b,4d6ed945-ce20-46dd-b125-37a20ab5431b,4d6ed945-2eb8-4339-8711-37a20ab5431b,4d6ed945-3e40-411b-908a-37a20ab5431b,4d6ed945-48fc-4310-94a0-37a20ab5431b,4d6ed945-a258-4748-ace6-37a20ab5431b,4d6ed945-0b24-4056-a0a6-37a20ab5431b,4d6ed945-5a8c-4f66-bfed-37a20ab5431b,4d6ed945-82f8-4342-8fed-37a20ab5431b,4d6ed945-ee80-48ee-be94-37a20ab5431b,4d6ed945-4040-40e9-b93c-37a20ab5431b,4d6ed945-93f4-4464-b8e0-37a20ab5431b,4d6ed945-f680-4636-b761-37a20ab5431b,4d6ed945-4d54-4bdf-ae8f-37a20ab5431b,4d6ed945-beb8-4947-bea8-37a20ab5431b,4d6ed945-e038-4ba7-b6ce-37a20ab5431b,4d6ed945-325c-4284-a424-37a20ab5431b,4d6ed945-dfa0-4324-8cc1-37a20ab5431b,4d6ed945-dcd4-4064-a817-37a20ab5431b,4d6ed945-3088-43cd-b684-37a20ab5431b,4d6ed945-2664-4b28-8305-37a20ab5431b,4d6ed945-8314-43cd-8ce2-37a20ab5431b,4d6ed945-2c70-44c3-8454-37a20ab5431b,4d6ed945-e5d0-4e26-abb6-37a20ab5431b,4d6ed945-9058-44b5-bf07-37a20ab5431b,4d6ed945-e218-40ca-9fb3-37a20ab5431b,4d6ed945-4ae4-4d9e-a781-37a20ab5431b,4d6ed946-21d0-42ca-83f8-37a20ab5431b,4d6ed945-a0f8-4830-9b0f-37a20ab5431b,4d6ed946-73f4-4c19-9e25-37a20ab5431b,4d6ed946-313c-4d7c-a1dc-37a20ab5431b,4d6ed946-8eb4-423d-8248-37a20ab5431b,4d6ed946-f71c-4d59-9e52-37a20ab5431b,4d6ed946-82ac-466c-8111-37a20ab5431b,4d6ed946-f154-4f09-bf73-37a20ab5431b,4d6ed946-b090-467f-a382-37a20ab5431b,4d6ed946-4c14-46be-8702-37a20ab5431b,4d6ed946-ff48-4e02-85a1-37a20ab5431b,4d6ed946-5e50-4c9c-a1de-37a20ab5431b,4d6ed946-ce88-4dc3-ab3d-37a20ab5431b,4d6ed946-5ef8-429b-b4a8-37a20ab5431b,4d6ed946-7f94-446d-883e-37a20ab5431b,4d6ed946-e82c-4319-a6d4-37a20ab5431b,4d6ed946-4cac-470c-9cc0-37a20ab5431b,4d6ed946-a768-4730-875b-37a20ab5431b,4d6ed946-3594-4e03-827e-37a20ab5431b,4d6ed946-9c30-4933-9362-37a20ab5431b,4d6ed946-af34-4ef1-9b67-37a20ab5431b,4d6ed946-1ddc-440d-84d0-37a20ab5431b,4d6ed946-80cc-4fcf-bd1d-37a20ab5431b,4d6ed946-59d0-4272-8530-37a20ab5431b,4d6ed946-bd88-4ca4-912d-37a20ab5431b,4d6ed946-2528-4ebf-8860-37a20ab5431b,4d6ed946-8b38-4a66-95cb-37a20ab5431b,4d6ed946-d26c-4626-8964-37a20ab5431b,4d6ed946-2f80-43db-9c0e-37a20ab5431b,4d6ed946-95f4-42fa-8931-37a20ab5431b,4d6ed946-d2b0-4fa0-8f8a-37a20ab5431b,4dc43ea0-2fec-4df2-9c7a-31e50ab5431b,4dc43ea0-4d44-46f4-b4e6-31e50ab5431b,4dc43ea0-62ec-433e-80ab-31e50ab5431b,4dc43ea0-915c-429e-ad8c-31e50ab5431b,4dc43ea0-6c50-4c7d-a72f-31e50ab5431b,4d6ed945-42e0-43f9-9692-37a20ab5431b,4dc43ea0-8c9c-4e6a-a292-31e50ab5431b,4dc43ea0-c2b0-44af-ac0b-31e50ab5431b,4dc43ea0-09d0-46af-90dd-31e50ab5431b,4dc43ea1-c28c-460e-8bec-31e50ab5431b,4dc43ea0-369c-46d6-b72e-31e50ab5431b,4dc43ea1-c28c-460e-8bec-31e50ab5431b,4dc43ea1-4a4c-4d57-9c6d-31e50ab5431b,4dc43ea1-23f0-45d8-aec6-31e50ab5431b,4dc43ea1-d5c4-4b32-b89c-31e50ab5431b,4dc43ea1-29b4-4147-a688-31e50ab5431b,4dc43ea1-8a10-4402-97f8-31e50ab5431b,4dc43ea1-ccc8-457d-aa66-31e50ab5431b,4dc43ea1-6fe0-404c-846b-31e50ab5431b,4dc43ea1-8098-467d-8188-31e50ab5431b,4dc43ea1-d13c-478f-a5d5-31e50ab5431b,4dc43ea1-3ac4-4046-b863-31e50ab5431b,4dc43ea1-6d54-4aca-b6f1-31e50ab5431b,4dc43ea1-aebc-4bf2-aee0-31e50ab5431b,4dc43ea1-babc-42d4-afb6-31e50ab5431b,4dc43ea1-4e74-4d3d-8c9a-31e50ab5431b,4dc43ea1-14f4-4241-87f5-31e50ab5431b,4dc43ea1-1528-4059-ae0c-31e50ab5431b,4dc43ea1-97cc-403c-bff5-31e50ab5431b,4dc43ea1-87b4-401b-9bff-31e50ab5431b,4dc43ea1-1b48-498e-8225-31e50ab5431b,4dc43ea1-1eb8-4316-8c62-31e50ab5431b,4dc43ea1-1434-4a7f-9af7-31e50ab5431b,4dc43ea1-1b8c-417c-ad5f-31e50ab5431b,4dc43ea1-6d38-48e2-9e8a-31e50ab5431b,4dc43ea1-ce44-4580-a4d2-31e50ab5431b,4dc43ea1-8674-49f8-88f4-31e50ab5431b,4dc43ea1-505c-45b9-9f35-31e50ab5431b,4dc43ea1-826c-4e1b-82e1-31e50ab5431b,4dc43ea1-ecbc-4ae7-97b5-31e50ab5431b,4dc43ea1-ac90-4c79-ac94-31e50ab5431b,4dc43ea1-5a98-461c-9411-31e50ab5431b,4dc43ea1-6d28-4634-89e5-31e50ab5431b,4dc43ea1-4474-48de-86f6-31e50ab5431b,4dc43ea1-036c-4eab-b983-31e50ab5431b,4dc43ea1-6160-41dd-9623-31e50ab5431b,4dc43ea1-8a90-4201-b2f9-31e50ab5431b,4dc43ea1-5470-41cb-960d-31e50ab5431b,4dc43ea1-c3d4-41c1-a5b7-31e50ab5431b,4dc43ea1-8968-403a-bfe9-31e50ab5431b,4d6ed945-bb94-4e9d-97eb-37a20ab5431b,4dc43ea1-8560-4cc5-9a37-31e50ab5431b,4dc43ea1-17ec-44e5-89c7-31e50ab5431b,4dc43ea1-87fc-4d29-ba65-31e50ab5431b,4dc43ea1-ec8c-48c6-a13b-31e50ab5431b,4dc43ea1-7fa0-4455-a9b3-31e50ab5431b,4dc43ea1-837c-4e7c-8059-31e50ab5431b,4dc43ea1-29f4-4981-bd7a-31e50ab5431b,4dc43ea1-9310-41b4-9f69-31e50ab5431b,4dc43ea1-36cc-4849-bdbf-31e50ab5431b,4dc43ea1-a504-4f2b-b556-31e50ab5431b,4dc43ea1-8b0c-47e0-9c98-31e50ab5431b,4dc43ea1-9fac-49cf-aa1f-31e50ab5431b,4dc43ea1-bc80-4d4a-9130-31e50ab5431b,4dc43ea1-c8f4-4a47-83c8-31e50ab5431b,4dc43ea1-0018-425d-86c4-31e50ab5431b,4dc43ea1-ff60-4cf8-9a72-31e50ab5431b,4dc43ea1-1980-4265-8598-31e50ab5431b,4dc43ea1-50c0-4670-a99d-31e50ab5431b,4dc43ea1-9590-450d-8f8d-31e50ab5431b,4dc43ea1-c118-4954-84c5-31e50ab5431b,4dc43ea1-6470-4db8-82b2-31e50ab5431b,4dc43ea1-e5f0-401e-96eb-31e50ab5431b,4dc43ea1-635c-4861-aa0a-31e50ab5431b,4dc43ea1-47cc-4da6-bb40-31e50ab5431b,4dc43ea1-57bc-49aa-8c7b-31e50ab5431b,4dc43ea1-d82c-4336-a750-31e50ab5431b,4dc43ea1-7b20-43f7-9ceb-31e50ab5431b,4dc43ea1-5318-4725-bdc5-31e50ab5431b,4dc43ea1-8b78-486e-b0bb-31e50ab5431b,4dc43ea1-89f8-4a68-9efc-31e50ab5431b,4dc43ea1-1644-4223-9d33-31e50ab5431b,4dc43ea1-e648-43cc-9c62-31e50ab5431b,4dc43ea1-d7c0-46ae-b675-31e50ab5431b,4dc43ea1-cd20-4208-96be-31e50ab5431b,4dc43ea1-04f0-4fe3-9a14-31e50ab5431b,4dc43ea1-e430-474e-ad69-31e50ab5431b,4dc43ea2-7128-4f7e-995e-31e50ab5431b,4dc43ea2-7a34-4dd0-8fb9-31e50ab5431b,4dc43ea2-1ef8-4f46-be3e-31e50ab5431b,4dc43ea1-fa34-4d8b-8822-31e50ab5431b,4f3f285e-5adc-41e8-87c3-3241323849cf,4f3f53c1-3260-4c05-8c7d-3240323849cf,4f4022f5-2670-4cbd-ae80-3f8f323849cf,4f40955a-281c-4dfc-aeef-4a2a323849cf,4f47e887-3d6c-48bf-b526-62b9323849cf,4f482327-5f98-4538-8e88-6237323849cf,4f4868f4-a4f8-4f5f-a902-6231323849cf,4f485f98-8bd4-44f8-9304-6237323849cf,4f4fd976-174c-465e-a39e-6920323849cf,4f502e85-a38c-42e5-b4a6-6a32323849cf,4f519675-d1e4-4bb4-a53d-70e2323849cf,4f519428-bbac-49e3-b524-7b1f323849cf,4f5ab459-a5c8-44f2-8869-1ca5323849cf,4f5ac17d-a840-4d37-b425-1ce9323849cf,4f5bdad0-3138-463c-ae88-3261323849cf,4f5c5096-a5ac-488c-abf9-2905323849cf,4f62321a-cdac-4969-a1b8-4c13323849cf,4f63de1e-4e94-4d2f-aaf8-520e323849cf,4f6518bf-de68-4164-b2bc-5dc3323849cf,4f657a44-d88c-45a4-af43-5d7b323849cf,4f6d093f-2fd8-415e-916d-23aa323849cf,4f6d2af4-7b98-458b-acec-2290323849cf,4f6d2e4f-21c0-472a-886e-23aa323849cf,4f6e4644-7728-43a3-93c2-4da3323849cf,4f764ad5-c304-43f5-93c1-0f3b323849cf,4f768187-873c-4dd2-90d6-55ac323849cf,4f7789fc-498c-462f-a0e4-0a77323849cf,4f77b96c-1780-47a1-8f3d-2cbe323849cf,4f7f8295-a414-4e29-bf00-58ab323849cf,4f7fe952-1b60-4fe9-ab65-49a8323849cf,4f810b71-2f88-4f22-91c1-51a3323849cf,4f814907-bf78-44a3-b3f8-2e52323849cf,4f88d72b-6a68-4f1f-a007-5a55323849cf,4f88f9ab-3f20-4cd4-aa07-5a50323849cf,4f8a4058-8a38-4937-92c3-359c323849cf,4f8a72a2-c668-4cce-af3d-359c323849cf,4f9095a8-37d0-4181-8eb1-2a1c323849cf,4f920c9d-9ecc-4c92-9bae-7f84323849cf,4f9364af-f454-4d9a-9d38-2c3f323849cf,4f99f451-c898-46ab-88e3-690a323849cf,4f99fd36-bc68-4710-8393-79ee323849cf,4f9b388e-66b8-4a3c-9d7e-4c96323849cf,4f9cadd1-9494-4c67-8559-5f59323849cf,4fa44dfd-cc10-49a1-9d96-4b2d323849cf,4fa497a9-a838-4d85-ab11-0df4323849cf,4fa5cf70-3654-42e9-804a-4f9a323849cf,4fa5e11f-a9b4-4082-949b-6aae323849cf,4fb69aed-23e8-420d-b840-1f70323849cf,4fb6c1dc-5ca8-424b-96fc-05ac323849cf,4fb6e577-4570-49de-add7-05af323849cf,4fb6f0cc-4f00-491c-ba3a-05b1323849cf,4fbfea1a-0094-4758-ad83-7aec323849cf,4fc01680-3e18-4ac0-bf8e-201f323849cf,4fc01dce-122c-4511-9019-5a6c323849cf,4fc03048-f260-46f5-951c-7475323849cf,4fd308e4-42dc-47df-9f41-763f323849cf,4fd31a81-2404-4a7f-a2c2-05c4323849cf,4fd3ab1d-80d4-45b2-9d70-7cc2323849cf,4fd405ef-59b4-4e75-9e3d-4265323849cf,4fd4f0e8-7d70-40c8-818a-2643323849cf,4fd50ee5-a174-4a08-b755-2645323849cf,4fd50b24-7058-4fd6-8391-2645323849cf,50fa65f0-45b0-4f1d-baeb-60f7c6659e49,50fa7474-d3fc-4074-80ec-13f2c6659e49,50fb6a9f-1a50-4b5b-bd87-2a5dc6659e49,50fbc424-de84-46b1-a81c-6c9ec6659e49,4d6ed945-c3d4-42d2-878c-37a20ab5431b,4d6ed945-1d64-4596-b57a-37a20ab5431b,4d6ed945-1f08-437c-87ce-37a20ab5431b,4e67d820-9ffc-4eda-8426-742b323849cf,4e38b5b4-73e4-4433-9e82-7e17323849cf,4e3971ee-2fb4-4465-a371-0e21323849cf,4e39b152-2adc-4c20-a86e-1f8f323849cf,4e41e3bb-5f6c-41c3-9179-0d41323849cf,4e41e4c9-8954-44f6-9a36-0c89323849cf,4e41fe6f-080c-471e-802c-0d40323849cf,4e4aed62-cdac-48b7-b431-0b8b323849cf,4e4b01d7-3710-48d4-8070-0b82323849cf,4e6ed86e-1ac0-456c-b0f5-570b323849cf,4e7fb38e-13a8-41a7-817b-503c323849cf,4eebfa1e-70b8-4cb5-a989-095f323849cf,4effeb44-acd8-44cd-ae48-4442323849cf,4f4d8ff7-ed88-40b3-9d20-50f4323849cf,4f4ddd75-e980-4b84-9f0f-4dfc323849cf,4f960a03-4ee4-44c9-9e50-0617323849cf,4f970dd4-9abc-4da0-aa9d-6b48323849cf,4fea0bff-5ba4-4c3c-925d-297d323849cf,500a1f50-f2ec-4901-84bc-4060323849cf,508b33e4-f3e0-4424-aa58-21c3c6659e49,509021f0-a018-4eeb-9883-0563c6659e49,509021f0-a018-4eeb-9883-0563c6659e49,5091bd79-dd00-4a6e-8bfe-1d21c6659e49,509c3e04-a6a8-4314-ae62-304fc6659e49,50a6da71-1eb8-46b8-98e3-47a7c6659e49,4d6ed943-0ca0-4a27-ac3f-37a20ab5431b,4d6ed944-8290-49c7-a24a-37a20ab5431b,4d6ed944-0c88-4198-8043-37a20ab5431b,4d6ed945-79e4-4f20-ae29-37a20ab5431b,4d6ed945-8e18-4a5b-ae28-37a20ab5431b,4d6ed943-c70c-4444-93e3-37a20ab5431b,4d6ed945-3590-4c4e-a8c1-37a20ab5431b,4d6ed946-f87c-456e-9e84-37a20ab5431b,4dd16fa2-367c-45e7-8839-61760ab5431b,4d6ed946-3bf4-4efe-b1da-37a20ab5431b,4d8c07b0-8fe4-49cb-b24e-684d0ab5431b,4d781010-4efc-4a83-9100-3b5c0ab5431b,4d781010-191c-4c1c-aba9-3b5c0ab5431b,4d6ed946-274c-46b6-a5f8-37a20ab5431b,4d6ed946-d334-411b-983e-37a20ab5431b,4dae0d78-cee0-4691-9f36-09490ab5431b,4d6ed946-416c-454b-84e8-37a20ab5431b,4dd16fa1-40b8-4a56-bf20-61760ab5431b,4d6ed944-10a4-4117-babd-37a20ab5431b,4d6ed944-72b8-43fa-ac7d-37a20ab5431b,4d6ed944-d578-426b-880f-37a20ab5431b,4dd16fa1-dbe4-478b-ab1c-61760ab5431b,4dfa7b09-b71c-40bd-810c-03c70ab5431b,4dfa7b09-90ec-4301-a21a-03c70ab5431b,4df12aa8-e94c-43d2-9a46-140a0ab5431b,4dd44fd4-0788-40d6-8ffe-6e5c0ab5431b,4df1290b-381c-4ab0-9c38-186d0ab5431b,4dfda3bf-a0f4-4ab6-b010-360f0ab5431b,4d6ed943-6c50-48f9-8863-37a20ab5431b,4e0fbde8-c73c-4ca7-92d5-41e5323849cf,4e0edb34-357c-4821-8ff4-3c31323849cf,4e0fa402-48e4-4491-8760-3c2f323849cf,4d6ed943-dadc-4328-9d5c-37a20ab5431b,4e27af03-77bc-4b35-b24f-332c323849cf,4e28e7d1-7d94-466d-91dd-44fd323849cf,4e28ea66-41f8-4220-9821-44f8323849cf,4e2a2629-e90c-4651-b91e-4c23323849cf,4e32ffb4-39f0-493d-8bb5-3e9a323849cf,4d6ed943-df00-436a-b145-37a20ab5431b,4e3621e5-a41c-48d0-9c77-4cf2323849cf,4e36c220-60b0-483f-b482-5034323849cf,4e3b5650-7278-474a-be21-6f5b323849cf,4e3c9597-1f18-4ace-ab85-750b323849cf,4e3ca13b-1040-4746-8afe-750d323849cf,4e44d4e5-e190-4eaa-b2f0-1af1323849cf,4e49fec1-9910-42eb-ad84-0b81323849cf,4e2a2822-0cc4-4ec1-a07d-4c23323849cf,4e4f24ea-068c-4117-afd3-2c70323849cf,4e094e7f-1154-46fb-a320-1837323849cf,4e5f1c4b-4db8-4141-9fc7-07b3323849cf,4d6ed942-1928-44ce-85d8-37a20ab5431b,4e66cf95-587c-4812-98e2-4fd9323849cf,4e66ddf9-d3b8-469d-9325-4d02323849cf,4e8a0e9e-1b50-4af6-8efe-72b8323849cf,4ea5af1b-3ddc-425f-b396-458c323849cf,4ea5cea3-046c-4268-883b-4879323849cf,4ea62448-9a0c-443c-9b9a-4827323849cf,4ebc3a41-f0e8-4904-8fe3-424f323849cf,4d6ed944-810c-4e3f-bbcf-37a20ab5431b,4ecdc166-f578-4ef8-aa37-08b7323849cf,4ecf5954-f280-40ad-b188-1131323849cf,4ecd93b5-b1a8-4a70-8342-08f2323849cf,4ed7ecee-ad2c-4932-b2c4-7a5f323849cf,4ef4d249-39a4-455d-97a7-6fe2323849cf,4effeb44-acd8-44cd-ae48-4442323849cf,4f279008-b3e0-4ee4-9e74-78b7323849cf,4f2886cc-da60-49bd-8bb6-7bf8323849cf,4f43497c-e18c-467f-abe8-2520323849cf,4f482327-5f98-4538-8e88-6237323849cf,4f4868f4-a4f8-4f5f-a902-6231323849cf,4f4b022a-4364-4eb6-8f44-7021323849cf,4f4d8ff7-ed88-40b3-9d20-50f4323849cf,4f4ddd75-e980-4b84-9f0f-4dfc323849cf,4f54761a-5388-49be-991b-4b48323849cf,4f54692c-c85c-4d2b-ac0f-4b40323849cf,4f598cdd-9040-43bc-9a53-7772323849cf,4f60e449-c2f8-4a4c-bb95-3f2b323849cf,4f616a92-163c-4429-8094-4228323849cf,4f6807e1-8764-4ab7-ba9c-574e323849cf,4f6ad771-6a54-42c9-9082-68d5323849cf,4f70f3b7-8e28-4413-a4ba-42fd323849cf,4f726c71-97bc-434c-8e55-5a29323849cf,4f9ecdc8-4bc4-4b5d-b4c1-4b98323849cf,4fa497a9-a838-4d85-ab11-0df4323849cf,4fa44dfd-cc10-49a1-9d96-4b2d323849cf,4faa08e3-f214-4f77-b23c-3d04323849cf,4fa9a8f7-ed30-4b89-bcc2-286a323849cf,4fbd0b02-2a98-4dc1-9371-43e8323849cf,4fbc5c25-382c-409d-b878-4c1a323849cf,4fbfea1a-0094-4758-ad83-7aec323849cf,4fbd2a5f-24f0-444e-848f-285e323849cf,4fc01680-3e18-4ac0-bf8e-201f323849cf,4fcd43f6-ada8-4805-918d-46bc323849cf,4fd31a81-2404-4a7f-a2c2-05c4323849cf,4fd308e4-42dc-47df-9f41-763f323849cf,4fd690df-6d08-4170-bd4e-4c6d323849cf,4fd50b24-7058-4fd6-8391-2645323849cf,4fea51c6-5430-4142-a1d6-313c323849cf,4eff33f3-bf58-429c-9201-41bd323849cf,50341b74-96dc-4711-9d1c-5bba323849cf,503417ba-4524-4f78-8159-73bd323849cf,4f73ddf5-d550-4ca4-8825-235b323849cf,506b9dfa-7e20-4ece-aa6e-3772323849cf,506ba198-69cc-480e-9b9d-232a323849cf,50761fec-2498-4e66-a1a5-7897323849cf,509073be-f640-40c5-b635-0569c6659e49,50907139-74a4-470c-af46-4ee0c6659e49,509df111-44a4-4017-9367-463ac6659e49,50b53d22-cde8-4e70-bf6f-2411c6659e49,50dd37f3-db5c-40a1-af5c-7a91c6659e49,50f889a5-b00c-4900-a9b1-5939c6659e49,50fa65f0-45b0-4f1d-baeb-60f7c6659e49,50fa7474-d3fc-4074-80ec-13f2c6659e49,50ff8417-2af4-406b-923b-4764c6659e49,5100677e-38fc-4070-8b73-79f7c6659e49,4d6ed946-f0ac-45ae-8210-37a20ab5431b,4d6ed942-df7c-4286-9506-37a20ab5431b,4d6ed942-a2b4-41cc-a4f9-37a20ab5431b,4d6ed942-a254-44ae-8c28-37a20ab5431b,4d6ed942-e74c-4114-8c07-37a20ab5431b,4d6ed942-ef10-4f58-8c05-37a20ab5431b,4d6ed942-6118-4458-a19d-37a20ab5431b,4d6ed942-7ac0-4e1a-943e-37a20ab5431b,4d6ed946-531c-43d1-a0c2-37a20ab5431b,4d6ed946-9318-46b3-bfb2-37a20ab5431b,4d6ed946-aa84-4c39-9d80-37a20ab5431b,4d6ed946-8738-47ba-a342-37a20ab5431b,4d6ed946-d594-442b-a0a8-37a20ab5431b,4d6ed946-b41c-4e10-8612-37a20ab5431b,4d6ed942-a134-43dd-9ebd-37a20ab5431b,4d6ed942-fe64-4c1c-a450-37a20ab5431b,4d6ed942-d990-44c8-b885-37a20ab5431b,4d6ed942-cbb8-4d26-a921-37a20ab5431b,4d6ed942-02a4-4ca7-821a-37a20ab5431b,4d6ed943-7158-4b3e-8796-37a20ab5431b,4d6ed946-f6ec-4a71-9673-37a20ab5431b,4d6ed946-84ac-48c8-95a9-37a20ab5431b,4d6ed946-93d4-4388-a83a-37a20ab5431b,4d6ed946-4ca8-47fc-8baf-37a20ab5431b,4d6ed943-e52c-4afa-862b-37a20ab5431b,4d6ed943-3048-43a6-b1fc-37a20ab5431b,4d6ed943-86b8-4640-887d-37a20ab5431b,4d6ed943-443c-43a3-985b-37a20ab5431b,4d6ed943-a150-4e4f-84ed-37a20ab5431b,4d6ed943-491c-46c7-a23c-37a20ab5431b,4d6ed943-d798-4022-9d07-37a20ab5431b,4d6ed943-1ee0-467b-8854-37a20ab5431b,4d6ed946-0a20-40ff-a774-37a20ab5431b,4d6ed946-2ba4-4b97-96f7-37a20ab5431b,4d6ed943-f508-4105-8033-37a20ab5431b,4d6ed946-3bb4-4a24-bfec-37a20ab5431b,4d6ed945-69c0-4334-acb7-37a20ab5431b,4dbf0ffd-7d30-49f1-83f7-7a5a0ab5431b,4d6ed944-8de8-48ba-a08e-37a20ab5431b,4d6ed944-542c-47c0-9ebd-37a20ab5431b,4d6ed945-8088-4d6c-8016-37a20ab5431b,4d6ed945-f37c-4db2-a484-37a20ab5431b,4d6ed945-9198-4c6f-a545-37a20ab5431b,4d6ed945-29fc-4660-a9bd-37a20ab5431b,4d6ed945-b414-4b3d-9d5b-37a20ab5431b,4dbf0ffd-aa58-4260-b5c7-7a5a0ab5431b,4d6ed945-1c6c-4a60-b661-37a20ab5431b,4d6ed942-596c-413f-83f9-37a20ab5431b,4d6ed942-8768-4628-91b0-37a20ab5431b,4d8c07b0-076c-4911-859a-684d0ab5431b,4d6ed946-aab8-4f21-b022-37a20ab5431b,4d6ed942-5700-43ce-a7e0-37a20ab5431b,4d6ed946-9390-42af-87b8-37a20ab5431b,4d6ed945-158c-4557-9ed2-37a20ab5431b,4dbaf3c3-1108-4df8-a00b-17b40ab5431b,4d6ed943-e488-42d6-8d0e-37a20ab5431b,4d6ed943-5e2c-4d93-90d4-37a20ab5431b,4d6ed945-ee14-4950-a443-37a20ab5431b,4d6ed943-7b70-4089-8664-37a20ab5431b,4d6ed945-875c-42ef-9b9a-37a20ab5431b,4d6ed942-6734-4f23-9f74-37a20ab5431b,4d6ed942-9d44-435a-9e8c-37a20ab5431b,4d6ed942-6d88-4c8d-8c26-37a20ab5431b,4d6ed946-6408-4e5b-a413-37a20ab5431b,4d6ed945-49ac-4429-a453-37a20ab5431b,4d6ed945-9658-4e48-ac6c-37a20ab5431b,4d6ed945-e5c0-4e9c-83a1-37a20ab5431b,4d6ed945-1b20-4e6e-9ec8-37a20ab5431b,4d6ed945-bcd8-4c6f-99a4-37a20ab5431b,4d6ed945-cfdc-4d35-8521-37a20ab5431b,4d6ed945-bbb4-4b93-9d43-37a20ab5431b,4d6ed945-f77c-449b-bd73-37a20ab5431b,4d6ed945-f858-4f02-87c3-37a20ab5431b,4d6ed946-185c-42d5-b70f-37a20ab5431b,4d6ed946-6760-4a5d-be6e-37a20ab5431b,4d6ed946-3874-4789-a238-37a20ab5431b,4d6ed946-9394-4d41-a5c0-37a20ab5431b,4d6ed946-f42c-4c0b-8a1f-37a20ab5431b,4d6ed946-0954-4ec4-8f0e-37a20ab5431b,4d6ed946-6ab4-49e3-915f-37a20ab5431b,4d6ed946-d6a0-48e4-bc6d-37a20ab5431b,4d6ed946-3fd0-44fa-b67f-37a20ab5431b,4d6ed946-b514-4afc-b541-37a20ab5431b,4d6ed946-c4a8-4ee2-9ca7-37a20ab5431b,4d6ed946-7e44-4742-bedc-37a20ab5431b,4d6ed946-dbc8-4d3f-a75f-37a20ab5431b,4d6ed946-9b68-42db-ab66-37a20ab5431b,4d6ed946-2d84-4fb3-89e0-37a20ab5431b,4d6ed946-181c-42a5-a783-37a20ab5431b,4d6ed946-f4b0-4571-8ab0-37a20ab5431b,4d6ed946-44bc-46f4-8d8c-37a20ab5431b,4d6ed946-6678-4eb0-a190-37a20ab5431b,4d6ed946-8a54-48c2-a735-37a20ab5431b,4ddd86b3-bfcc-4bb3-a28e-44170ab5431b,4ddd86b3-c234-488b-a789-44170ab5431b,4ddd86b3-a044-4451-a920-44170ab5431b,4ddd86b3-f324-47da-99f7-44170ab5431b,4dd16fa1-be1c-4e89-ac9d-61760ab5431b,4dbaf3c3-7704-4fcd-bda6-17b40ab5431b,4dbaf3c3-c1e8-45c4-aad1-17b40ab5431b,4dae0d78-d314-40fb-a986-09490ab5431b,4d8c07b0-5fb4-4d16-bcbe-684d0ab5431b,4d8c07b0-718c-4130-a592-684d0ab5431b,4d8c07b0-14b4-4d4f-8ed7-684d0ab5431b,4d8c07b0-23d0-485f-892b-684d0ab5431b,4d8c07b0-fda8-4dc5-9269-684d0ab5431b,4d6ed946-21e8-4377-909b-37a20ab5431b,4d6ed946-b214-4be9-821d-37a20ab5431b,4d6ed946-71bc-44b8-aa8c-37a20ab5431b,4d6ed946-0954-4d70-a1a0-37a20ab5431b,4d6ed946-7e8c-4481-82c7-37a20ab5431b,4d6ed946-8de4-4ddb-952f-37a20ab5431b,4d6ed946-ab3c-447e-bef4-37a20ab5431b,4d6ed945-b6a0-47e8-a52a-37a20ab5431b,4d6ed945-c9d8-4c61-a0b2-37a20ab5431b,4d6ed946-1178-4b6d-89cd-37a20ab5431b,4dd16fa1-ca94-4fae-b216-61760ab5431b,4d6ed946-3f60-4c9a-82d3-37a20ab5431b,4d6ed946-d0b8-4169-a5c1-37a20ab5431b,4d6ed946-7980-4b09-a96f-37a20ab5431b,4d6ed946-3ea4-41db-96dd-37a20ab5431b,4d6ed943-f858-4228-9c48-37a20ab5431b,4d6ed946-aca4-4947-9ad3-37a20ab5431b,4d6ed946-0c98-4d84-bc7d-37a20ab5431b,4d6ed946-811c-41dd-80d8-37a20ab5431b,4d6ed944-3e44-47e5-999c-37a20ab5431b,4ddd86b3-378c-4af1-80f9-44170ab5431b,4dfa7b09-6934-4d0e-99ac-03c70ab5431b,4dfa7b09-417c-4566-a09a-03c70ab5431b,4ded4df1-ea80-406b-9baa-07cb0ab5431b,4d6ed943-38d4-470a-920d-37a20ab5431b,4d6ed944-3778-493f-8217-37a20ab5431b,4d6ed942-2870-4cb2-a392-37a20ab5431b,4d6ed942-2e90-4cf1-873f-37a20ab5431b,4e02a70c-8070-42ff-83c7-2469323849cf,4d6ed946-20a8-443a-a75f-37a20ab5431b,4d6ed946-7250-4eb5-9c15-37a20ab5431b,4e23c5b8-67ec-462e-8a3a-01e8323849cf,4e23d5ae-4684-47f3-9caf-01f0323849cf,4e2684e7-a544-455e-8a90-31db323849cf,4e287e37-d328-4616-aa6e-3d63323849cf,4e38b5b4-73e4-4433-9e82-7e17323849cf,4e3971ee-2fb4-4465-a371-0e21323849cf,4e39b152-2adc-4c20-a86e-1f8f323849cf,4e4b01d7-3710-48d4-8070-0b82323849cf,4e4aed62-cdac-48b7-b431-0b8b323849cf,4e4d852e-c218-42c3-970d-285f323849cf,4e5d163a-1234-4f4f-bb3d-50f7323849cf,4e667006-a294-4df9-9cf0-5346323849cf,4d6ed944-edb8-4457-9ff4-37a20ab5431b,4e6e5199-9798-4ca3-9ce1-3db2323849cf,4e7fb38e-13a8-41a7-817b-503c323849cf,4e8b92f9-40f8-49fa-8f78-1ab2323849cf,4e8cb44e-0be4-43b8-ad94-1ff8323849cf,4e8b968d-f8f0-466b-b4c6-1b0f323849cf,4e948ff9-380c-481d-b48b-10dd323849cf,4e9495f5-5418-44ca-91e7-112f323849cf,4eb1b277-0224-49c6-b7ab-6543323849cf,4eb1ba9b-3e80-46d6-adf4-6577323849cf,4eaedb83-bbd8-45fe-8558-592e323849cf,4eb32617-f264-4cfe-8b0b-67c2323849cf,4ec303f9-a32c-466f-9d40-1c1d323849cf,4ec19a66-817c-46c3-b4d7-1644323849cf,4ec4288c-e238-4d1e-bee9-23e8323849cf,4d6ed946-75d4-4173-bf55-37a20ab5431b,4d6ed943-b110-41cc-a9ab-37a20ab5431b,4f02c0a1-65dc-4fe0-be8b-0d38323849cf,4f054b56-8aac-4727-be1e-0665323849cf,4f0f0cef-b788-481b-8135-14e7323849cf,4f0f3f6a-69e4-4ada-a695-14cf323849cf,4f10bfc9-4d2c-4bd4-bc52-2a65323849cf,4f17523f-fccc-435d-98f1-05d3323849cf,4f175d35-acd0-49cf-930a-04d1323849cf,4f569136-10c0-4621-86b7-6080323849cf,4f9cadd1-9494-4c67-8559-5f59323849cf,4fb30b7e-5970-454c-90c1-2586323849cf,4fb30cb7-5ba8-4ce1-983a-2793323849cf,4dffffa1-3d10-4fae-8d35-1ff0323849cf,4fbd123d-0220-42e4-be63-62f4323849cf,4fbc35c8-a244-4247-9d68-40e3323849cf,4fc7cec9-a820-49db-a39e-47cb323849cf,4fcf040d-50a0-459a-a952-4499323849cf,4fceab4c-0788-4591-947a-6705323849cf,4fe11074-3dc4-4cad-aa38-339d323849cf,4fe172ff-7d1c-404c-9ada-736e323849cf,4fe89000-8a00-4247-9a1f-21d8323849cf,4fea5154-b0dc-4752-ad67-07c9323849cf,4fea5b85-ee70-496c-a5b4-1de0323849cf,4ff65e79-4358-42a4-b10e-683f323849cf,4ffca798-228c-475d-ade5-08f3323849cf,4ffd0f64-a874-4ae9-9812-72b2323849cf,4ffdfbc5-71fc-4f2c-84e9-7721323849cf,5003b044-53e8-44af-b6e4-25c5323849cf,50073cf3-4db0-4a8f-8de2-0816323849cf,5007841d-db08-45ea-97b6-1fe4323849cf,500854ae-8c58-4c03-aae2-148e323849cf,50070306-17d8-4d9b-8086-79b4323849cf,500a1f50-f2ec-4901-84bc-4060323849cf,50120560-7520-46b6-8f0e-20fb323849cf,5015a25b-1a00-41ba-9b93-71ac323849cf,5015c160-5d00-41ea-af04-72ca323849cf,5019d1be-c6b0-4a8e-8110-6862323849cf,5019d340-7fdc-42e8-8d7b-0e19323849cf,4d6ed946-974c-42db-a41f-37a20ab5431b,50351aa7-0f0c-46b1-ad63-6e6b323849cf,50355b64-ad70-4433-9028-484e323849cf,5033dcdd-53b4-402b-80e5-225b323849cf,5036bb66-ceac-4872-a036-5a68323849cf,503bd5df-522c-4095-b45d-3927323849cf,50411268-da44-44d4-a918-76d6323849cf,503ef86e-2324-4f35-b1f7-1988323849cf,4d6ed945-ee34-40cb-8e57-37a20ab5431b,50401226-f0c4-4966-99bc-3f53323849cf,50494267-7f60-461b-967d-342b323849cf,50875294-d83c-4c57-9e4a-3aec323849cf,50883128-df3c-454f-ba20-21c3c6659e49,5091bd79-dd00-4a6e-8bfe-1d21c6659e49,50ab17bd-5400-4607-b91a-3b43c6659e49,50ac8c8d-bd0c-4b13-bfaa-3cf5c6659e49,50b40f77-ee64-47fb-b4fe-2411c6659e49,50b65305-85a8-485d-a75c-6a3bc6659e49,50beb511-1b60-450e-9093-213fc6659e49,50beb579-4838-414d-9a0f-4f2cc6659e49,50c2a8e8-2db8-4700-a0d0-685cc6659e49,50c83531-2f28-442c-a660-79c5c6659e49,50c97770-4234-41bf-8d4a-6225c6659e49,50cab6b1-8a98-4ee3-8d1e-79c8c6659e49,50cab605-0a58-42ea-b2a7-6225c6659e49,50d12ec4-ab6c-4112-a1c0-4659c6659e49,50d25580-9ddc-4559-bab9-0bdcc6659e49,50d3ef20-9888-43bf-af34-41c2c6659e49,50ef57e5-22bc-48c9-82e5-67f5c6659e49,50ef5345-9ba8-4738-ac96-0a2cc6659e49,50fbc424-de84-46b1-a81c-6c9ec6659e49,4d8c07b0-f99c-4be7-94a6-684d0ab5431b,4d6ed946-365c-4a9e-bc02-37a20ab5431b,4d6ed946-4fe8-49c8-84b7-37a20ab5431b,4dbf0ffd-d114-4a14-a34e-7a5a0ab5431b,4db1aed3-d0ac-42a2-a879-056f0ab5431b,4d6ed945-f5c0-4e9d-a9b8-37a20ab5431b,4d6ed945-892c-4c57-86f4-37a20ab5431b,4dd44fd4-3968-4490-90dd-6e5c0ab5431b,4d6ed944-bbf4-4247-946d-37a20ab5431b,4d6ed945-9eec-45d2-8e33-37a20ab5431b,4d6ed946-3528-416b-8f28-37a20ab5431b,4d6ed945-e074-42f2-816e-37a20ab5431b,4d8c07b0-234c-40c7-b4a2-684d0ab5431b,4d6ed945-68dc-475b-bfdd-37a20ab5431b,4ded4df0-2ab8-407a-9e4e-07cb0ab5431b,4d6ed946-759c-44c2-93b2-37a20ab5431b,4d6ed945-e258-4bb9-81fb-37a20ab5431b,4dd44fd4-1be4-4b3e-861b-6e5c0ab5431b,4dbaf3c3-0b00-4a9b-bff5-17b40ab5431b,4d6ed946-3d34-4206-9f5b-37a20ab5431b,4d6ed945-3298-4c87-a843-37a20ab5431b,4d6ed944-f38c-445d-8c5e-37a20ab5431b,4e9f9afc-de8c-4308-8392-6ba9323849cf,4ec05cfa-c294-4abc-b91f-54bd323849cf,4f02b7ce-36a4-480e-b204-0d3d323849cf,4f3e1683-1960-4967-8051-1e4c323849cf,4f6d2e4f-21c0-472a-886e-23aa323849cf,4f6e4644-7728-43a3-93c2-4da3323849cf,4fc519f7-d138-48a6-b6ec-6d98323849cf,4fcd8713-211c-4f36-bc9c-1b8c323849cf,503d6574-2dc4-4ba0-81bd-0c9c323849cf,5043bea6-8cb0-4546-88a1-0b28323849cf,50511ae2-5db4-4fa0-afdf-2c85323849cf,50569e14-2080-489c-b7f6-2514323849cf,50579e44-b3cc-4ae4-8f08-6f1f323849cf,505cdbd3-4a14-408b-9504-1a56323849cf,505fe55a-b658-4c20-ba30-0f00323849cf,50650950-1084-40ef-9926-6585323849cf,50697af9-f71c-4455-9004-3fbf323849cf,506cd353-10e0-4238-9b35-125c323849cf,506f8ba7-8bf4-4b4f-af59-34e4323849cf,506f3731-e588-4aba-8329-2d1f323849cf,507b1f25-a300-4f39-bfc0-3681323849cf,508ac6d9-50b0-4e59-b2d2-2245c6659e49,50cf4754-3dcc-4a8c-b752-2d76c6659e49,50d0da84-5e9c-4cb1-b860-7863c6659e49,4d8c07b0-a83c-4880-a244-684d0ab5431b,4d8c07b0-8560-4cfa-a2e4-684d0ab5431b,4d781010-d7ac-4766-a0c7-3b5c0ab5431b,4d6ed946-0834-4a91-a0cc-37a20ab5431b,4d6ed946-efa0-40dd-9861-37a20ab5431b,4d6ed946-8980-4f3b-b562-37a20ab5431b,4d6ed942-7bc4-44c2-8d1c-37a20ab5431b,4d6ed942-031c-480d-9d6b-37a20ab5431b,4d6ed942-ade8-47ef-a4b4-37a20ab5431b,4d6ed942-0f04-45ca-92ee-37a20ab5431b,4d6ed942-66a0-48c4-8269-37a20ab5431b,4d6ed942-aef4-44c8-a3ad-37a20ab5431b,4d6ed942-cd18-496e-a574-37a20ab5431b,4d6ed946-1140-44d8-ba06-37a20ab5431b,4d6ed942-f2f4-480f-962f-37a20ab5431b,4d6ed942-a148-4cbd-9cfc-37a20ab5431b,4d6ed942-6788-4754-9298-37a20ab5431b,4d6ed942-f6b8-4c0a-b173-37a20ab5431b,4d6ed942-9290-4fa2-a7a1-37a20ab5431b,4d6ed942-1680-4d4e-aadc-37a20ab5431b,4d6ed942-ba84-42af-9656-37a20ab5431b,4d6ed942-8aa0-4442-a1f5-37a20ab5431b,4d6ed942-1390-4e47-8063-37a20ab5431b,4d6ed942-829c-4feb-9dab-37a20ab5431b,4d6ed942-0bec-4865-9fe3-37a20ab5431b,4d6ed942-b804-48c9-9592-37a20ab5431b,4d6ed942-0c80-4482-b43b-37a20ab5431b,4d6ed942-7174-4e56-82dd-37a20ab5431b,4d6ed942-0f98-474b-b919-37a20ab5431b,4d6ed942-6414-4138-b8b1-37a20ab5431b,4d6ed942-21c0-4384-9c10-37a20ab5431b,4d6ed942-df68-40f6-b571-37a20ab5431b,4d6ed942-802c-4bf5-9703-37a20ab5431b,4d6ed946-ba4c-4c42-8b25-37a20ab5431b,4d6ed946-e838-4c65-a48e-37a20ab5431b,4d6ed946-6560-4a07-b372-37a20ab5431b,4d6ed946-76bc-4d36-82bd-37a20ab5431b,4d6ed942-5d0c-4dc7-80e0-37a20ab5431b,4d6ed942-bfa8-4c68-8e90-37a20ab5431b,4d6ed942-0be8-4905-86b8-37a20ab5431b,4d6ed942-baa4-40af-863f-37a20ab5431b,4d6ed942-ac70-4d1a-9fbb-37a20ab5431b,4d6ed942-01b4-4c5b-bb58-37a20ab5431b,4d6ed942-434c-43d4-b512-37a20ab5431b,4d6ed942-608c-41eb-b733-37a20ab5431b,4d6ed942-1f64-41f7-a750-37a20ab5431b,4d6ed942-4ce8-4b36-8f66-37a20ab5431b,4d6ed942-a0b0-4010-89af-37a20ab5431b,4d6ed942-42a0-4ffd-bc86-37a20ab5431b,4d6ed942-aa40-44b2-beca-37a20ab5431b,4d6ed942-1404-44db-bd7e-37a20ab5431b,4d6ed942-4a24-4fbe-a464-37a20ab5431b,4d6ed942-0ce4-4307-859f-37a20ab5431b,4d6ed942-b658-4abd-905f-37a20ab5431b,4d6ed942-65a4-4e80-b005-37a20ab5431b,4d6ed943-f9d4-4740-b8be-37a20ab5431b,4d6ed943-5814-4a1d-9374-37a20ab5431b,4d6ed943-a010-4b0a-a333-37a20ab5431b,4d6ed943-e978-4953-a119-37a20ab5431b,4d6ed943-404c-4020-bf1c-37a20ab5431b,4d6ed943-8910-4ead-a979-37a20ab5431b,4d6ed943-d518-4c87-8d65-37a20ab5431b,4d6ed946-f82c-406f-a564-37a20ab5431b,4d6ed946-ae58-4e46-bc7e-37a20ab5431b,4d6ed946-c6c0-444a-aad7-37a20ab5431b,4d6ed943-20e0-4c81-9005-37a20ab5431b,4d6ed943-d294-4973-a4b0-37a20ab5431b,4d6ed943-4520-4575-a0e9-37a20ab5431b,4d6ed943-20a4-497b-96d9-37a20ab5431b,4dae0d79-7080-4308-9329-09490ab5431b,4dae0d79-6160-45d3-a859-09490ab5431b,4dae0d78-996c-42fc-a3af-09490ab5431b,4d6ed946-1784-4614-a972-37a20ab5431b,4d6ed946-11d8-4847-b75f-37a20ab5431b,4d6ed946-e4f4-4d8f-81e5-37a20ab5431b,4d6ed946-6ec4-410e-a0a2-37a20ab5431b,4d6ed943-9078-4d1b-9cf8-37a20ab5431b,4d6ed943-e528-4159-b55e-37a20ab5431b,4d6ed943-9878-423a-8b96-37a20ab5431b,4d6ed943-f524-4054-bddb-37a20ab5431b,4d6ed943-7fec-4839-939e-37a20ab5431b,4d6ed943-f8b0-4db5-b7ec-37a20ab5431b,4d6ed943-3b60-450d-ac03-37a20ab5431b,4d6ed943-51f0-4239-95fd-37a20ab5431b,4d6ed943-1064-46ae-8497-37a20ab5431b,4d6ed943-b9b8-4ece-90c3-37a20ab5431b,4d6ed943-96cc-4827-aa25-37a20ab5431b,4d6ed943-3b14-4bbe-ab90-37a20ab5431b,4d6ed943-cf9c-4a57-8e50-37a20ab5431b,4d6ed943-6c70-4143-aa77-37a20ab5431b,4d6ed943-c278-46d6-a554-37a20ab5431b,4d6ed943-9fac-4f48-95f4-37a20ab5431b,4d6ed943-351c-419f-ad3a-37a20ab5431b,4d6ed943-ea94-47ea-9d78-37a20ab5431b,4d6ed943-3d80-4537-acae-37a20ab5431b,4d6ed943-6024-4b89-a8e3-37a20ab5431b,4d6ed943-ae30-4a0d-bed7-37a20ab5431b,4d6ed943-d8e8-4699-8b40-37a20ab5431b,4d6ed943-aec8-47ec-ae42-37a20ab5431b,4d6ed943-788c-4ccd-99a7-37a20ab5431b,4d6ed943-b994-4857-a613-37a20ab5431b,4d6ed943-1984-496b-86d9-37a20ab5431b,4d6ed943-2508-4c8c-9a0b-37a20ab5431b,4d6ed943-a380-4f6b-87db-37a20ab5431b,4d6ed943-c41c-49c0-bd76-37a20ab5431b,4d6ed943-c1fc-4e50-9d74-37a20ab5431b,4d6ed943-ada8-40ab-92da-37a20ab5431b,4d6ed943-2514-4c53-a536-37a20ab5431b,4d6ed943-9b94-4d04-a1c6-37a20ab5431b,4d6ed943-f3ec-4f86-b004-37a20ab5431b,4d6ed943-4520-4fdd-b0f7-37a20ab5431b,4d6ed944-1a70-4336-8774-37a20ab5431b,4d6ed944-1200-43d5-bcf8-37a20ab5431b,4d6ed944-edcc-4cd0-b5c1-37a20ab5431b,4d6ed944-a8c0-423d-a35d-37a20ab5431b,4d6ed944-fdd8-4229-90d3-37a20ab5431b,4d6ed944-3cb8-455d-9183-37a20ab5431b,4d6ed945-faf0-463d-b641-37a20ab5431b,4d6ed945-a160-4d0f-b09e-37a20ab5431b,4d6ed944-2864-487c-8476-37a20ab5431b,4d6ed944-3b04-4504-a673-37a20ab5431b,4d6ed944-7af0-4ce1-a2f2-37a20ab5431b,4d6ed944-4d5c-46a1-b7ea-37a20ab5431b,4d6ed944-7e64-4915-a45e-37a20ab5431b,4d6ed944-8d7c-4d10-aae1-37a20ab5431b,4d6ed944-6e6c-4cb4-8b34-37a20ab5431b,4d6ed944-23e0-4524-bb3c-37a20ab5431b,4d6ed944-27d0-4101-b479-37a20ab5431b,4d6ed944-a94c-4c44-a618-37a20ab5431b,4d6ed944-9e58-45d2-83cf-37a20ab5431b,4d6ed945-2928-41f4-bdc4-37a20ab5431b,4d6ed945-2b74-4e3e-8278-37a20ab5431b,4d6ed944-ab70-4659-a18b-37a20ab5431b,4d6ed945-d06c-430c-b90e-37a20ab5431b,4d6ed945-3af0-4210-b472-37a20ab5431b,4d6ed945-bab4-48ef-8fbe-37a20ab5431b,4d6ed945-dde4-4ee2-a0bd-37a20ab5431b,4d6ed944-7aa8-453a-ace8-37a20ab5431b,4d6ed945-55b4-4f01-a02c-37a20ab5431b,4d6ed945-1268-4ef1-a53e-37a20ab5431b,4d6ed945-8784-4290-b6ef-37a20ab5431b,4d6ed945-7a0c-477c-9abb-37a20ab5431b,4d6ed944-03d4-4b63-8d40-37a20ab5431b,4d6ed944-5b78-406f-9bb0-37a20ab5431b,4d6ed944-30f8-46ad-bb04-37a20ab5431b,4d6ed944-b8e0-4f05-9eb7-37a20ab5431b,4d6ed944-4a5c-43f3-b24b-37a20ab5431b,4d6ed944-e3fc-4007-a5b6-37a20ab5431b,4d6ed944-75ac-47b4-97d0-37a20ab5431b,4d6ed944-ca7c-4de0-8ff7-37a20ab5431b,4d6ed944-d878-4c96-b9ac-37a20ab5431b,4d6ed944-8a34-4c4a-9d69-37a20ab5431b,4d6ed944-a5bc-4f8c-80e1-37a20ab5431b,4d6ed944-b0b4-4709-86bf-37a20ab5431b,4d6ed944-1b10-4afe-946a-37a20ab5431b,4d6ed944-07ac-4ba3-8ed9-37a20ab5431b,4d6ed945-7670-41b5-818f-37a20ab5431b,4d6ed945-9f08-4f4e-8004-37a20ab5431b,4d6ed945-6734-4841-a975-37a20ab5431b,4d6ed945-08c4-4c6f-871d-37a20ab5431b,4d6ed945-7b4c-4c2d-aa2e-37a20ab5431b,4d6ed944-6964-46eb-97d2-37a20ab5431b,4d6ed945-e0b0-48f6-8c98-37a20ab5431b,4d6ed945-1280-4408-9bf4-37a20ab5431b,4d6ed945-b248-4cba-a8a7-37a20ab5431b,4d6ed945-0f5c-43a7-aee5-37a20ab5431b,4d6ed945-41b4-4e5c-9d42-37a20ab5431b,4d6ed945-39c4-4c34-9469-37a20ab5431b,4d6ed945-6664-4ef9-97a4-37a20ab5431b,4d6ed945-2730-4576-a192-37a20ab5431b,4d6ed945-8124-41a6-9cd0-37a20ab5431b,4d6ed945-87f4-48a2-818b-37a20ab5431b,4d6ed945-e7c4-488c-b08f-37a20ab5431b,4d6ed945-ee54-481d-841f-37a20ab5431b,4d6ed945-a988-4e55-9a3c-37a20ab5431b,4d6ed945-6520-4438-bd81-37a20ab5431b,4d6ed942-e50c-4fc6-9c9a-37a20ab5431b,4d6ed945-0328-4931-b32c-37a20ab5431b,4d6ed945-b0ac-400c-bc13-37a20ab5431b,4d6ed945-ede0-4722-bdc7-37a20ab5431b,4dbaf3c3-8654-4b77-9e84-17b40ab5431b,4d6ed946-9fa4-4af8-9572-37a20ab5431b,4d6ed942-d72c-4ef7-9a91-37a20ab5431b,4d6ed945-a1fc-4944-a9c7-37a20ab5431b,4d6ed945-b194-43e7-88ce-37a20ab5431b,4d6ed945-68d0-4dbe-9d6f-37a20ab5431b,4d6ed945-a924-4578-8aee-37a20ab5431b,4d6ed945-c9a0-4848-a39d-37a20ab5431b,4d6ed945-d9f8-44a7-8cd3-37a20ab5431b,4d6ed945-15a8-44ad-a90c-37a20ab5431b,4d6ed945-f5d4-464d-af0a-37a20ab5431b,4d6ed945-5168-423e-b207-37a20ab5431b,4d6ed945-4b5c-489d-b5f3-37a20ab5431b,4dc2e694-6174-40dd-ab06-6d530ab5431b,4d6ed942-6a64-406c-9a1b-37a20ab5431b,4d6ed942-a6f0-4246-b468-37a20ab5431b,4d6ed942-8510-47b1-9fa2-37a20ab5431b,4dc43ea1-e430-474e-ad69-31e50ab5431b,4d6ed945-26b0-4d83-acf2-37a20ab5431b,4d6ed945-5738-4882-8637-37a20ab5431b,4dd16fa1-c5a8-4813-a42b-61760ab5431b,4d6ed942-6114-470d-b45b-37a20ab5431b,4d6ed943-cad0-46bc-9460-37a20ab5431b,4d6ed944-75d0-4d2a-a9f7-37a20ab5431b,4d6ed944-0bd8-4972-8417-37a20ab5431b,4d6ed943-c710-4a23-9f25-37a20ab5431b,4d6ed943-f198-479d-bcbd-37a20ab5431b,4d6ed943-73a0-4325-9cdd-37a20ab5431b,4d6ed943-1b14-4aa7-a28b-37a20ab5431b,4d6ed943-94e8-4792-94ca-37a20ab5431b,4d6ed944-8708-44ce-93b6-37a20ab5431b,4d6ed945-eea8-47c4-9556-37a20ab5431b,4d6ed942-43d4-4b93-9058-37a20ab5431b,4d6ed942-d8e4-4c82-bb1c-37a20ab5431b,4dc43ea1-ac90-4c79-ac94-31e50ab5431b,4dc43ea1-5a98-461c-9411-31e50ab5431b,4dc43ea1-6d28-4634-89e5-31e50ab5431b,4d6ed946-b6d4-4592-8f77-37a20ab5431b,4dd16fa1-8060-4a5c-be0a-61760ab5431b,4d6ed946-3218-4f8d-b2c4-37a20ab5431b,4d6ed946-2518-4004-8fca-37a20ab5431b,4d6ed946-6000-4e94-8ea1-37a20ab5431b,4d6ed945-1ed0-4150-8c64-37a20ab5431b,4d6ed945-be38-4f45-9dfc-37a20ab5431b,4d6ed945-6b4c-4cf6-88bb-37a20ab5431b,4d6ed945-630c-4961-8b10-37a20ab5431b,4d6ed944-2a38-4fee-97a1-37a20ab5431b,4d6ed944-c9a0-4cff-9710-37a20ab5431b,4d6ed944-9d5c-445a-8b2a-37a20ab5431b,4d6ed944-c00c-4732-8f05-37a20ab5431b,4d6ed944-52a4-455e-94ef-37a20ab5431b,4d6ed944-966c-4a9f-8f24-37a20ab5431b,4d6ed944-80fc-46eb-85aa-37a20ab5431b,4d6ed944-a014-41e8-b34c-37a20ab5431b,4d6ed944-5f0c-4e83-ada1-37a20ab5431b,4d6ed944-0e14-4ac6-8e41-37a20ab5431b,4d6ed944-b998-42fe-9f93-37a20ab5431b,4d6ed944-a964-41b7-b92d-37a20ab5431b,4d6ed943-c128-47ab-ab4c-37a20ab5431b,4d6ed943-553c-4d3b-8b28-37a20ab5431b,4d6ed943-08fc-4935-b135-37a20ab5431b,4d6ed943-0684-4e6e-8763-37a20ab5431b,4d6ed943-62d0-4679-be96-37a20ab5431b,4d6ed943-126c-4c74-9c78-37a20ab5431b,4d6ed943-5c74-463c-8d39-37a20ab5431b,4d6ed943-1980-4dfb-baa2-37a20ab5431b,4d6ed943-8d2c-4bc0-a41d-37a20ab5431b,4d6ed943-7e80-45c8-837e-37a20ab5431b,4d6ed943-0630-4e12-af9a-37a20ab5431b,4d6ed943-7b14-4079-b72d-37a20ab5431b,4d6ed943-47fc-403a-8786-37a20ab5431b,4d6ed943-0e44-4b0b-9e13-37a20ab5431b,4d6ed943-bcb4-4169-8f61-37a20ab5431b,4d6ed943-d934-4e20-9407-37a20ab5431b,4d6ed944-9c3c-4483-a353-37a20ab5431b,4d6ed944-4f7c-46e9-8434-37a20ab5431b,4d6ed944-e824-447b-8f02-37a20ab5431b,4d6ed942-18e8-4d7b-8520-37a20ab5431b,4d6ed942-0690-4280-88f1-37a20ab5431b,4d6ed942-3854-4d19-8003-37a20ab5431b,4d6ed942-9fe8-4ce4-bf1b-37a20ab5431b,4d6ed942-3c50-435b-9859-37a20ab5431b,4d6ed946-e044-43f0-bc89-37a20ab5431b,4d6ed944-7344-4d07-b16d-37a20ab5431b,4d6ed944-e154-4946-867c-37a20ab5431b,4d6ed944-de48-4075-af3f-37a20ab5431b,4d6ed945-bba0-419b-b6d7-37a20ab5431b,4e03b574-e2f8-4abe-8b39-3a56323849cf,4d6ed945-f64c-4d43-b1be-37a20ab5431b,4e054d2e-0cdc-487b-bdb8-4ae5323849cf,4e0aa279-607c-4755-a955-231b323849cf,4e0aa400-f474-48d8-9fad-29b4323849cf,4e0aa56b-d78c-490b-bd86-2321323849cf,4d6ed945-cb38-47be-a1b9-37a20ab5431b,4e0ee337-2e98-4cae-8d21-3c30323849cf,4e10c4ca-9f80-4fe7-9b5d-7813323849cf,4e10cb79-1b3c-4701-918a-432c323849cf,4e124765-0ef0-4bce-a1ef-7c0d323849cf,4e12bc66-fdd8-4899-8ca7-7d98323849cf,4e13bef3-498c-4511-b497-0668323849cf,4e13f9c0-562c-4ced-aa18-0c79323849cf,4e14bb9a-88ac-4ab2-b87b-0d64323849cf,4e1d305f-645c-47e3-a2c6-1ee7323849cf,4e1d3706-0268-45fc-a264-1f23323849cf,4e28b9d0-fe08-457f-9da6-3eb8323849cf,4d6ed944-1784-4ecf-b692-37a20ab5431b,4d6ed945-e4a4-446f-a43c-37a20ab5431b,4d6ed945-8728-45ae-9933-37a20ab5431b,4d6ed945-8f2c-4c08-8bf4-37a20ab5431b,4d6ed945-8480-4f6f-8555-37a20ab5431b,4d6ed945-4430-4d8f-8699-37a20ab5431b,4e2f7c76-bea8-4d73-aef3-2b9b323849cf,4e44887e-1d58-4537-9630-1b11323849cf,4e4482cd-13a8-464f-bc44-1b0f323849cf,4d6ed943-2e70-463c-96ce-37a20ab5431b,4e4dc504-0ef4-4d12-a0f3-28a6323849cf,4e46024f-671c-44d7-ae4c-257d323849cf,4e4f2a31-0da4-4e54-81e0-2ca4323849cf,4e5e91e6-5e04-444d-8144-7a5a323849cf,4d6ed944-8c30-4552-847b-37a20ab5431b,4e72da7e-994c-4a2f-b929-094c323849cf,4e84f7a8-a898-4ea2-b4cc-5a0c323849cf,4e56a5e7-5284-44c1-8140-14cb323849cf,4e97e699-86b0-4b20-b499-0760323849cf,4eaa4877-7b74-4459-b28d-5b54323849cf,4eb32075-6bc4-4dc4-a457-6858323849cf,4d6ed944-aadc-4602-9867-37a20ab5431b,4d6ed944-63bc-47b1-82eb-37a20ab5431b,4ec5d52e-8888-401e-8787-2bc5323849cf,4ec5d9e9-cf0c-4136-a954-2bf9323849cf,4e10cf52-f5d0-4ed4-b5a6-7814323849cf,4edf3840-80e4-4e68-9581-603a323849cf,4edf3230-f318-4bba-80d8-603a323849cf,4ee85386-9890-4916-8af7-4ee0323849cf,4ee80fab-01d0-41cd-ae7b-4f2d323849cf,4ee81134-e064-44e6-84bf-4ef5323849cf,4ed7eabe-fc78-4a2c-ad7c-795b323849cf,4d6ed942-2d74-4e7c-bbb1-37a20ab5431b,4d6ed945-2464-4b67-a026-37a20ab5431b,4f2f2073-e4cc-4681-8919-2478323849cf,4f30c574-d4ec-4d8d-bea8-70b1323849cf,4f32022d-d894-41a2-91bd-7a05323849cf,4f319aa4-b414-4546-a4f6-7a04323849cf,4f34bf3a-7dd8-4e34-8ad5-2b58323849cf,4f374b14-19b4-4986-93c9-3f99323849cf,4f41e336-7250-485c-a4bb-1157323849cf,4f4344a2-0240-485c-a5b8-251a323849cf,4f45c900-3a10-48ae-ad9e-377d323849cf,4f5c5096-a5ac-488c-abf9-2905323849cf,4f657a44-d88c-45a4-af43-5d7b323849cf,4d6ed942-1684-443f-b454-37a20ab5431b,4fabf9d3-e098-4060-9b1a-612d323849cf,4e152d99-87b8-4c16-a432-0d64323849cf,4fb54ea3-31c8-43bc-ad14-3f8b323849cf,4fcfa537-4c4c-4c87-a551-1454323849cf,4d6ed944-dd58-4f19-a2e9-37a20ab5431b,4fd50ee5-a174-4a08-b755-2645323849cf,4fdfa6b1-19b8-4798-9e19-352a323849cf,4fe38751-a7ec-4aca-bdb2-5e21323849cf,4fe7c87a-99d4-42a1-9f0d-7b5c323849cf,4ff0d2ec-31f8-41e4-acec-7462323849cf,5003b553-6b08-4e4f-8e44-2f3c323849cf,502875a3-eb7c-4d92-920d-5d2d323849cf,502d5547-a998-4d70-922f-551a323849cf,5031a6ae-bdc8-4b8f-a7d5-34c6323849cf,506ce010-1910-44b3-9a86-1b20323849cf,4e7a3fd5-7838-4220-b807-0e03323849cf,50c50e12-e0d0-47d9-9e62-6221c6659e49,50d21c3c-fdd8-47f1-b789-79f8c6659e49,50e5348e-3a20-4aff-9c6a-5a00c6659e49,50f084ae-41b8-4b3e-accb-1b45c6659e49,50f5c873-e1b8-4992-874e-5933c6659e49,4d781010-00b4-43ce-989b-3b5c0ab5431b,4d781010-521c-499c-bc09-3b5c0ab5431b,4d781010-741c-47aa-954a-3b5c0ab5431b,4d781010-e4c4-44d2-ad27-3b5c0ab5431b,4d6ed946-0208-4199-9346-37a20ab5431b,4dbf0ffd-8934-45ad-a522-7a5a0ab5431b,4d6ed943-2124-444e-aedc-37a20ab5431b,4d6ed946-0d34-4d49-9ee7-37a20ab5431b,4d6ed946-83d0-412b-a27a-37a20ab5431b,4dd16fa1-3cf4-4dfa-bdbe-61760ab5431b,4dd44fd4-0154-4acb-97fb-6e5c0ab5431b,4d6ed946-fce0-4b57-b230-37a20ab5431b,4d6ed946-be84-4fd2-b87d-37a20ab5431b,4d6ed946-d2cc-4730-9c8d-37a20ab5431b,4d6ed946-5cb8-4037-8a0c-37a20ab5431b,4d6ed946-fb58-4f6f-9bf5-37a20ab5431b,4d6ed946-388c-4e1f-b27d-37a20ab5431b,4d6ed946-c214-4651-9634-37a20ab5431b,4d6ed943-916c-4fc6-89fc-37a20ab5431b,4df65aa4-f768-430a-9b15-3a930ab5431b,4dfa9f35-6138-4e19-9ed8-03bf0ab5431b,4dfa7b09-14e0-4119-81d7-03c70ab5431b,4dd44fd4-4d48-48eb-a2a4-6e5c0ab5431b,4dfa9f08-ae64-4be2-af71-02eb0ab5431b,4d781010-7aa4-4eac-8c7a-3b5c0ab5431b,4e0aad7b-52a0-4578-ab12-2323323849cf,4e0ed08e-6fd0-4cb9-a153-3c30323849cf,4e41e3bb-5f6c-41c3-9179-0d41323849cf,4e41e4c9-8954-44f6-9a36-0c89323849cf,4eaf6b59-980c-4fde-93e5-5eb1323849cf,4d6ed946-5c00-4db9-94c1-37a20ab5431b,4eff7de4-806c-4bdf-a254-41bd323849cf,4f2f77cc-0fd0-4efc-9ca8-5fad323849cf,4f6518bf-de68-4164-b2bc-5dc3323849cf,4f6a92bd-020c-49f3-a5d7-68d5323849cf,4d6ed946-adf0-4272-9c48-37a20ab5431b,4fbc15c2-5280-4ff0-acef-6da8323849cf,4fcf9c66-93f0-4edd-9a25-1855323849cf,4ffb8464-f228-44df-b292-26c7323849cf,500e32ea-124c-46e8-9acf-2bb6323849cf,50120309-1248-4268-8c61-6a21323849cf,501335f6-3d3c-4c3d-a9bc-08bc323849cf,501334d1-036c-4068-be26-0870323849cf,508b33e4-f3e0-4424-aa58-21c3c6659e49,50970ab6-85a0-4cb5-be02-1e4ec6659e49,509c3e04-a6a8-4314-ae62-304fc6659e49,50ad7646-3a30-4a92-93e5-1b44c6659e49,50c57fc6-3e30-42c1-bbb0-6222c6659e49,4d6ed943-5448-44fe-8a6d-37a20ab5431b,4d6ed944-0ff0-4cb1-ac5f-37a20ab5431b,4d6ed944-1640-4cb3-b535-37a20ab5431b,4d6ed944-e774-4a95-a7dd-37a20ab5431b,4d6ed944-f6d4-42a3-bc13-37a20ab5431b,4d6ed944-e50c-495b-8556-37a20ab5431b,4d6ed944-a768-40a1-a568-37a20ab5431b,4d6ed944-02cc-4d6d-9c1c-37a20ab5431b,50ac5864-4c70-4b9e-a9d5-3c7ec6659e49,4d6ed946-779c-4c2a-91e2-37a20ab5431b,4d6ed946-8408-4a99-aa75-37a20ab5431b,4dd44fd4-4390-4d10-9866-6e5c0ab5431b,4d6ed945-4ae4-4d9e-a781-37a20ab5431b,4d6ed945-e218-40ca-9fb3-37a20ab5431b,4d6ed945-9058-44b5-bf07-37a20ab5431b,4d6ed945-2c70-44c3-8454-37a20ab5431b,4dae0d79-db2c-4c93-bb45-09490ab5431b,4d6ed945-1a58-4c47-a862-37a20ab5431b,4d6ed944-de08-48d7-882a-37a20ab5431b,4d6ed944-8874-4229-8a64-37a20ab5431b,4d6ed944-0270-4620-accf-37a20ab5431b,4d6ed945-92a0-4d6e-9f45-37a20ab5431b,4d6ed945-2588-4470-9e4d-37a20ab5431b,4d6ed945-cd88-4e66-98d7-37a20ab5431b,4d6ed945-ca38-4832-a838-37a20ab5431b,4d6ed945-2c1c-4ac6-9ee5-37a20ab5431b,4d6ed944-7208-4a55-b4d5-37a20ab5431b,4d6ed944-a758-4b52-9587-37a20ab5431b,4d6ed944-de7c-4a76-aa81-37a20ab5431b,4d6ed944-b460-443b-8c73-37a20ab5431b,4d6ed944-25c4-4773-bfb2-37a20ab5431b,4dbf0ffd-7184-478e-b5df-7a5a0ab5431b,4d6ed944-aec8-4854-b6e3-37a20ab5431b,4d6ed944-bbc4-422a-b286-37a20ab5431b,4d6ed944-91a8-49ae-ad5c-37a20ab5431b,4d6ed944-c748-4e71-be4a-37a20ab5431b,4d6ed944-72fc-454b-b174-37a20ab5431b,4d6ed944-d16c-4f00-a277-37a20ab5431b,4d6ed945-d49c-47a7-a01a-37a20ab5431b,4d6ed945-7148-4ef1-bc1f-37a20ab5431b,4d6ed945-5d2c-406a-a5d1-37a20ab5431b,4d6ed945-6c9c-4e9e-9306-37a20ab5431b,4dae0d79-9440-4b83-b230-09490ab5431b,4d6ed944-e778-49bf-953e-37a20ab5431b,4d6ed946-8ef0-45c4-871b-37a20ab5431b,4d6ed945-a9dc-4081-9d3c-37a20ab5431b,4d6ed945-09bc-4495-ace7-37a20ab5431b,4d6ed945-fad4-4d39-9b5a-37a20ab5431b,4d6ed945-847c-4502-9ebb-37a20ab5431b,4dae0d79-b330-4c0e-a8b4-09490ab5431b,4dd16fa1-6324-4bac-aba0-61760ab5431b,4d6ed944-96c4-4258-9c58-37a20ab5431b,4dd16fa1-7e24-4d95-b0d4-61760ab5431b,4d6ed946-8410-499d-89da-37a20ab5431b,4d6ed945-2414-4815-a588-37a20ab5431b,4d6ed944-c8d0-4c93-bbc7-37a20ab5431b,4d6ed945-e248-49c0-a9b3-37a20ab5431b,4d6ed944-8298-40ab-b891-37a20ab5431b,4dd44fd4-a620-4a5d-96a2-6e5c0ab5431b,4dc43ea1-4474-48de-86f6-31e50ab5431b,4dc43ea1-036c-4eab-b983-31e50ab5431b,4dc43ea1-6160-41dd-9623-31e50ab5431b,4dc43ea1-c8f4-4a47-83c8-31e50ab5431b,4dc43ea1-0018-425d-86c4-31e50ab5431b,4dc43ea1-ff60-4cf8-9a72-31e50ab5431b,4dc43ea0-2fec-4df2-9c7a-31e50ab5431b,4dc43ea0-4d44-46f4-b4e6-31e50ab5431b,4dc43ea0-62ec-433e-80ab-31e50ab5431b,4d6ed946-c3f0-48ed-b3a6-37a20ab5431b,4d6ed946-e580-466f-b21e-37a20ab5431b,4d6ed946-af50-44a3-9a76-37a20ab5431b,4d6ed946-a464-4da1-b543-37a20ab5431b,4d6ed945-ede4-45c1-b20d-37a20ab5431b,4d6ed945-14cc-49bf-8b52-37a20ab5431b,4d6ed944-2584-453b-930c-37a20ab5431b,4dd16fa1-ae6c-4665-b3d5-61760ab5431b,4dd16fa1-0bd8-4286-aa59-61760ab5431b,4dd44fd4-d1c8-4f59-ad65-6e5c0ab5431b,4dd44fd4-189c-4ec9-868e-6e5c0ab5431b,4d6ed945-6798-4f30-9a15-37a20ab5431b,4dfd9a13-5d88-4217-a078-36090ab5431b,4dfae6d8-b004-4d5d-8096-03c10ab5431b,4e1564bf-98ac-4d3c-ad5d-24ab323849cf,4e1d23e0-1920-4efb-95aa-1ee0323849cf,4e56dd24-c2a0-4577-8802-14ad323849cf,4e5ef00e-a65c-4488-bd3b-78cf323849cf,4d6ed944-c5a8-41e1-ba5f-37a20ab5431b,4d6ed944-f08c-4db5-a55d-37a20ab5431b,4d6ed944-8b2c-4f30-a74e-37a20ab5431b,4d6ed945-2518-4370-b5e2-37a20ab5431b,4ed7e622-d9ec-4800-851d-7a10323849cf,4f2f0291-9288-464c-9b06-247a323849cf,4d6ed944-de80-4f21-b1e2-37a20ab5431b,4f4692ba-4f58-4eb1-908a-4b7a323849cf,4f557f5f-7e18-40a6-a676-4d93323849cf,4f6d093f-2fd8-415e-916d-23aa323849cf,4f6d2af4-7b98-458b-acec-2290323849cf,4f9095a8-37d0-4181-8eb1-2a1c323849cf,4f920c9d-9ecc-4c92-9bae-7f84323849cf,4f3cc108-5054-4fa6-b3d6-16f1323849cf,4d6ed945-0f78-4a50-8412-37a20ab5431b,4fbc10a7-de68-43a3-a5a3-106b323849cf,4fbe6b0a-7494-439d-82e8-1887323849cf,4fe373ec-01ec-43d0-9918-37f2323849cf,4ff39b51-e3b4-4bfe-abc4-3617323849cf,4ffa7442-9ef4-4b0d-82c4-3210323849cf,50051b28-57f4-48a3-81d2-71ed323849cf,501b6dbd-1b04-4698-b379-5f56323849cf,503ecd5b-8ec4-4aaa-b02c-0fab323849cf,50933d2d-2054-43d0-a42b-1d26c6659e49,50a05b48-1f30-421a-af4a-6d23c6659e49,50d4f3ec-e61c-4918-9e41-4182c6659e49,4dbf0ffd-3f60-4724-88b4-7a5a0ab5431b,4d6ed942-78b4-4851-91e4-37a20ab5431b,4d6ed943-5928-4713-beb0-37a20ab5431b,4d6ed943-e1f8-4b00-8525-37a20ab5431b,4d6ed946-4f8c-4420-a552-37a20ab5431b,4d6ed943-a648-4eb3-b66f-37a20ab5431b,4d6ed946-2a70-4129-9eee-37a20ab5431b,4d6ed946-ce88-4dc3-ab3d-37a20ab5431b,4d6ed946-5e50-4c9c-a1de-37a20ab5431b,4d6ed946-ff48-4e02-85a1-37a20ab5431b,4d6ed946-4c14-46be-8702-37a20ab5431b,4d6ed943-aff4-49f5-9261-37a20ab5431b,4d6ed943-72ec-4ae4-9377-37a20ab5431b,4d6ed943-c97c-40e5-9439-37a20ab5431b,4d6ed945-49f4-40d3-84a8-37a20ab5431b,4d6ed945-5a8c-4f66-bfed-37a20ab5431b,4d6ed945-0b24-4056-a0a6-37a20ab5431b,4d6ed945-a258-4748-ace6-37a20ab5431b,4d6ed945-48fc-4310-94a0-37a20ab5431b,4d6ed945-3e40-411b-908a-37a20ab5431b,4d6ed945-5cf4-410d-bd3f-37a20ab5431b,4d6ed945-a1a0-4be1-9bfa-37a20ab5431b,4d6ed945-f288-45e0-8987-37a20ab5431b,4d6ed945-65b0-4d3a-b4a7-37a20ab5431b,4d6ed945-c550-4a6c-ba51-37a20ab5431b,4d6ed945-be7c-4853-bffc-37a20ab5431b,4dd44fd4-9e00-43d7-a2a0-6e5c0ab5431b,4dc43ea1-aebc-4bf2-aee0-31e50ab5431b,4dc43ea1-babc-42d4-afb6-31e50ab5431b,4d6ed943-4e58-4b3a-95ec-37a20ab5431b,4dc43ea1-7fa0-4455-a9b3-31e50ab5431b,4dc43ea1-837c-4e7c-8059-31e50ab5431b,4dc43ea1-29f4-4981-bd7a-31e50ab5431b,4dc43ea1-635c-4861-aa0a-31e50ab5431b,4dc43ea1-47cc-4da6-bb40-31e50ab5431b,4dc43ea1-57bc-49aa-8c7b-31e50ab5431b,4d6ed946-eaf0-4834-bc5b-37a20ab5431b,4d6ed943-4134-4e94-9a32-37a20ab5431b,4ee79a49-7f1c-41a9-83f3-4d7d323849cf,4d6ed942-1d68-4c54-a9fd-37a20ab5431b,4d6ed943-e718-404b-a90e-37a20ab5431b,4d6ed945-ef84-403e-b240-37a20ab5431b,4d6ed945-1428-4f5f-9901-37a20ab5431b,4d6ed944-396c-4e85-93ef-37a20ab5431b,4d6ed945-3ecc-4d71-9f47-37a20ab5431b,4d6ed945-32e4-4f61-9f36-37a20ab5431b,4d6ed945-ee78-46b4-9738-37a20ab5431b,4d6ed945-0bb8-4234-b94c-37a20ab5431b,4d6ed945-1d70-419a-a9a4-37a20ab5431b,4d6ed945-f25c-47f7-98bb-37a20ab5431b,4d6ed945-31d8-4b85-9f0f-37a20ab5431b,4d6ed945-9a28-4645-8f2a-37a20ab5431b,4d6ed945-4a60-4a17-a9db-37a20ab5431b,4d6ed945-6a64-45fb-b427-37a20ab5431b,4d6ed945-1ee4-487b-9aa6-37a20ab5431b,4d6ed945-5938-47ea-9993-37a20ab5431b,4d6ed945-4654-4e70-84ab-37a20ab5431b,4d6ed945-3548-4800-8d3b-37a20ab5431b,4d6ed946-c674-4c73-a298-37a20ab5431b,4d6ed944-a16c-4acd-9a29-37a20ab5431b,4d6ed944-919c-4183-a3b4-37a20ab5431b,4d6ed945-c3d4-42d2-878c-37a20ab5431b,4ebda614-33f8-483d-90ac-4973323849cf,4fd25f0e-8654-4109-882a-38a4323849cf,4db1aed3-a218-4833-b45b-056f0ab5431b,4dbf0ffd-12f4-43a3-a09e-7a5a0ab5431b,4d6ed945-fec8-4702-8dc1-37a20ab5431b,4d6ed945-1f08-437c-87ce-37a20ab5431b,4d6ed945-db10-47f0-ab8d-37a20ab5431b,4d6ed946-4464-42ef-be17-37a20ab5431b,4d6ed945-9fa0-4e8f-8a5e-37a20ab5431b,4d6ed945-a904-45d4-9f1f-37a20ab5431b,4e28bb48-74f0-4975-bf14-3ea1323849cf,4e267d08-9a44-464b-a2e8-2ccc323849cf,4e31ec31-0a90-4896-8d95-3671323849cf,4f764ad5-c304-43f5-93c1-0f3b323849cf,4f768187-873c-4dd2-90d6-55ac323849cf,4f768688-3eac-4aa2-8585-5947323849cf,4fa090fe-80bc-4663-b647-7549323849cf,4fa47ab7-2c34-47e0-9b1a-0ce3323849cf,4d6ed945-88ec-43ac-a4bb-37a20ab5431b,4fa7ea23-12e0-4253-85a8-043a323849cf,4fa9cfe1-5248-4895-ac6d-5ab8323849cf,4fb40604-57c8-4efc-a886-5f83323849cf,4fba6b3c-0a98-4446-ab1c-5742323849cf,4d6ed946-3af4-4944-a454-37a20ab5431b,4fbef7b4-1a6c-4787-a625-643a323849cf,4fc14a16-4900-47bb-88ec-0cd4323849cf,4fd126f6-1c9c-403d-bf2f-0452323849cf,4fdfcd2c-5934-43ab-9f8c-02c4323849cf,503d0b2c-d384-4d62-9422-2471323849cf,50a5a4a2-1ca8-42b4-967a-4793c6659e49,50d3c111-e534-4331-85c2-4182c6659e49,4d6ed946-b8b4-4559-ba0d-37a20ab5431b,4dbf0ffd-119c-4828-ac3e-7a5a0ab5431b,4d6ed945-1d64-4596-b57a-37a20ab5431b,4d6ed945-4284-4a1d-9ad6-37a20ab5431b,4d6ed946-860c-4cef-81ff-37a20ab5431b,4ded4df0-7d98-4b16-828c-07cb0ab5431b,4f0e45b4-35cc-48c4-b586-14eb323849cf,4f0ff5fd-be0c-4b2e-9393-2365323849cf,4f39fdca-e13c-4178-8998-0b21323849cf,4f47e887-3d6c-48bf-b526-62b9323849cf,4f485f98-8bd4-44f8-9304-6237323849cf,4f4aeae7-6008-4b94-a261-3305323849cf,4f60e4ca-4288-4ac6-8e1a-4163323849cf,4fa0930f-8f7c-424b-98cd-024c323849cf,50c7dc10-9458-4c96-9205-6225c6659e49,4d6ed942-0ffc-4470-81e6-37a20ab5431b,4d6ed943-d6e8-4b1d-9f0e-37a20ab5431b,4d6ed943-86e8-436b-8031-37a20ab5431b,4de7d244-5bd4-4924-b5e8-2ac50ab5431b,4e8fa445-0000-43c1-b692-2dc4323849cf,50fb6a9f-1a50-4b5b-bd87-2a5dc6659e49,4d6ed944-c384-43aa-badb-37a20ab5431b,4d6ed944-9904-416b-8496-37a20ab5431b,4d6ed944-54bc-4c9f-88d0-37a20ab5431b,4dbf0ffd-de90-484d-a382-7a5a0ab5431b,4d6ed945-23bc-44b6-84f8-37a20ab5431b,4d6ed943-fb28-4f94-ac86-37a20ab5431b,4dbf0ffd-fc28-49d7-a3e2-7a5a0ab5431b,4d6ed944-e12c-459f-b130-37a20ab5431b,4d6ed943-7940-44a8-ad76-37a20ab5431b,4d6ed945-abc0-4b92-9c35-37a20ab5431b,4d6ed944-5f10-4a0c-a405-37a20ab5431b,4d6ed944-0db0-4e6c-af57-37a20ab5431b,4d6ed943-ca7c-4b1c-85b1-37a20ab5431b,4e6faef2-f654-43ff-8c5b-044d323849cf,4f3ad776-f9b4-4fec-93f1-0488323849cf,4f4342b3-b374-40a0-88d1-25dc323849cf,4f960a03-4ee4-44c9-9e50-0617323849cf,4f98262b-fa3c-4493-8381-2104323849cf,4f970dd4-9abc-4da0-aa9d-6b48323849cf,4fcd2fc6-a6e8-41e2-8d45-46bc323849cf,4f1519c4-7a3c-4ab0-a062-7688323849cf,4feceda0-a39c-4cf1-99ee-7d87323849cf,4e78e3d6-41e4-4b75-83de-5af4323849cf,4f519428-bbac-49e3-b524-7b1f323849cf,4f519675-d1e4-4bb4-a53d-70e2323849cf,4f6fbf09-d590-45e1-ae15-65c6323849cf,4fe89ecc-d430-4ca2-8e4a-497c323849cf,4ff375e1-8bf4-4216-aa71-3617323849cf,4d6ed943-ffd0-4c92-aa9c-37a20ab5431b,4dd44fd4-39f4-487e-81dc-6e5c0ab5431b,4dae0d79-51dc-47d9-87a2-09490ab5431b,4e06cb5d-16d0-4aea-a357-569b323849cf,4e054438-acc4-4d10-a531-4f10323849cf,4e0bf053-71d0-4882-a320-2cdb323849cf,4e0bdaa5-faf0-4e7d-8c1b-2bd8323849cf,4e0c0711-9b3c-4114-8274-2cce323849cf,4e0ec0b8-e58c-4652-aa93-3be7323849cf,4e12a84a-f1d4-4bb1-ab8c-7d88323849cf,4e1675cb-5774-40ca-9dee-2ab5323849cf,4e17b6d3-aee0-43d2-8c2d-399f323849cf,4d6ed946-6e94-48a0-a73e-37a20ab5431b,4d6ed946-33c8-4482-9946-37a20ab5431b,4d6ed946-89e0-4053-a4e6-37a20ab5431b,4d6ed945-085c-4824-bed5-37a20ab5431b,4d6ed945-a0f8-4830-9b0f-37a20ab5431b,4d6ed945-e5d0-4e26-abb6-37a20ab5431b,4d6ed945-8314-43cd-8ce2-37a20ab5431b,4d6ed945-69a0-45e6-837f-37a20ab5431b,4d6ed945-e038-4ba7-b6ce-37a20ab5431b,4dd16fa1-b868-4003-8fa2-61760ab5431b,4dd16fa1-a848-4f7e-8341-61760ab5431b,4ddd86b3-08d4-47e8-9048-44170ab5431b,4dfa7b09-2ab8-4d04-88ec-03c70ab5431b,4e094c67-01d4-444b-b428-1c97323849cf,4e0400d7-ffa4-4b41-b1c8-3bdf323849cf,4e56f6c6-059c-4ee2-aab3-14cb323849cf,4e90fca6-f720-459a-9bf8-43c3323849cf,4e95b328-7634-4b73-9f48-18a1323849cf,4e970e6e-801c-4b1a-a080-0773323849cf,4e9b5c6e-d878-4489-813c-1d7d323849cf,4e9fdc68-4c2c-4409-bd8d-7098323849cf,4ea0a8b9-0814-4c1a-bd2c-7522323849cf,4ebca363-06d0-4555-87c6-43e5323849cf,4eb2f1ab-4894-4950-84cb-6854323849cf,4f0bf113-8b00-4bfa-93eb-68d9323849cf,4f151294-bba8-4e3b-9ac4-760a323849cf,4f1a0ccb-5bf0-4536-8d11-118c323849cf,4f5ac17d-a840-4d37-b425-1ce9323849cf,4f5ab459-a5c8-44f2-8869-1ca5323849cf,4f99f451-c898-46ab-88e3-690a323849cf,4f99fd36-bc68-4710-8393-79ee323849cf,4e98c904-f300-4269-b732-0d39323849cf,4fe22639-2eb8-478e-b161-303d323849cf,4ffa6fe2-3390-4958-90ca-26c7323849cf,4fe10faa-46a8-421b-9835-3496323849cf,503add33-2bbc-4049-a39c-5bba323849cf,506f87a0-d240-4ce4-8e1a-7c0f323849cf,5098a5c5-1744-4b43-91e4-304fc6659e49,509dfbf0-c8b0-4027-ba53-1e51c6659e49,50a06952-bb8c-42d0-9126-6d24c6659e49,50c02564-9f88-4f0c-bee6-6729c6659e49,50c55e6d-9744-4d8c-9ee2-6225c6659e49,50c663de-1bdc-49ce-a755-183cc6659e49,50d26cd0-654c-4f7d-a4ef-79f8c6659e49,50eb62c0-7cd8-4f35-ab82-67f4c6659e49,4d6ed944-bdf0-47e4-9b7f-37a20ab5431b,4d6ed944-2e28-47c1-a576-37a20ab5431b,4d6ed946-eca8-4b6f-ac1a-37a20ab5431b,4d6ed946-a48c-41e4-a617-37a20ab5431b,4d6ed943-ea98-486f-93e3-37a20ab5431b,4ddd86b3-e988-42ee-8dfa-44170ab5431b,4ded4f27-7f90-477c-acfa-07ca0ab5431b,4ded4df1-bab4-4489-9927-07cb0ab5431b,4ddd86b3-1228-4d7e-b8aa-44170ab5431b,4dd16fa1-9204-43bf-a6c4-61760ab5431b,4e56fd64-0398-4f61-b3b6-14cd323849cf,4e56fec9-5680-4bd0-93dc-14cb323849cf,4e570411-f948-47f0-bba3-14ca323849cf,4e570662-3024-4aca-a3a8-14b2323849cf,4f81f405-fce8-480e-8d7e-44b7323849cf,4f873b23-04b4-46c1-835d-6dd7323849cf,4f9b3090-1568-4694-8d0a-42fb323849cf,4fa1b32c-9abc-400e-a065-1d0a323849cf,5093343c-caa4-4975-9d15-1d23c6659e49,50c2f18f-f440-402d-bd8c-672ac6659e49,4f3c9e43-1ce0-476c-8ef8-07f7323849cf,4f3f285e-5adc-41e8-87c3-3241323849cf,4f3f53c1-3260-4c05-8c7d-3240323849cf,4f40955a-281c-4dfc-aeef-4a2a323849cf,4f4022f5-2670-4cbd-ae80-3f8f323849cf,4f444faf-e6c4-421d-87ce-2e70323849cf,4f502e85-a38c-42e5-b4a6-6a32323849cf,4f4fd976-174c-465e-a39e-6920323849cf,4f545745-c21c-4e00-b16a-4b47323849cf,4f5587e2-babc-4e1d-b1f2-4b49323849cf,4f5bdad0-3138-463c-ae88-3261323849cf,4f5d796a-de40-4baa-9c32-6f8a323849cf,4f5e9681-bcbc-4d1b-b2d6-3909323849cf,4f62321a-cdac-4969-a1b8-4c13323849cf,4f63de1e-4e94-4d2f-aaf8-520e323849cf,4f6700b8-c624-4315-86ac-04c4323849cf,4f67decc-980c-4c0d-b815-57db323849cf,4f6fff53-89e4-49a6-89bb-3940323849cf,4f70f757-a274-48b9-986a-42fe323849cf,4f7789fc-498c-462f-a0e4-0a77323849cf,4f77b96c-1780-47a1-8f3d-2cbe323849cf,4f7f8295-a414-4e29-bf00-58ab323849cf,4f810b71-2f88-4f22-91c1-51a3323849cf,4f7d070d-133c-47d3-a497-3e18323849cf,4f7fe952-1b60-4fe9-ab65-49a8323849cf,4f814907-bf78-44a3-b3f8-2e52323849cf,4f826e0b-c808-4284-aa9b-730d323849cf,4f838873-5d08-42de-bd87-5185323849cf,4f88d72b-6a68-4f1f-a007-5a55323849cf,4f88f9ab-3f20-4cd4-aa07-5a50323849cf,4f8ae400-c2ec-4609-b92c-50cc323849cf,4f8a72a2-c668-4cce-af3d-359c323849cf,4f8a4058-8a38-4937-92c3-359c323849cf,4f8cb0ea-0674-4974-9591-1154323849cf,4f93a7cf-a7ec-4bd4-ba25-59ba323849cf,4f9364af-f454-4d9a-9d38-2c3f323849cf,4f95fb5e-0adc-47aa-93f0-0617323849cf,4f9b388e-66b8-4a3c-9d7e-4c96323849cf,4f9e1fe1-8b20-42fa-8c62-2d00323849cf,4f9f5c66-42d4-4d2e-9f83-7e9f323849cf,4fa5e11f-a9b4-4082-949b-6aae323849cf,4fa5cf70-3654-42e9-804a-4f9a323849cf,4fa6fd97-b254-4f57-bc13-077b323849cf,4fb09fd0-80b8-44be-8309-3142323849cf,4fb30e8c-1518-4a67-bf04-1abf323849cf,4fb6c1dc-5ca8-424b-96fc-05ac323849cf,4fb69aed-23e8-420d-b840-1f70323849cf,4fb6f0cc-4f00-491c-ba3a-05b1323849cf,4fb6e577-4570-49de-add7-05af323849cf,4fb9f237-3040-46f3-a76c-0c12323849cf,4fba697c-e384-4e10-9a29-5742323849cf,4fc01dce-122c-4511-9019-5a6c323849cf,4fc03048-f260-46f5-951c-7475323849cf,4fc30cdf-7e44-491c-ac1a-0520323849cf,4fcbcde9-e6fc-4667-bf8f-3cec323849cf,4fce3f0e-d374-459c-a8da-1b8c323849cf,4fce44a2-3954-4fd0-8572-1ce7323849cf,4fce4237-1a64-48e7-9506-1ce4323849cf,4fd13307-4ce8-4ad1-a2d1-7c7d323849cf,4fd3ab1d-80d4-45b2-9d70-7cc2323849cf,4fd405ef-59b4-4e75-9e3d-4265323849cf,4fd7b222-ba68-42a0-99e4-0faa323849cf,4fd9691c-8d20-40df-9835-7c1a323849cf,4fda42df-6fe4-4d11-a9a5-7f60323849cf,4fd4f0e8-7d70-40c8-818a-2643323849cf,4fb04e6f-69c0-4fa9-b59f-45ba323849cf,4f5e8ab1-0180-4f94-9ed5-390b323849cf,4f74f43d-021c-4420-8a9e-7587323849cf,4f8e1d72-ed00-479f-83f5-0163323849cf,4f3a1549-06c0-40f2-9401-0b23323849cf,50ece064-1634-4fd8-b165-1b49c6659e49,50f11a4f-cf00-43fe-ae03-226fc6659e49,50f75d88-76b0-4f13-9de3-13f2c6659e49";

		CakeSession::delete("MediaFileReportQueue");
		
		$ids = explode(",",$str);

		$ids = array_unique($ids);

		CakeSession::write("MediaFileReportQueue",$ids);
		

	}




	public function static_test() {
		
	}

	
}