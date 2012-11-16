#!/usr/bin/php
<?php 

$dir = dirname(__FILE__)."/";

$servers = array(
			"render1",
			"render2",
			"render3",
			"render4",
			"render5",
			"render6",
			"render9"
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
echo "Flushing mem1","\n";

echo `ssh root@mem1 'echo "flush_all" | nc 127.0.0.1 11211';`,"\n";

echo "\n Done! :-)","\n","\n","\n","\n";
?>