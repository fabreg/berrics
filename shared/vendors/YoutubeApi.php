<?php
/**
 * BERRICS YOUTUBE API
 */

class YoutubeApi {


	public $youtube = false;

	private $devKey = 'AI39si72k-DemceO36Jpjg0AMV7E9tDDOyvv4SsO_tC8gK_R-KKhLiugFiHIQDWTbuAFNo_QbOHPT5J-n8qFpBdPV0TAdKNN2g';

	public $videos = array();

	public function __construct() {
		
		$include = get_include_path();
        $include.=  ":".DS.'home'.DS.'sites'.DS.'berrics.v3'.DS.'shared'.DS.'vendors' . DS;
        $successful = set_include_path($include);
        
        if (!$successful) {
            throw new Exception('ZendComponent failed to set include path.', E_ERROR);
        }
        require_once('Zend/Loader.php'); 


        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        Zend_Loader::loadClass('Zend_Gdata_AuthSub');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

		$authenticationURL= 'https://www.google.com/accounts/ClientLogin';
		$httpClient = 
  			Zend_Gdata_ClientLogin::getHttpClient(
              //$username = 'youtube@theberrics.com',
              //$password = 'palmetto',
  			   $username = "john.c.hardy@gmail.com",
  			   $password = "artosari",
              $service = 'youtube',
              $client = null,
              $source = 'The Berrics', // a short string identifying your application
              $loginToken = null,
              $loginCaptcha = null,
              $authenticationURL);

  	
  		$this->youtube = new Zend_Gdata_YouTube($httpClient,'The Berrics','The Berrics',$this->devKey);

  		$this->youtube->setMajorProtocolVersion(2);

	}

	public function test() {

		$videoFeed = $this->youtube->getUserUploads('default');

		$this->printEntireFeed($videoFeed,1);
		die();

	}

	public function getAndPrintVideoFeed($location = Zend_Gdata_YouTube::VIDEO_URI) {
	 
	  // set the version to 2 to receive a version 2 feed of entries
	  
	  $videoFeed = $yt->getVideoFeed($location);
	  $this->printVideoFeed($videoFeed);
	}
 
	public function printVideoFeed($videoFeed) {
	  $count = 1;
	  foreach ($videoFeed as $videoEntry) {
	    echo "Entry # " . $count . "\n";
	    $this->printVideoEntry($videoEntry);
	    echo "\n";
	    $count++;
	  }
	}

	public function printVideoEntry($videoEntry) {
	  // the videoEntry object contains many helper functions
	  // that access the underlying mediaGroup object
	  echo 'Video: ' . $videoEntry->getVideoTitle() . "\n";
	  echo 'Video ID: ' . $videoEntry->getVideoId() . "\n";
	  echo 'Updated: ' . $videoEntry->getUpdated() . "\n";
	  echo 'Description: ' . $videoEntry->getVideoDescription() . "\n";
	  echo 'Category: ' . $videoEntry->getVideoCategory() . "\n";
	  echo 'Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "\n";
	  echo 'Watch page: ' . $videoEntry->getVideoWatchPageUrl() . "\n";
	  echo 'Flash Player Url: ' . $videoEntry->getFlashPlayerUrl() . "\n";
	  echo 'Duration: ' . $videoEntry->getVideoDuration() . "\n";
	  echo 'View count: ' . $videoEntry->getVideoViewCount() . "\n";
	  echo 'Rating: ' . $videoEntry->getVideoRatingInfo() . "\n";
	  echo 'Geo Location: ' . $videoEntry->getVideoGeoLocation() . "\n";
	  echo 'Recorded on: ' . $videoEntry->getVideoRecorded() . "\n";
	  
	  // see the paragraph above this function for more information on the 
	  // 'mediaGroup' object. in the following code, we use the mediaGroup
	  // object directly to retrieve its 'Mobile RSTP link' child
	  foreach ($videoEntry->mediaGroup->content as $content) {
	    if ($content->type === "video/3gpp") {
	      echo 'Mobile RTSP link: ' . $content->url . "\n";
	    }
	  }
	  
	  echo "Thumbnails:\n";
	  $videoThumbnails = $videoEntry->getVideoThumbnails();

	  foreach($videoThumbnails as $videoThumbnail) {
	    echo $videoThumbnail['time'] . ' - ' . $videoThumbnail['url'];
	    echo ' height=' . $videoThumbnail['height'];
	    echo ' width=' . $videoThumbnail['width'] . "\n";
	  }
	}

	public function printEntireFeed($videoFeed, $counter) {
	 foreach($videoFeed as $videoEntry) {
	   echo $counter . " - " . $videoEntry->getVideoTitle() . "\n";
	   echo $videoEntry->getVideoId(),"\n";
	   $counter++;
	 }

	 // See whether we have another set of results
	 try {
	   $videoFeed = $videoFeed->getNextFeed();
	 } catch (Zend_Gdata_App_Exception $e) {
	   echo $e->getMessage() . "\n";
	   return;
	 }

	 if ($videoFeed) {
	   echo "-- next set of results --\n";
	   $this->printEntireFeed($videoFeed, $counter);
	 }
	}

	public function getAllVideos() {

		$videoFeed = $this->youtube->getUserUploads('default');

		$this->parseGetAllVideos($videoFeed);

		return $this->videos;

	}

