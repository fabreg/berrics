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
			"w301",
			"w302",
			"w303",
			"w304",
			"w305",
			"w306",
			"w307",
			"w308",
			"w309",
			"w310",
			"w311",
			"w312",
			"w313",
			"w314",
			"w315",
			"wnode1",
			"wnode2",
			"wnode3",
			"wnode4",
			"wnode5"
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
	//echo `scp /tmp/httpd.conf root@{$server}:/etc/httpd/conf/.`;
	echo "\n";
	//stop apache 
	echo `ssh root@{$server} 'apachectl -k graceful-stop'`;
	//echo `ssh root@{$server} 'rm -rf /var/log/httpd/error*'`;
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