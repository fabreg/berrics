<?php
if (!isset($_POST['shopName'])) {
	header ("Location: http://berricsunified.com/");
}


$snam = stripslashes($_POST['shopName']);
$scit = stripslashes($_POST['shopCity']);
$ssta = stripslashes($_POST['shopProv']);
$sweb = stripslashes($_POST['websiteURL']);
$scon = stripslashes($_POST['contactName']);
$sema = stripslashes($_POST['emailAddress']);
$spho = stripslashes($_POST['phoneNumber']);
$scom = stripslashes($_POST['comments']);

$rela = stripslashes($_POST['shopRela']);

if ($rela == "owner") {
	// FROM SHOP OWNER
	$subject = "CANADA UNIFIED INQUIRY FROM THE OWNER OF " . strtoupper($snam);	
} else if ($rela == "employee") {
	// FROM SHOP EMPLOYEE
	$subject = "CANADA UNIFIED INQUIRY FROM AN EMPLOYEE OF " . strtoupper($snam);
} else {
	// FROM SHOP LOCAL
	$subject = "CANADA UNIFIED INQUIRY FROM A " . strtoupper($snam) . " LOCAL";
}

$to = "unified@theberrics.com";


$message = "NEW INQUIRY FOR CANADA UNIFIED \r\n";
$message .= "== \r\n";
$message .= " \r\n";
$message .= "SHOP NAME: ".$snam." \r\n";
$message .= "CITY: ".$scit." \r\n";
$message .= "PROVINCE: ".$ssta." \r\n";
$message .= "WEBSITE: ".$sweb." \r\n";
$message .= "PHONE: ".$spho." \r\n";
$message .= " \r\n";
$message .= "CONTACT: ".$scon." -- SHOP ".strtoupper($rela)." \r\n";
$message .= "EMAIL: ".$sema." \r\n";
$message .= " \r\n";
$message .= "COMMENTS: ".$scom." \r\n";


$headers = "From: unified@theberrics.com \r\n";
$headers .= "Reply-To: ".$sema." \r\n";
$headers .= "X-Mailer: PHP/" . phpversion();


// MAKE SURE THERE IS CONTENT
if (isset($_POST['shopName'])) {
	mail($to, $subject, $message, $headers);
}


header ("Location: http://berricsunified.com/inquiry-ca.php?m=1");

?>





