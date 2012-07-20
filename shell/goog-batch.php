#!/usr/bin/php
<?php

	$dir = dirname(__FILE__);
	
	$total = 47;

	$count = 1;

	$total_rows = 3000000;
	
	$start = 43000000;
	
	while($count<=$total) {
		
		echo `$dir/googetl.php --total=$total_rows --start=$start`;
		
		$count++;
		$start += $total_rows;
		
	}

?>