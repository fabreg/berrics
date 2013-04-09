<?php


class UnifiedHelper extends AppHelper {

	public $helpers = array("Html");


	public function mapJsIncludes() {

		$this->Html->script(array("https://maps.googleapis.com/maps/api/js?key=AIzaSyDOIaopnOYjAM917jmPKLK5Z8Spw58yIKM&sensor=false"),array("inline"=>false));

	}

}