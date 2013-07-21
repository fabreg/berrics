<?php

$URL = parse_url($_SERVER['REQUEST_URI']);

//site index
Router::connect("/unified",array("controller"=>"site","plugin"=>"unified"));

//profile pages
if(preg_match('/^(\/unified\/)(.*)(\.html)$/',$URL['path'])) {
	
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