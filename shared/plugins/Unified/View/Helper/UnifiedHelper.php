<?php


class UnifiedHelper extends AppHelper {

	public $helpers = array("Html");


	public function mapJsIncludes() {

		$this->Html->script(array("https://maps.googleapis.com/maps/api/js?key=AIzaSyDOIaopnOYjAM917jmPKLK5Z8Spw58yIKM&sensor=false"),array("inline"=>false));

	}

	public function storeProfileIncludes() {


		$this->Html->css(array("v3/unified_layout","v3/unified_store_layout"),"stylesheet",array("inline"=>false));


	}

}