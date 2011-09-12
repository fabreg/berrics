<?php
// PLAN VARIABLE
if (!isset($_POST['plan'])) {
	print "THERE WAS AN ERROR";
} else {
	$p = $_POST['plan'];
}

// DATE STUFF
$today = date("m.d.y");

// HANDLE PLAN CONVERSION
switch ($p) {
	case "1":
		$plan = "BASIC";
		$amt = 50;
		$length = 12;
		$payments = 12;
		$monban = "NA";
		$bonban = "NA";
		break;
	case "2":
		$plan = "CITY";
		$amt = 150;
		$length = 12;
		$payments = 12;
		$monban = "20,000";
		$bonban = "NA";
		break;
	case "4":
		$plan = "CITY";
		$amt = 1440;
		$length = 12;
		$payments = 1;
		$monban = "20,000";
		$bonban = "175,000";
		break;
	case "5":
		$plan = "STATE";
		$amt = 250;
		$length = 12;
		$payments = 12;
		$monban = "35,000";
		$bonban = "NA";
		break;
	case "7":
		$plan = "STATE";
		$amt = 2400;
		$length = 12;
		$payments = 1;
		$monban = "35,000";
		$bonban = "185,000";
		break;
	case "8":
		$plan = "DISTRICT";
		$amt = 350;
		$length = 12;
		$payments = 12;
		$monban = "60,000";
		$bonban = "NA";
		break;
	case "10":
		$plan = "DISTRICT";
		$amt = 3360;
		$length = 12;
		$payments = 1;
		$monban = "60,000";
		$bonban = "200,000";
		break;
	case "11":
		$plan = "REGION";
		$amt = 450;
		$length = 12;
		$payments = 12;
		$monban = "85,000";
		$bonban = "NA";
		break;
	case "13":
		$plan = "REGION";
		$amt = 4320;
		$length = 12;
		$payments = 1;
		$monban = "85,000";
		$bonban = "250,000";
		break;
	case "14":
		$plan = "2 REGION";
		$amt = 550;
		$length = 12;
		$payments = 12;
		$monban = "110,000";
		$bonban = "NA";
		break;
	case "16":
		$plan = "2 REGION";
		$amt = 5280;
		$length = 12;
		$payments = 1;
		$monban = "110,000";
		$bonban = "300,000";
		break;
	default :
		$plan = "ERROR";
		$amt = "$0";
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>The Berrics - UNIFIED</title>

		<meta http=equiv="Content-Type"	content="text/html; charset=iso-8859-1" />
		<script language="JavaScript" src="js/berrics.js"></script>
		<script language="JavaScript" src="js/swfobject.js"></script>
		<script language="JavaScript" src="js/frameheight.js"></script>
		<script language="JavaScript" src="js/validator.js"></script>
		<link href="unified.css" rel="stylesheet" type="text/css">
		

	</head>

	<body>
		
	<!-- NAVIGATION -->
	
		<div id="nav">
		<ul>
			<li><img src="img/new_nav_01.gif" border="0" height="11" width="190"></li>
			<li><a href="http://www.theberrics.com/dailyops.php" onmouseover="MM_swapImage('dop','','http://s265767729.onlinehome.us/img/new_nav_03_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/new_nav_03.gif" name="dop" id="dop" border="0" height="20" width="190"></a></li>
			<li><a href="http://www.theberrics.com/unitdirective.php" onmouseover="MM_swapImage('udi','','http://s265767729.onlinehome.us/img/new_nav_04_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/new_nav_04.gif" name="udi" id="udi" border="0" height="17" width="190"></a></li>
			<li><a href="http://www.theberrics.com/battlecommander.php" onmouseover="MM_swapImage('bat','','http://s265767729.onlinehome.us/img/new_nav_05_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/new_nav_05.gif" name="bat" id="bat" border="0" height="16" width="190"></a></li>
			<li><a href="http://www.theberrics.com/recruits.php" onmouseover="MM_swapImage('rec','','http://s265767729.onlinehome.us/img/new_nav_06_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/new_nav_06.gif" name="rec" id="rec" border="0" height="20" width="190"></a></li>
			<li><a href="http://www.theberrics.com/unitednations.php" onmouseover="MM_swapImage('una','','http://s265767729.onlinehome.us/img/new_nav_07_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/new_nav_07.gif" name="una" id="una" border="0" height="18" width="190"></a></li>
			<li><a href="http://www.theberrics.com/clinicalresearch.php" onmouseover="MM_swapImage('cli','','http://s265767729.onlinehome.us/img/new_nav_08_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/new_nav_08.gif" name="cli" id="cli" border="0" height="19" width="190"></a></li>
			<li><a href="http://www.theberrics.com/canteen.php" onmouseover="MM_swapImage('can','','http://s265767729.onlinehome.us/img/new_nav_09_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/new_nav_09.gif" name="can" id="can" border="0" height="18" width="190"></a></li>
			<li><a href="http://www.theberrics.com/department8.php" onmouseover="MM_swapImage('dep','','http://s265767729.onlinehome.us/img/new_nav_10_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/new_nav_10.gif" name="dep" id="dep" border="0" height="19" width="190"></a></li>
			<li><a href="http://www.theberrics.com/headquarters.php" onmouseover="MM_swapImage('hea','','http://s265767729.onlinehome.us/img/new_nav_11_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/new_nav_11.gif" name="hea" id="hea" border="0" height="24" width="190"></a></li>
			<li><img src="img/new_nav_12.gif" border="0" height="39" width="190"></li>
		</ul>
		</div>
		
		<!-- HEADER -->
		
		<div id="header">
			<img src="img/unified-logo.png" />
		</div>
		
		
		<!-- Begin Form -->
		
		<!-- BEGIN Order Confirm -->
			
				
		<div id="formtop">&nbsp;</div>
		<div id="formmid">
			
	
				<form action="https://www.usaepay.com/interface/epayform/" name="billingform">
				
				<?php
				
				// HANDLE UMS PAYMENT HIDDEN VALUES
				print "					<input type=\"hidden\" name=\"UMkey\" value=\"3Rb9MaMvv26NJ46H2QTWs3ul72VR69w3\" /> \n";
				print "					<input type=\"hidden\" name=\"UMcommand\" value=\"sale\" /> \n";
				print "					<input type=\"hidden\" name=\"UMaddcustomer\" value=\"yes\" /> \n";
				print "					<input type=\"hidden\" name=\"UMcustreceipt\" value=\"yes\" /> \n";
				print "					<input type=\"hidden\" name=\"UMinvoice\" value=\"" . time() . "\" /> \n";
				print "					<input type=\"hidden\" name=\"UMamount\" value=\"" . $amt . ".00\" /> \n";
				
				// FOR RECURRING PAYMENT PLANS
				if ($payments > 1) {
					print "					<input type=\"hidden\" name=\"UMrecurring\" value=\"yes\" /> \n";
					print "					<input type=\"hidden\" name=\"UMbillamount\" value=\"" . $amt . ".00\" /> \n";
					print "					<input type=\"hidden\" name=\"UMschedule\" value=\"monthly\" /> \n";
					print "					<input type=\"hidden\" name=\"UMnumleft\" value=\"" . ($payments - 1) . "\" /> \n";
					print "					<input type=\"hidden\" name=\"UMstart\" value=\"next\" /> \n";
				} else {
					// PREVENTS RECURRING CHARGES MAYBE
					print "					<input type=\"hidden\" name=\"UMrecurring\" value=\"no\" /> \n";
					print "					<input type=\"hidden\" name=\"UMschedule\" value=\"annually\" /> \n";
					print "					<input type=\"hidden\" name=\"UMnumleft\" value=\"0\" /> \n";					
				}
					
				
				// PLAN INFO FOR OUR RECORDS
				print "					<input type=\"hidden\" name=\"UMcustom1\" value=\"" . $plan . "\" /> \n";
				print "					<input type=\"hidden\" name=\"UMcustom2\" value=\"" . $length . "\" /> \n";
				print "					<input type=\"hidden\" name=\"UMcustom3\" value=\"" . $payments . "\" /> \n";
				print "					<input type=\"hidden\" name=\"UMdescription\" value=\"" . $plan . "\" /> \n";
				
				?>

				<table class="confirmBody" cellpadding="2" cellspacing="2">
					<tr>
						<td colspan="2"><div id='billingform_errorloc' class='error_strings'></div></td>
					</tr>
					<tr>
						<td colspan="2"><img src="img/confirm.gif"></div></td>
					</tr>
					<tr>
						<td align ="left" colspan="2" class="headliners">ORDER SUMMARY:</td>
					</tr>
					<tr>
						<td align="right" width="234px">Order Date:</td>
						<td class="summarytxt">
						<?php
						
							print $today;
							
						?>
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">Plan Selected:</td>
						<td class="summarytxt">
						<?php
						
							print $plan;
						
						?>
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">Plan Length:</td>
						<td class="summarytxt">
						<?php
						
							print $length." MONTHS";
													
						?>
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">Amount:</td>
						<td class="summarytxt">
						<?php
						
							print "$".$amt;
						
						?>
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">Payments:</td>
						<td class="summarytxt">
						<?php
						
							print $payments;
						
						?>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top" width="234px">Monthly Banner Impressions:</td>
						<td class="summarytxt">
						<?php
						
							print $monban;
						
						?>
						</td>
					</tr>
					<tr>
						<td align="right" valign="top" width="234px">Annual Bonus Impressions:</td>
						<td class="summarytxt">
						<?php
						
							print $bonban;
						
						?>
						</td>
					</tr>
					<tr>
						<td align ="left" colspan="2" class="headliners">SHOP INFORMATION:</td>
					</tr>
					<tr>
						<td align="right" width="234px">Shop Name:</td><td class="confirminput"><input type="text" size="25" name="ShopName"></td>
					</tr>
					<tr>
						<td align="right" width="234px">Rep Name:</td><td class="confirminput"><input type="text" size="20" name="RepName"></td>
					</tr>
					<tr>
						<td><br /></tr>
					</tr>
					<tr>
						<td align ="left" colspan="2" class="headliners">CUSTOMER INFORMATION:</td>
					</tr>
					<tr>
						<td align="right" width="234px">Company Name:</td><td class="confirminput"><input type="text" size="25" name="UMbillcompany"></td>
					</tr>
					<tr>
						<td align="right" width="234px">First Name:</td><td class="confirminput"><input type="text" size="20" name="UMbillfname"></td>
					</tr>
					<tr>
						<td align="right" width="234px">Last Name:</td><td class="confirminput"><input type="text" size="20" name="UMbilllname"></td>
					</tr>
					<tr>
						<td align="right" width="234px">Address:</td><td class="confirminput"><input type="text" size="25" name="UMbillstreet"></td>
					</tr>
					<tr>
						<td align="right" width="234px">Address Line 2:</td class="confirminput"><td class="confirminput"><input type="text" size="25" name="UMbillstreet2"></td>
					</tr>
					<tr>
						<td align="right" width="234px">City:</td><td class="confirminput"><input type="text" size="25" name="UMbillcity"></td>
					</tr>
					<tr>
						<td align="right" width="234px">State:</td><td class="confirminput"><select name="UMbillstate"><option value="" selected>--<option value="AL">AL<option value="AK">AK<option value="AZ">AZ<option value="AR">AR<option value="CA">CA<option value="CO">CO<option value="CT">CT<option value="DE">DE<option value="FL">FL<option value="GA">GA<option value="HI">HI<option value="ID">ID<option value="IL">IL<option value="IN">IN<option value="IA">IA<option value="KS">KS<option value="KY">KY<option value="LA">LA<option value="ME">ME<option value="MD">MD<option value="MA">MA<option value="MI">MI<option value="MN">MN<option value="MS">MS<option value="MO">MO<option value="MT">MT<option value="NE">NE<option value="NV">NV<option value="NH">NH<option value="NJ">NJ<option value="NM">NM<option value="NY">NY<option value="NC">NC<option value="ND">ND<option value="OH">OH<option value="OK">OK<option value="OR">OR<option value="PA">PA<option value="RI">RI<option value="SC">SC<option value="SD">SD<option value="TN">TN<option value="TX">TX<option value="UT">UT<option value="VT">VT<option value="VA">VA<option value="WA">WA<option value="WV">WV<option value="WI">WI<option value="WY">WY</td>
					</tr>
					<tr>
						<td align="right" width="234px">Zip:</td><td class="confirminput"><input type="text" size="10" name="UMbillzip"></td>
					</tr>
					<tr>
						<td align="right" width="234px">Phone Number:</td><td class="confirminput"><input type="text" size="15" name="UMbillphone"></td>
					</tr>
					<tr>
						<td align="right" width="234px">Email Address:</td><td class="confirminput"><input type="text" size="25" name="UMemail"></td>
					</tr>
					<tr>
						<td align="right" width="234px">Confirm Email:</td><td class="confirminput"><input type="text" size="25" name="UMcustemail"></td>
					</tr>
					<!-- <tr>
						<td colspan="2" align="center"><input type="checkbox" name="terms"> I agree to the <a href="" target="_blank">Terms and Conditions</a></td>
					</tr> -->
					<tr>
						<td colspan="2" align="center"><br /><input type="submit" name"submitbutton" value="Continue to Payment Form" ><br /><br /></td>
					</tr>
				</table>
				</form>
				<script language="JavaScript" type="text/javascript">
 				var frmvalidator = new Validator("billingform");

				frmvalidator.EnableOnPageErrorDisplaySingleBox();
				frmvalidator.EnableMsgsTogether();
 				frmvalidator.addValidation("UMbillfname","req","Please enter your First Name");
 				frmvalidator.addValidation("UMbillfname","maxlen=20","Max length for First Name is 20 Characters");
 				frmvalidator.addValidation("UMbillfname","alpha");
 
 				frmvalidator.addValidation("UMbilllname","req","Please enter your Last Name");
 				frmvalidator.addValidation("UMbilllname","maxlen=20");
				
				frmvalidator.addValidation("ShopName","req","Please enter your Shop Name");
				
			//	frmvalidator.addValidation("terms","shouldselchk=on", "Please read and accept the Terms and Agreements");
				
				frmvalidator.addValidation("RepName","req","Please enter your Rep Name");

				frmvalidator.addValidation("UMbillcity","req","Please enter your City");
 				frmvalidator.addValidation("UMbillcity","maxlen=20");

				frmvalidator.addValidation("UMbillzip","req","Please enter your Zip Code");
 				frmvalidator.addValidation("UMbillzip","maxlen=20");
 
 				frmvalidator.addValidation("UMemail","maxlen=50");
 				frmvalidator.addValidation("UMemail","req","Please enter your Email Address");
 				frmvalidator.addValidation("UMemail","email","Enter a valid Email Address");
 				
 				frmvalidator.addValidation("UMcustemail","maxlen=50");
 				frmvalidator.addValidation("UMcustemail","req","Please confirm your Email Address");
 				frmvalidator.addValidation("UMcustemail","email","Enter a valid Email Address");
 	
 				frmvalidator.addValidation("UMbillphone","maxlen=50");
				frmvalidator.addValidation("UMbillphone","req","Please enter your Phone Number");
 
 				frmvalidator.addValidation("UMbillstreet","maxlen=50");
				frmvalidator.addValidation("UMbillstreet","req","Please enter your Address");
 				frmvalidator.addValidation("UMbillstate","dontselect=0","Please Select a State");
				frmvalidator.addValidation("UMbillstate","req","Please enter your State");
				
				</script>
		</div>
		</div>
		

		<div id="formbotm">&nbsp;</div>	




		

		
	</body>

</html>


