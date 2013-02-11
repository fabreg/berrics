#!/usr/bin/php
<?php 

$dir = dirname(__FILE__)."/";

//asset servers
$asset = array(
			"asset01",
			"asset02",
			//"asset03"
	);

//app servers
$servers = array(
			"w1",
			"w20",
			"w21",
			"w22",
			"w23",
			"w24",
			"w25",
			"w27",
			"w28",
			"w29",
			"w30",
			"w31",
			"w32",
			"w33",
			"w34",
			"w35",
			"w36",
			"w37",
			"w38",
			"w39",
			"w40"
		);


//sync asset servers

foreach($asset as $server) {

	echo "\n";
	echo "########","\n";
	echo $server,"\n";
	echo "########","\n";
	echo "\n";

	echo `rsync -vaz --delete --exclude-from {$dir}exclude.txt {$dir}../ root@{$server}:/home/sites/berrics.v3/`;

	echo "\n";

}

//sync app servers and graceful restart apache
foreach($servers as $server) {
	echo "\n";
	echo "####### \n";
	echo $server,"\n";
	echo "####### \n";
	echo "\n";
	
	//sync apache httpd.conf
	echo `scp /tmp/httpd.conf root@{$server}:/etc/httpd/conf/.`;
	echo "\n";
	//stop apache 
	echo `ssh root@{$server} 'apachectl -k graceful-stop'`;
	echo "\n";
	echo `rsync -vaz --delete --exclude-from {$dir}exclude.txt {$dir}../ root@{$server}:/home/sites/berrics.v3/`;
	echo "\n";
	echo `ssh root@{$server} 'apachectl start'`;
	echo "\n";
	
}

echo "Flushing mem1","\n";

echo `ssh root@mem1 'echo "flush_all" | nc 127.0.0.1 11211';`,"\n";

echo "\n Done! :-)","\n","\n","\n","\n";

?>