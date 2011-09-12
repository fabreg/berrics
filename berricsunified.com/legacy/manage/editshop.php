<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>The Berrics - EDIT CUSTOMER</title>
<link href="manager.css" rel="stylesheet" type="text/css" />
<link href="formsteez.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php

include '../badmin/searchcon.php';

$shopid = $_GET['shopid'];

$shop_sql = "SELECT * FROM shops WHERE id = '$shopid' LIMIT 1";
$shop_res = mysql_query($shop_sql) or print("ERROR:" . mysql_error());

while ($shop_lis = mysql_fetch_array($shop_res)) {

	$shop_id = $shop_lis['id'];
	$shop_nm = $shop_lis['shop_name'];
	$shop_a1 = $shop_lis['address1'];
	$shop_a2 = $shop_lis['address2'];
	$shop_cy = $shop_lis['city'];
	$shop_st = $shop_lis['state'];
	$shop_ls = $shop_lis['full_state'];
	$shop_zp = $shop_lis['zip'];
	$shop_co = $shop_lis['country'];
	$shop_ph = $shop_lis['phone'];
	$shop_bi = $shop_lis['shop_bio'];
	$shop_lo = $shop_lis['shop_logo'];
	$shop_pa = $shop_lis['shop_path'];
	$shop_la = $shop_lis['latitude'];
	$shop_ln = $shop_lis['longitude'];
	
}

// REPLACE 'THE' AT THE BEGINNING OF SHOPNAME
$tempshop = strtolower($shop_nm);
if (substr($tempshop, -5) == ", the") {
	$shop_nm = "The " . substr($shop_nm, 0, -5);
}

echo "<h2>EDIT SHOP</h2> \n";
echo "<form name=\"editshop\" id=\"editshop\" method=\"POST\" action=\"updateshop.php\"> \n";

echo "<label for=\"shop_id\">ID</label> \n";
echo "<input type=\"text\" id=\"shop_id\" name=\"shop_id\" readonly=\"readonly\" value=\"$shop_id\" /> <br /> \n";

echo "<label for=\"shop_nm\">SHOP NAME</label> \n";
echo "<input type=\"text\" id=\"shop_nm\" name=\"shop_nm\" value=\"$shop_nm\" /> <br /> \n";

echo "<label for=\"shop_a1\">ADDRESS 1</label> \n";
echo "<input type=\"text\" id=\"shop_a1\" name=\"shop_a1\" value=\"$shop_a1\" /> <br /> \n";

echo "<label for=\"shop_a2\">ADDRESS 2</label> \n";
echo "<input type=\"text\" id=\"shop_a2\" name=\"shop_a2\" value=\"$shop_a2\" /> <br /> \n";

echo "<label for=\"shop_cy\">CITY</label> \n";
echo "<input type=\"text\" id=\"shop_cy\" name=\"shop_cy\" value=\"$shop_cy\" /> <br /> \n";

echo "<label for=\"shop_st\">STATE / PROV</label> \n";
echo "<input type=\"text\" id=\"shop_st\" name=\"shop_st\" value=\"$shop_st\" /> <br /> \n";

echo "<label for=\"shop_ls\">FULL STATE / PROV</label> \n";
echo "<input type=\"text\" id=\"shop_ls\" name=\"shop_ls\" value=\"$shop_ls\" /> <br /> \n";

echo "<label for=\"shop_zp\">ZIP</label> \n";
echo "<input type=\"text\" id=\"shop_zp\" name=\"shop_zp\" value=\"$shop_zp\" /> <br /> \n";
	
echo "<label for=\"shop_co\">COUNTRY</label> \n";
echo "<select id=\"shop_co\" name=\"shop_co\"> \n";

switch ($shop_co) {
	case "CAN" :
		echo "<option value=\"CAN\" selected>CANADA</option> \n";
		echo "<option value=\"USA\">US</option> \n";
		echo "<option value=\"MEX\">MEXICO</option> \n";
		break;
	case "MEX" :
		echo "<option value=\"MEX\" selected>MEXICO</option> \n";
		echo "<option value=\"USA\">US</option> \n";
		echo "<option value=\"CAN\">CANADA</option> \n";
		break;
	default :
		echo "<option value=\"USA\" selected>USA</option> \n";
		echo "<option value=\"CAN\">CAN</option> \n";
		echo "<option value=\"MEX\">MEX</option> \n";
		break;
}

echo "</select> <br /> \n";		
		
echo "<label for=\"shop_ph\">PHONE</label> \n";
echo "<input type=\"text\" id=\"shop_ph\" name=\"shop_ph\" value=\"$shop_ph\" /> <br /> \n";

echo "<label for=\"shop_bi\">SHORT BIO</label> \n";
echo "<textarea cols=\"50\" rows=\"4\" name=\"shop_bi\" id=\"shop_bi\">";
echo $shop_bi;
echo "</textarea> <br /> \n";
		
echo "<label for=\"shop_lo\">LOGO</label> \n";
echo "<input type=\"text\" id=\"shop_lo\" name=\"shop_lo\" value=\"$shop_lo\" /> <br /> \n";
		
echo "<label for=\"shop_pa\">DIRECTORY</label> \n";
echo "<input type=\"text\" id=\"shop_pa\" name=\"shop_pa\" value=\"$shop_pa\" /> <br /> \n";

echo "<label for=\"shop_la\">LATITUDE</label> \n";
echo "<input type=\"text\" id=\"shop_la\" name=\"shop_la\" value=\"$shop_la\" /> <br /> \n";

echo "<label for=\"shop_ln\">LONGITUDE</label> \n";
echo "<input type=\"text\" id=\"shop_ln\" name=\"shop_ln\" value=\"$shop_ln\" /> <br /> \n";



?>
	<br /><br />
	<input type="submit" value="submit" /> <br />
	<br /><br />
	<input type="button" name="cancel" value="cancel" onclick="window.location = 'index.php' " /> <br />
	<br />
  

</form>




</body>

</html>
