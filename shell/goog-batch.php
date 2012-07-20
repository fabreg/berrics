#!/usr/bin/php
<?php

	$dir = dirname(__FILE__);
	
	$total = 42;

	$count = 1;

	$total_rows = 3000000;
	
	$start = 46000000;
	
	while($count<=$total) {
		
		echo system("$dir/googetl.php --total=$total_rows --start=$start");
		
		$count++;
		$start += $total_rows;
		
	}

?>