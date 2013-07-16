<?php
//check for admin site
if (preg_match('/(v3\.admin\.|cp\.)/', $_SERVER['HTTP_HOST'])) {
	
} else {
	
######
# START THE SITE ROUTES FOR UNIFIED

	if(preg_match('/(v3\.|dev\.)/',$_SERVER['HTTP_HOST'])) {


	}

}

//site index
Router::connect("/unified",array("controller"=>"site","plugin"=>"unified"));

//profile pages
if(preg_match('/^(\/unified\/)(.*)(\.html)$/',$_SERVER['SCRIPT_URL'])) {

	Router::connect("/unified/:uri",
			array("plugin"=>"unified","controller"=>"store_profile","action"=>"view"),
			array(
				"uri"=>"[a-zA-Z0-9\-_]{3,}.html"
			)
	);

	Router::connect("/unified/:action/:uri",
			array("plugin"=>"unified","controller"=>"store_profile","action"=>"bio"),
			array(
				"uri"=>"[a-zA-Z0-9\-_]{3,}.html"
			)
	);

}