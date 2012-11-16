#!/usr/bin/php
<?php 

$dir = dirname(__FILE__)."/";

$servers = array(
			"render1",
		);

foreach($servers as $server) {
	echo "\n";
	echo "####### \n";
	echo $server,"\n";
	echo "####### \n";
	echo "\n";
	
	//stop apache 
	#echo `ssh root@{$server} 'apachectl -k graceful-stop'`;
	echo "\n";
	echo `rsync -vaz --delete --exclude-from {$dir}exclude.txt {$dir}../ john@{$server}:/home/sites/berrics.v3/`;
	echo "\n";
	#echo `ssh root@{$server} 'apachectl start'`;
	echo "\n";
	
}