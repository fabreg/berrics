<?php
/*****************************

	GET VARS:	shopid
			
*****************************/
include '../badmin/searchcon.php';

$delshop = $_GET['shopid'];

$findshop_sql = "DELETE FROM shops WHERE id = '$delshop' LIMIT 1";
$findshop_res = mysql_query($findshop_sql) or print("ERROR:" . mysql_error());

header("Location: index.php");

?>