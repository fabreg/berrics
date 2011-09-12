<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>The Berrics - UNIFIED</title>

		<meta http=equiv="Content-Type"	content="text/html; charset=iso-8859-1" />
		<script language="JavaScript" src="js/berrics.js"></script>
		<script language="JavaScript" src="js/swfobject.js"></script>
		<script language="JavaScript" src="js/frameheight.js"></script>
		<link href="unified.css" rel="stylesheet" type="text/css">
		

	</head>

	<body style="background-image:none; background:transparent; padding-bottom:40px;">
		<!-- SHOP SEARCH -->
		<div id="srchresults">
			<div id="search">
				<div id="bar">
					<form name="shopsearch" method="POST" action="">
						<img src="img/search_by.png" width="84" border="0" alt="" style="margin-right:2px;" />
						<select name="s_type" title="s_type">
							<option value="zip" selected>POSTAL CODE</option>
							<option value="sta">STATE / PROVINCE</option>
							<option value="nam">SHOP NAME</option>
						</select>
						&nbsp;
						<input type="text" name="s_value" title="s_value" />
						&nbsp;
						<input type="submit" value="SEARCH" />
					</form>
				</div>
			</div>


		<!-- BEGIN RESULTS -->
		
		<!-- BEGIN SHOP SEARCH RESULTS -->

		<div id="srchtop"><h3>Search Results</h3></div>

		<div id="srchmid">
			<div class="pagenav"><a href="#">< Previous</a> | <a href="#">Next ></a></div>

		
<?php
/********************************
*
* INPUT FROM SEARCHBOX COMES IN AS s_type AND s_value
* FLASH SENDS AS st 
* use the var 'ovr' to constrain query to state only 
*
********************************/
include 'badmin/searchcon.php';


if (isset($_GET['ns'])) {

	$rawinput = strip_tags($_GET['ns']);

} else if (isset($_GET['st'])) {

	$rawinput = strip_tags($_GET['st']);
	$ovr = "state";
	
}

// CLEANSE INPUT
$newsearch = trim($rawinput);
$newsearch = strtolower($newsearch);
$newsearch = str_replace("\"", " ", $newsearch);


// NO RESULTS
if (!$newsearch) {
	$newsearch = "1";
}




// RETRIEVE POST VARS FROM SEARCH BOX
$styp = $_POST['s_type'];
$sval = $_POST['s_value'];
// RETRIEVE GET VARS FROM FLASH
$fval = $_GET['st'];


