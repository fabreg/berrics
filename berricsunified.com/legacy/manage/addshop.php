<?php
include '../badmin/searchcon.php';

$shopname = $_POST['shopname'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$country = $_POST['country'];
$phone = $_POST['phone'];
$shopbio = $_POST['shopbio'];
$shoplogo = $_POST['shoplogo'];
$shoppath = $_POST['shoppath'];

switch ($state) {
	case "AL" :
		$longstate = "alabama";
		break;
	case "AK" :
		$longstate = "alaska";
		break;
	case "AZ" :
		$longstate = "arizona";
		break;
	case "AR" :
		$longstate = "arkansas";
		break;
	case "CA" :
		$longstate = "california";
		break;
	case "CO" :
		$longstate = "colorado";
		break;
	case "CT" :
		$longstate = "connecticut";
		break;
	case "DC" :
		$longstate = "district of columbia";
		break;
	case "DE" :
		$longstate = "delaware";
		break;
	case "FL" :
		$longstate = "florida";
		break;
	case "GA" :
		$longstate = "georgia";
		break;
	case "HI" :
		$longstate = "hawaii";
		break;
	case "ID" :
		$longstate = "idaho";
		break;
	case "IL" :
		$longstate = "illinois";
		break;
	case "IN" :
		$longstate = "indiana";
		break;
	case "IA" :
		$longstate = "iowa";
		break;
	case "KS" :
		$longstate = "kansas";
		break;
	case "KY" :
		$longstate = "kentucky";
		break;
	case "LA" :
		$longstate = "louisiana";
		break;
	case "ME" :
		$longstate = "maine";
		break;
	case "MD" :
		$longstate = "maryland";
		break;
	case "MA" :
		$longstate = "massachusetts";
		break;
	case "MI" :
		$longstate = "michigan";
		break;
	case "MN" :
		$longstate = "minnesota";
		break;
	case "MS" :
		$longstate = "mississippi";
		break;
	case "MO" :
		$longstate = "missouri";
		break;
	case "MT" :
		$longstate = "montana";
		break;
	case "NE" :
		$longstate = "nebraska";
		break;
	case "NV" :
		$longstate = "nevada";
		break;
	case "NH" :
		$longstate = "new hampshire";
		break;
	case "NJ" :
		$longstate = "new jersey";
		break;
	case "NM" :
		$longstate = "new mexico";
		break;
	case "NY" :
		$longstate = "new york";
		break;
	case "NC" :
		$longstate = "north carolina";
		break;
	case "ND" :
		$longstate = "north dakota";
		break;
	case "OH" :
		$longstate = "ohio";
		break;
	case "OK" :
		$longstate = "oklahoma";
		break;
	case "OR" :
		$longstate = "oregon";
		break;
	case "PA" :
		$longstate = "pennsylvania";
		break;
	case "RI" :
		$longstate = "rhode island";
		break;
	case "SC" :
		$longstate = "south carolina";
		break;
	case "SD" :
		$longstate = "south dakota";
		break;
	case "TN" :
		$longstate = "tennessee";
		break;
	case "TX" :
		$longstate = "texas";
		break;
	case "UT" :
		$longstate = "utah";
		break;
	case "VT" :
		$longstate = "vermont";
		break;
	case "VA" :
		$longstate = "virginia";
		break;
	case "WA" :
		$longstate = "washington";
		break;
	case "WV" :
		$longstate = "west virginia";
		break;
	case "WI" :
		$longstate = "wisconsin";
		break;
	case "WY" :
		$longstate = "wyoming";
		break;
	case "AB" :
		$longstate = "alberta";
		break;
	case "BC" :
		$longstate = "british columbia";
		break;
	case "MB" :
		$longstate = "manitoba";
		break;
	case "NB" :
		$longstate = "new brunswick";
		break;
	case "NL" :
		$longstate = "newfoundland and labrador";
		break;
	case "NS" :
		$longstate = "nova scotia";
		break;
	case "NT" :
		$longstate = "northwest territories";
		break;
	case "NU" :
		$longstate = "nunavut";
		break;
	case "ON" :
		$longstate = "ontario";
		break;
	case "PE" :
		$longstate = "prince edward island";
		break;
	case "QC" :
		$longstate = "quebec";
		break;
	case "SK" :
		$longstate = "saskatchewan";
		break;
	case "YT" :
		$longstate = "yukon territory";
		break;
	default :
		$longstate = "unknown";
		break;
}

// CHOOSE DB FOR COUNTRY

// GET LATITUDE + LONGITUDE OF ZIP CODE
$findzip_sql = "SELECT latitude, longitude 
					FROM zip_codes WHERE zip = '$zip' LIMIT 1";
$findzip_res = mysql_query($findzip_sql) or print ("ZIP = ".$zip." -- ERROR FINDING ZIP CODE:" . mysql_error());

while ($ziprow = mysql_fetch_array($findzip_res)) {
	$shoplat = $ziprow['latitude'];
	$shoplon = $ziprow['longitude'];
}

// REMOVE 'THE' FROM SHOP NAMES FOR ALPHABETIZING
$tempshop = strtolower($shopname);
if (substr($tempshop, 0, 4) == "the ") {
	$shopname = substr($shopname, 4);
	$shopname .= ", The";
}

$newshop_sql = "INSERT INTO shops 
				VALUES (NULL, '$shopname', '$address1', '$address2', '$city', '$state', '$longstate', '$zip', 
				'$country', '$phone', '$shopbio', '$shoplogo', '$shoppath', $shoplat, $shoplon);";
$newshop_res = mysql_query($newshop_sql) or print ("LONGITUDE". $shoplon ." - ERROR ENTERING SHOP TO DB:" . mysql_error());

header("Location: index.php");


?>

