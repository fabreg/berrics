<?php


App::import("Controller","LocalApp");

class AwsTestController extends LocalAppController {


	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	public function test() {
		
		App::import("Vendor","AwsApi",array("file"=>"aws/sdk.class.php"));

		$s3 = new AmazonS3();

		die(pr($s3));

		$res = $s3->list_buckets();
		
		die(pr($res->body->to_stdclass()));

	}


}