	private function parseGetAllVideos($feed=false) {

		foreach($feed as $video) {
			
			$thumbs = $video->getVideoThumbnails();
			//die(print_r($thumbs));
			$this->videos[] = array(
				"title"=>$video->getVideoTitle(),
				"video_id"=>$video->getVideoId(),
				"tags"=>implode(", ", $video->getVideoTags()),
				"isVideoPrivate"=>$video->isVideoPrivate(),
				"thumb0"=>$thumbs[0]['url'],
				"thumb1"=>$thumbs[1]['url'],
				"thumb2"=>$thumbs[2]['url']
			);

		}

		try {

			$feed = $feed->getNextFeed();

		} catch(Zend_Gdata_App_Exception $e) {

			return;

		}

		if($feed) $this->parseGetAllVideos($feed);

	}

	public function getUploadedVideos($hidden = true) {
		
			//$devTagUrl ='http://gdata.youtube.com/feeds/api/videos/-/%7Bhttp%3A%2F%2Fgdata.youtube.com%2Fschemas%2F2007%2Fdevelopertags.cat%7Dberricsupload';

			$query = $this->youtube->newVideoQuery();

			$query->setVideoQuery("berricsapi");

			die(print_r($query->getQueryUrl(2)));

	  		$feed = $this->youtube->getVideoFeed($query->getQueryUrl(2));

	  		die(print_r($feed));

	  		$this->parseGetAllVideos($feed);

	  		return $this->videos;

	}

	public function returnVideoEntry($video_id = false) {

		if(!$video_id) throw new Exception("Video ID is invalid");

		$videoEntry = $this->youtube->getVideoEntry($video_id);

		$thumbs = $videoEntry->getVideoThumbnails();

		$video = array(
				"title"=>$videoEntry->getVideoTitle(),
				"video_id"=>$videoEntry->getVideoId(),
				"tags"=>implode(", ", $videoEntry->getVideoTags()),
				"isVideoPrivate"=>$videoEntry->isVideoPrivate(),
				"thumb0"=>$thumbs[0]['url'],
				"thumb1"=>$thumbs[1]['url'],
				"thumb2"=>$thumbs[2]['url']
			);

		return $video;

	}


	public function uploadVideo($Dailyop = false) {

		//if(!$Dailyop) throw new Exception("Invalid Dailyops ID");
		//let's get the video that needs to be uploaded

		$DailyopsShareParameter = ClassRegistry::init("DailyopsShareParameter");

		Zend_Loader::loadClass('Zend_Gdata_YouTube_VideoEntry');

		$videoEntry = new Zend_Gdata_YouTube_VideoEntry();

		$src = $this->youtube->newMediaFileSource("/tmp/Ishod_fourstar.mp4");

		$src->setContentType('video/mp4');

		$src->setSlug("Ishod_fourstar.mp4");

		$videoEntry->setMediaSource($src);

		$videoEntry->setVideoTitle("Testing Upload API");

		$videoEntry->setVideoCategory('Sports');

		$videoEntry->setVideoDeveloperTags(array("berricsapi","berricsupoad"));

		$videoEntry->setVideoTags("ishod, the berrics, berricsapi");

		$uploadUrl = 'http://uploads.gdata.youtube.com/feeds/api/users/default/uploads';
		
		try {
		  $newEntry = $this->youtube->insertEntry($videoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');
		} catch (Zend_Gdata_App_HttpException $httpException) {
		  echo $httpException->getRawResponseBody();
		} catch (Zend_Gdata_App_Exception $e) {
		    echo $e->getMessage();
		}

		//die(print_r($newEntry));
		$newEntry->setMajorProtocolVersion(2);
		$newVideo = array(
			"video_id"=>$newEntry->getVideoId()
		);

		die(print_r($newVideo));

	}

	public function updateVideo() {



	}






############ 3.0 code
	/*

	private $devKey = 'AI39si7Dm6JSwMXyw0WNA-7v39Ssz2NYBI9tx_c47M4uxthKWq3Z87vXOp5O2VvtY4NrkIywgSYKsWmnM8wuZermnjfYmoafJQ';
	private $accessToken = '{"access_token":"ya29.AHES6ZSVoq9iXA6w-f3j1EMbe_tOWv_jbtAG6eHQBXTcL78","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/9XBGIJ7CW-_LdiGDaw5R1FaLqE7LrsBpm4Y0OfGuQ7M","created":1352414004}';

	public $apiClient;

	private $youtube = false;

	public function __construct() {

		App::import("Vendor","GoogleApiClient",array("file"=>"google-api-php-client/src/Google_Client.php"));
		App::import("Vendor","GoogleBigqueryApi",array("file"=>"google-api-php-client/src/contrib/Google_YoutubeService.php"));
		
		$apiClient = new Google_Client();
		$apiClient->setApplicationName("Testing App");
		$apiClient->setClientId("632632109626-oi3e0cvvkbur75r1fe4cg80dbuk4sjds@developer.gserviceaccount.com");
		$apiClient->setClientSecret("dhWNmyamq9LPLfMpWStQbmww");
		$apiClient->setRedirectUri("http://".$_SERVER['HTTP_HOST']."/tester/goog_callback");

		$apiClient->setScopes(array(
				'https://www.googleapis.com/auth/youtube'
		));

		$apiClient->setApprovalPrompt("auto");
		
		$apiClient->setAccessToken($this->accessToken);
		
		$this->apiClient = $apiClient;

		$this->youtube = new Google_YoutubeService($this->apiClient);

	}


	public function getChannel() {
		
		$details = $this->youtube->channels->listChannels('contentDetails',array("id"=>"ogberrics"));

		die(print_r($details));

		return $details;

	}


	*/
}