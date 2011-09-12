<?php
/***********************
**  GO FUCK YOURSELF  **
***********************/
include '../badmin/searchcon.php';

// ORDER RESULTS BY
if (isset($_GET['ob'])) {
	$ord = $_GET['ob'];
} else {
	$ord = "id";
}


?>

<html>

<head>

<title>MANAGE THOSE SHOPS BITCH</title>
<link href="manager.css" rel="stylesheet" type="text/css" />
<link href="formsteez.css" rel="stylesheet" type="text/css" />

</head>

<body>

<form name="addnewshop" method="POST" action="addshop.php">

<h3>ADD NEW SHOP</h3>

	<label for="shopname">SHOP NAME</label>
	<input type="text" id="shopname" name="shopname" /> <br />

	<label for="address1">ADDRESS 1</label>  
	<input type="text" id="address1" name="address1" /> <br />

	<label for="address2">ADDRESS 2</label>  
	<input type="text" id="address2" name="address2" /> <br />

	<label for="city">CITY</label>  
	<input type="text" id="city" name="city" /> <br />

	<label for="state">STATE / PROVINCE</label>  
	<input type="text" id="state" name="state" />  <br />

	<label for="zip">ZIP</label>  
	<input type="text" id="zip" name="zip" /> <br />

	<label for="country">COUNTRY</label>  
	<select name="country" id="country">
		<option value="USA" selected>UNITED STATES</option>
		<option value="CAN">CANADA</option>
	</select> <br />

	<label for="phone">PHONE</label>  
	<input type="text" id="phone" name="phone" /> <br />
	
	<label for="shopbio">SHORT BIO</label>  
	<textarea cols="50" rows="4" name="shopbio" id="shopbio"></textarea> <br />
	
	<label for="shoplogo">LOGO FILENAME</label>  
	<input type="text" id="shoplogo" name="shoplogo" />  <br />

	<label for="shoppath">DIRECTORY</label>  
	<input type="text" id="shoppath" name="shoppath" /> <br />

	<input type="submit" value="submit" /> <br />	

</form>

<hr />

<h3>EDIT EXISTING SHOP</h3>

<table width="800" border="2" cellspacing="8" cellpadding="2">
	<tr>
		<th><a href="index.php?ob=id">ID</a></th>
		<th><a href="index.php?ob=shop_name">SHOP</a></th>
		<th><a href="index.php?ob=city">CITY</a></th>
		<th><a href="index.php?ob=state">STATE</a></th>
		<th><a href="index.php?ob=country">COUNTRY</a></th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>

<?php

$getshops_sql = "SELECT id, shop_name, city, state, country FROM shops ORDER BY $ord ASC";
$getshops_res = mysql_query($getshops_sql) or print("ERROR:" . mysql_error());

while ($shoprow = mysql_fetch_array($getshops_res)) {
	$shopid = stripslashes($shoprow['id']);
	$shopname = stripslashes($shoprow['shop_name']);
	$shopcity = stripslashes($shoprow['city']);
	$shopstate = stripslashes($shoprow['state']);
	$shopcountry = stripslashes($shoprow['country']);
	
	// REPLACE 'THE' AT THE BEGINNING OF SHOPNAME
	$tempshop = strtolower($shop_nm);
		if (substr($tempshop, -5) == ", the") {
			$shop_nm = "The " . substr($shop_nm, 0, -5);
	}
	
	echo "	<tr> \n";
	echo "		<td>" . $shopid . "</td> \n";
	echo "		<td><a href=\"editshop.php?shopid=" . $shopid . "\">" . $shopname . "</a></td> \n";
	echo "		<td>" . $shopcity . "</td> \n";
	echo "		<td>" . $shopstate . "</td> \n";
	echo "		<td>" . $shopcountry . "</td> \n";
	echo "		<td><a href=\"editshop.php?shopid=" . $shopid . "\">EDIT</a></td> \n";
	echo "		<td><a href=\"delshop.php?shopid=" . $shopid . "\">DELETE</a></td> \n";
	echo "	</tr> \n";
	
}

?>

</table>

</body>

</html>
