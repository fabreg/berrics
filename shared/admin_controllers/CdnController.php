<?php

App::uses("LocalAppController","Controller");


class CdnController extends LocalAppController {


	public $uses = array();

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->initPermissions();

	}


	public function upload_fb_assets() {



	}

	public function handle_upload() {
		
		$file = $this->request->data['AssetFile']['asset-file'];

		$valid = array("js","css");

		$ext  = pathinfo($file['name'],PATHINFO_EXTENSION);

		if(!is_uploaded_file($file['tmp_name']) || !in_array($ext,$valid)) {

			$this->Session->setFlash("Invalid Upload");

			$this->redirect("/cdn/upload_fb_assets");

			return;

		} else {

			//move the file to tmp
			move_uploaded_file($file['tmp_name'], TMP."uploads/".$file['name']);

			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));

			$img = ImgServer::instance();

			$img->upload_fb_tab_assets($file['name'],TMP."uploads/".$file['name']);

			//unlink(TMP."uploads/".$file['name']);

		}

		$this->Session->setFlash("File has been uploaded and processed");

		$this->redirect("/cdn/upload_fb_assets");

		
	}

}