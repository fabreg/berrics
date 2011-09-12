<?php 


Router::connect("/",array("controller"=>"home","action"=>"index"));

Router::connect("/:uri",array("controller"=>"home","action"=>"index"),array(

	"uri"=>"[a-zA-Z0-9\-_]{4,}.html"

));