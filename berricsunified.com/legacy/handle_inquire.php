<?php
if (!isset($_POST['shopName'])) {
	header ("Location: http://berricsunified.com/");
}

$snam = stripslashes($_POST['shopName']);
$ssta = stripslashes($_POST['state']);
$sweb = stripslashes($_POST['websiteURL']);
$scon = stripslashes($_POST['contactName']);
$sema = stripslashes($_POST['emailAddress']);
$spho = stripslashes($_POST['phoneNumber']);
$scom = stripslashes($_POST['comments']);

/* KILL REPS
switch ($ssta) {
	case "AL" :
		$rep = "phillipkeenerfreeride@yahoo.com";
		break;
	case "AK" :
		$rep = "patrickkeener@theberrics.com";
		break;
	case "AZ" :
		$rep = "patrickkeener@theberrics.com";
		break;
	case "AR" :
		$rep = "phillipkeenerfreeride@yahoo.com";
		break;
	case "CA" :
		$rep = "oliver54@me.com, stevedenham@msn.com, dontclare@me.com";
		break;
	case "CO" :
		$rep = "wiseandy@gmail.com";
		break;
	case "CT" :
		$rep = "patrickmalley@hotmail.com";
		break;
	case "DE" :
		$rep = "zachsheats@gmail.com";
		break;
	case "FL" :
		$rep = "twomble@earthlink.net";
		break;
	case "GA" :
		$rep = "twomble@earthlink.net";
		break;
	case "HI" :
		$rep = "joeyvieira@gmail.com";
		break;
	case "ID" :
		$rep = "patrickfreeride@yahoo.com";
		break;
	case "IL" :
		$rep = "m_globke@hotmail.com";
		break;
	case "IN" :
		$rep = "m_globke@hotmail.com";
		break;
	case "IA" :
		$rep = "patrickkeener@theberrics.com";
		break;
	case "KS" :
		$rep = "phillipkeenerfreeride@yahoo.com";
		break;
	case "KY" :
		$rep = "m_globke@hotmail.com";
		break;
	case "LA" :
		$rep = "phillipkeenerfreeride@yahoo.com";
		break;
	case "ME" :
		$rep = "patrickmalley@hotmail.com";
		break;
	case "MD" :
		$rep = "zachsheats@gmail.com";
		break;
	case "MA" :
		$rep = "patrickmalley@hotmail.com";
		break;
	case "MI" :
		$rep = "m_globke@hotmail.com";
		break;
	case "MN" :
		$rep = "m_globke@hotmail.com";
		break;
	case "MS" :
		$rep = "phillipkeenerfreeride@yahoo.com";
		break;
	case "MO" :
		$rep = "phillipkeenerfreeride@yahoo.com";
		break;
	case "MT" :
		$rep = "wiseandy@gmail.com";
		break;
	case "NE" :
		$rep = "patrickkeener@theberrics.com";
		break;
	case "NV" :
		$rep = "patrickkeener@theberrics.com";
		break;
	case "NH" :
		$rep = "patrickmalley@hotmail.com";
		break;
	case "NJ" :
		$rep = "patrickkeener@theberrics.com";
		break;
	case "NM" :
		$rep = "wiseandy@gmail.com";
		break;
	case "NY" :
		$rep = "patrickmalley@hotmail.com";
		break;
	case "NC" :
		$rep = "twomble@earthlink.net";
		break;
	case "ND" :
		$rep = "patrickkeener@theberrics.com";
		break;
	case "OH" :
		$rep = "m_globke@hotmail.com";
		break;
	case "OK" :
		$rep = "phillipkeenerfreeride@yahoo.com";
		break;
	case "OR" :
		$rep = "patrickfreeride@yahoo.com";
		break;
	case "PA" :
		$rep = "zachsheats@gmail.com";
		break;
	case "RI" :
		$rep = "patrickmalley@hotmail.com";
		break;
	case "SC" :
		$rep = "twomble@earthlink.net";
		break;
	case "SD" :
		$rep = "patrickkeener@theberrics.com";
		break;
	case "TN" :
		$rep = "phillipkeenerfreeride@yahoo.com";
		break;
	case "TX" :
		$rep = "phillipkeenerfreeride@yahoo.com";
		break;
	case "UT" :
		$rep = "wiseandy@gmail.com";
		break;
	case "VT" :
		$rep = "patrickmalley@hotmail.com";
		break;
	case "VI" :
		$rep = "twomble@earthlink.net";
		break;
	case "WA" :
		$rep = "patrickfreeride@yahoo.com";
		break;
	case "WV" :
		$rep = "twomble@earthlink.net";
		break;
	case "WI" :
		$rep = "m_globke@hotmail.com";
		break;
	case "WY" :
		$rep = "wiseandy@gmail.com";
		break;
	default :
		$rep = "patrickkeener@theberrics.com";
}

if ($rep == "patrickkeener@theberrics.com") {
	$ccadds = "ryan@theberrics.com, danny@theberrics.com, steveberra@theberrics.com, inquiry@berricsunified.com";
} else {
	$ccadds = "ryan@theberrics.com, danny@theberrics.com, steveberra@theberrics.com inquiry@berricsunified.com";
}

*/

$to = "unified@theberrics.com";
$subject = "BERRICS UNIFIED INQUIRY FROM " . strtoupper($snam);

$message = "NEW INQUIRY FOR BERRICS UNIFIED \r\n";
$message .= "== \r\n";
$message .= " \r\n";
$message .= "SHOP NAME: ".$snam." \r\n";
$message .= "STATE: ".$ssta." \r\n";
$message .= "WEBSITE: ".$sweb." \r\n";
$message .= " \r\n";
$message .= "CONTACT: ".$scon." \r\n";
$message .= "EMAIL: ".$sema." \r\n";
$message .= "PHONE: ".$spho." \r\n";
$message .= " \r\n";
$message .= "COMMENTS: ".$scom." \r\n";

$headers = "From: unified@theberrics.com \r\n";
$headers .= "Reply-To: ".$sema." \r\n";
// $headers .= "Cc: ".$ccadds." \r\n";

// MAKE SURE THERE IS CONTENT
if (isset($_POST['shopName'])) {
	mail($to, $subject, $message, $headers);
}

header ("Location: http://berricsunified.com/inquiry.php?m=1");

?>





