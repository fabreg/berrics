<?php
if (!isset($_POST['shop_id'])) {
	header("Location: http://localhost:8888/UNIFIED/search_test.html");
}
include '../badmin/searchcon.php';

// RETRIEVE POST VARS
$sid = $_POST['shop_id'];
$snm = $_POST['shop_nm'];
$sa1 = $_POST['shop_a1'];
$sa2 = $_POST['shop_a2'];
$scy = $_POST['shop_cy'];
$sst = $_POST['shop_st'];
$sls = $_POST['shop_ls'];
$szp = $_POST['shop_zp'];
$sco = $_POST['shop_co'];
$sph = $_POST['shop_ph'];
$sbi = $_POST['shop_bi'];
$slo = $_POST['shop_lo'];
$spa = $_POST['shop_pa'];
$sla = $_POST['shop_la'];
$sln = $_POST['shop_ln'];

// REMOVE 'THE' FROM SHOP NAMES FOR ALPHABETIZING
$tempshop = strtolower($snm);
if (substr($tempshop, 0, 4) == "the ") {
	$snm = substr($snm, 4);
	$snm .= ", The";
}

//
$editshop_sql = "UPDATE shops SET shop_name = '$snm', address1 = '$sa1', address2 = '$sa2', city = '$scy', 
					 state = '$sst', full_state = '$sls', zip = '$szp', country = '$sco', phone = '$sph', 
					 shop_bio = '$sbi', shop_logo = '$slo', shop_path = '$spa', latitude = '$sla', longitude = '$sln' 
					 WHERE id = $sid LIMIT 1;";
$editshop_res = mysql_query($editshop_sql) or print ("ERROR:" . mysql_error());

header("Location: index.php");

?>
