<?php

class DailyopsConfig extends AppModel {


	public function returnConfig($dateIn = false,$cache = true) {
		
		if(!$dateIn) $dateIn = date("Y-m-d");

		$configToken = 'dops-config-'.$dateIn;

		if(($config = Cache::read($configToken,"1min")) === false || $cache == false) {

			$config = $this->findByDailyopsDate($dateIn);

			if($cache == true) Cache::write($config,$configToken,"1min");

		}

		return $config;
	}

}