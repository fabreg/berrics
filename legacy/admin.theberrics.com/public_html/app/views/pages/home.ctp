<?php



$fb = FacebookApi::instance();

pr($fb->facebook->getSession());
pr($fb->facebook->getLoginUrl(array("req_perms"=>"email")));
if($fb->facebook->getUser()) {

	pr($fb->facebook->api("/me"));

}

//$out = `zip -r /home/sites/berrics.dev.bak.zip /home/sites/berrics.dev`;
//echo $out;


echo Security::hash('19Berrics82');


?>