// SET UP DB QUERY FOR SHOP NAME SEARCH
if ($styp == "nam") {

	$showdistance = "OFF";

	$query = "SELECT * FROM shops 
				WHERE shop_name LIKE '%$sval%' 
				ORDER BY shop_name ASC";
				
	$result = mysql_query($query);

// SET UP QUERY FOR STATE SEARCH
} else if ($styp == "sta") {
	
	$showdistance = "OFF";

	// IF SEARCH PARAM LESS THAN THREE LETTERS - SEARCH STATE ABBREVIATION COLUMN state
	if (strlen($sval) < 3) {
		
		$query = "SELECT * FROM shops 
					WHERE state = '$sval' 
					ORDER BY shop_name ASC";
					
		$result = mysql_query($query);
		
		// IF NO RESULTS - TRY SEARCHING LONG STATE NAME COLUMN full_state
		if (mysql_num_rows($result == 0)) {
		
			$sval = strtolower($sval);
		
			$query = "SELECT * FROM shops 
						WHERE full_state LIKE '$sval%' 
						ORDER BY shop_name ASC";
						
			$result = mysql_query($query);
		
		}
		
	} else {
	
		// IF SEARCH PARAM LONGER THAN TWO CHARACTERS - SEARCH full_state
		$sval = strtolower($sval);
		
		$query = "SELECT * FROM shops 
					WHERE full_state LIKE '$sval%' 
					ORDER BY shop_name ASC";
						
		$result = mysql_query($query);
		
	}

// SET UP DB QUERY FOR ZIP CODE SEARCH	
} else if ($styp == "zip") {

	$showdistance = "ON";

	// REDUCE TO SEVEN DIGITS
	$sval = substr($sval, 0, 7);
	
	// GET LATITUDE + LONGITUDE OF ZIP CODE
	$latlon_query = "SELECT latitude, longitude FROM zip_codes
						 WHERE zip = '$sval' LIMIT 1";
							 
	$latlon_result = mysql_query($latlon_query) or print ("Can't select entries from table zip_codes.<br />" . $sql . "<br />" . mysql_error());
				
	// IF SUCCESS - GET ALL SHOP COORDINATES AND LOOP THROUGH FOR DISTANCES
	if (mysql_num_rows($latlon_result) == 1) {
				
		// SET PARAM COORDINATE VARS
		$latlon_row = mysql_fetch_array($latlon_result);
		$center_lat = $latlon_row['latitude'];
		$center_lng = $latlon_row['longitude'];
		$radius = 500;

		// Search the rows in the markers table
		$query = sprintf("SELECT shop_name, address1, city, state, zip, phone, shop_bio, shop_logo, shop_path, latitude, longitude, ( 3959 * acos( cos( radians('%s') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( latitude ) ) ) ) AS distance FROM shops HAVING distance < '%s' ORDER BY distance LIMIT 0 , 10",
			mysql_real_escape_string($center_lat),
			mysql_real_escape_string($center_lng),
			mysql_real_escape_string($center_lat),
			mysql_real_escape_string($radius));

		$result = mysql_query($query);
		
	}
		
} else if (isset($fval)) {

	$showdistance = "OFF";
	$fval = strtolower(trim($fval));
	
	$query = "SELECT * FROM shops 
				WHERE state = '$fval' 
				ORDER BY shop_name ASC";
						
	$result = mysql_query($query);



	


	
	

} else {

	$showdistance = "OFF";
	
	$query = "SELECT * FROM shops 
				ORDER BY shop_name ASC 
				LIMIT 0 , 50";
						
	$result = mysql_query($query);


}

while ($row = mysql_fetch_array($result)) {

	$shopname = stripslashes($row['shop_name']);
	$shopadd1 = stripslashes($row['address1']);
	$shopcity = stripslashes($row['city']);
	$shopstate = stripslashes($row['state']);
	$shopzip = stripslashes($row['zip']);
	$shopphone = stripslashes($row['phone']);
	$shoptext = stripslashes($row['shop_bio']);
	$shoplogo = stripslashes($row['shop_logo']);
	$shoppath = stripslashes($row['shop_path']);
	$shopdist = round($row['distance']);
	
	// ADD DOTS TO SHORT BIO IF IT IS NOT EMPTY
	if (strlen($shoptext) > 1) {
	
		$shoptext = $shoptext . "...";
	
	}
	
	// REPLACE 'THE' AT THE BEGINNING OF SHOPNAME
	$tempshop = strtolower($shopname);
		if (substr($tempshop, -5) == ", the") {
			$shopname = "The " . substr($shopname, 0, -5);
	}	
		
	echo "<div class=\"results\"> \n";
	echo "<hr /> \n";
	echo "<div class=\"srclogo\"><a href=\"" . $shopstate . "/" . $shoppath . "/\" target=\"_parent\"><img src=\"" . $shopstate . "/" . $shoppath . "/" . $shoplogo . "\" alt=\"" . $shopname . "\" /></a></div> \n";
	echo " \n";
	echo "<span class=\"resultstxt\">";
	
	// IF NOT ZIP CODE SEARCH DO NOT SHOW DISTANCE
	if ($showdistance == "ON") {
	
		echo "<strong>" . $shopdist . " miles</strong> <br /> \n";
		
	}
	
	echo "<span class=\"shopname\">" . $shopname . "</span> <br /> \n";
	echo $shopadd1 . ", " . $shopcity . ", " . $shopstate . ", " . $shopzip . " <br /> \n";
	echo $shopphone . " <br /> \n";
	echo $shoptext . " </span> <span class=\"moreinfo\"><a href=\"" .$shopstate . "/" . $shoppath . "/\" target=\"_parent\">more info</a></span> \n";
	echo "</div> \n";
	echo " \n";
	
}

?>

			<div class="pagenav"><hr /><a href="#">< Previous</a> | <a href="#">Next ></a></div>

			</div>

			<div id="srchbot">&nbsp;</div>		

		</div>



</body>

</html>

