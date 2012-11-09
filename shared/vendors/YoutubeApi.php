<?php
/**
 * BERRICS YOUTUBE API
 */

class YoutubeApi {

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



}