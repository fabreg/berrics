<?php
if (isset($_GET['m'])) {
	
	switch ($_GET['m']) {
	
		case "1" :
			$message = "Thanks for your interest! Your email has been sent successfully, and we will be in touch with you as soon as we are able. <br />";
			break;
		
		default :
			$message = "We're sorry, an error occurred while sending your message. Please try again.";
			break;
	
	}

} else {

	$message = "If you are a Shop looking for more information about Berrics Unified, please use the form below to submit your info. ";
	$message .= "We will review your info and get back to you shortly. ";
	$message .= "Currently we are enrolling shops in the US and Canada. <br /><br />";
	$message .= "Rest of the world coming soon! <br /><br />";

}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>The Berrics - UNIFIED | INQUIRE</title>

		<meta http=equiv="Content-Type"	content="text/html; charset=iso-8859-1" />
		<script language="JavaScript" src="js/berrics.js"></script>
		<script language="JavaScript" src="js/validator.js"></script>
		<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>
		<link href="unified.css" rel="stylesheet" type="text/css">
		

	</head>

	<body>
		
	<!-- NAVIGATION -->
	
		<div id="nav">
		<ul>
			<li><img src="../../img/new_nav_01.gif" border="0" height="11" width="190"></li>
			<li><a href="http://www.theberrics.com/dailyopsunified.php?s=IA&n=subsect" onmouseover="MM_swapImage('dop','','http://s265767729.onlinehome.us/../../img/new_nav_03_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="../../img/new_nav_03.gif" name="dop" id="dop" border="0" height="20" width="190"></a></li>
			<li><a href="http://www.theberrics.com/unitdirective.php" onmouseover="MM_swapImage('udi','','http://s265767729.onlinehome.us/../../img/new_nav_04_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="../../img/new_nav_04.gif" name="udi" id="udi" border="0" height="17" width="190"></a></li>
			<li><a href="http://www.theberrics.com/battlecommander.php" onmouseover="MM_swapImage('bat','','http://s265767729.onlinehome.us/../../img/new_nav_05_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="../../img/new_nav_05.gif" name="bat" id="bat" border="0" height="16" width="190"></a></li>
			<li><a href="http://www.theberrics.com/recruits.php" onmouseover="MM_swapImage('rec','','http://s265767729.onlinehome.us/../../img/new_nav_06_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="../../img/new_nav_06.gif" name="rec" id="rec" border="0" height="20" width="190"></a></li>
			<li><a href="http://www.theberrics.com/unitednations.php" onmouseover="MM_swapImage('una','','http://s265767729.onlinehome.us/../../img/new_nav_07_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="../../img/new_nav_07.gif" name="una" id="una" border="0" height="18" width="190"></a></li>
			<li><a href="http://www.theberrics.com/clinicalresearch.php" onmouseover="MM_swapImage('cli','','http://s265767729.onlinehome.us/../../img/new_nav_08_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="../../img/new_nav_08.gif" name="cli" id="cli" border="0" height="19" width="190"></a></li>
			<li><a href="http://www.theberrics.com/canteen.php" onmouseover="MM_swapImage('can','','http://s265767729.onlinehome.us/../../img/new_nav_09_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="../../img/new_nav_09.gif" name="can" id="can" border="0" height="18" width="190"></a></li>
			<li><a href="http://www.theberrics.com/department8.php" onmouseover="MM_swapImage('dep','','http://s265767729.onlinehome.us/../../img/new_nav_10_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="../../img/new_nav_10.gif" name="dep" id="dep" border="0" height="19" width="190"></a></li>
			<li><a href="http://www.theberrics.com/headquarters.php" onmouseover="MM_swapImage('hea','','http://s265767729.onlinehome.us/../../img/new_nav_11_over.gif',1)" onmouseout="MM_swapImgRestore()"><img src="../../img/new_nav_11.gif" name="hea" id="hea" border="0" height="24" width="190"></a></li>
			<li><img src="../../img/new_nav_12.gif" border="0" height="39" width="190"></li>
		</ul>
		</div>
		
		<!-- HEADER -->
		
		<div id="header">
			<img src="../../img/unified-logo.png" />
		</div>
		
		<!-- LEFT TEXT LINKS -->
		
		<div id="leftside">
			<a href="index.html"><img src="img/lefshort_backtomap.jpg" width="110" border="0" alt="BACK TO MAP" /></a> <br />
		</div>
		
		<!-- MAIN CONTENT -->
		
		<div id="formtop"><h3></h3></div>
		<div id="formmid">
			
	
				<form action="handle_inquire.php" name="inquireForm" method="POST"> 
				<table class="confirmBody" cellpadding="2" cellspacing="2">
					<tr>
						<td colspan="2"><div id='inquireForm_errorloc' class='error_strings'></div></td>
					</tr>
					<tr>
						<td colspan="2"><img src="img/inquire.jpg"></div></td>
					</tr>
					<tr>
						<td class="notes" colspan="2">
							<?php echo $message; ?>
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">Shop Name:</td>
						<td class="confirminput">
						  <input type="text" size="25" name="shopName" title="shopName">
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">State / Province:</td>
						<td class="confirminput">
						  <select name="state" title="state">
						    <option selected></option>
						    <optgroup label="CANADA">
								<option value="AB">AB</option>
								<option value="BC">BC</option>
								<option value="MB">MB</option>
								<option value="NB">NB</option>
								<option value="NL">NL</option>
								<option value="NS">NS</option>
								<option value="NT">NT</option>
								<option value="NU">NU</option>
								<option value="ON">ON</option>
								<option value="PE">PE</option>
								<option value="QC">QC</option>
								<option value="SK">SK</option>
								<option value="YT">YT</option>
							 </optgroup>
							 <option></option>
						    <optgroup label="US">
								 <option value="AL">AL</option>
								 <option value="AK">AK</option>
								 <option value="AZ">AZ</option>
								 <option value="AR">AR</option>
								 <option value="CA">CA</option>
								 <option value="CO">CO</option>
								 <option value="CT">CT</option>
								 <option value="DE">DE</option>
								 <option value="FL">FL</option>
								 <option value="GA">GA</option>
								 <option value="HI">HI</option>
								 <option value="ID">ID</option>
								 <option value="IL">IL</option>
								 <option value="IN">IN</option>
								 <option value="IA">IA</option>
								 <option value="KS">KS</option>
								 <option value="KY">KY</option>
								 <option value="LA">LA</option>
								 <option value="ME">ME</option>
								 <option value="MD">MD</option>
								 <option value="MA">MA</option>
								 <option value="MI">MI</option>
								 <option value="MN">MN</option>
								 <option value="MS">MS</option>
								 <option value="MO">MO</option>
								 <option value="MT">MT</option>
								 <option value="NE">NE</option>
								 <option value="NV">NV</option>
								 <option value="NH">NH</option>
								 <option value="NJ">NJ</option>
								 <option value="NM">NM</option>
								 <option value="NY">NY</option>
								 <option value="NC">NC</option>
								 <option value="ND">ND</option>
								 <option value="OH">OH</option>
								 <option value="OK">OK</option>
								 <option value="OR">OR</option>
								 <option value="PA">PA</option>
								 <option value="RI">RI</option>
								 <option value="SC">SC</option>
								 <option value="SD">SD</option>
								 <option value="TN">TN</option>
								 <option value="TX">TX</option>
								 <option value="UT">UT</option>
								 <option value="VT">VT</option>
								 <option value="VA">VA</option>
								 <option value="WA">WA</option>
								 <option value="WV">WV</option>
								 <option value="WI">WI</option>
								 <option value="WY">WY</option>
								 <option></option>
						    </optgroup>
						  </select>
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">Website URL:</td>
						<td class="confirminput">
						  <input type="text" size="25" name="websiteURL" title="websiteURL">
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">Contact Name:</td>
						<td class="confirminput">
						  <input type="text" size="25" name="contactName" title="contactName">
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">Email Address:</td>
						<td class="confirminput">
						  <input type="text" size="25" name="emailAddress" title="emailAddress">
						</td>
					</tr>
					<tr>
						<td align="right" width="234px">Phone Number:</td>
						<td class="confirminput">
						  <input type="text" size="25" name="phoneNumber" title="phoneNumber">
						</td>
					</tr>
					<tr>
						<td align="right" valign="top" width="234px">Comments:</td>
						<td class="confirminput">
						  <textarea name="comments" title="comments" rows="8" width="25" cols="35"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><br />
							<input type="submit" name"submitbutton" value="Submit info" ><br /><br />
						</td>
					</tr>
				</table>
				</form>
				<script language="JavaScript" type="text/javascript">
 				var frmvalidator = new Validator("inquireForm");

				frmvalidator.EnableOnPageErrorDisplaySingleBox();
				frmvalidator.EnableMsgsTogether();
 				frmvalidator.addValidation("contactName","req","Please enter a Contact Name");
 
 				frmvalidator.addValidation("shopName","req","Please enter your Shop Name");
 
 				frmvalidator.addValidation("emailAddress","req","Please enter your Email Address");
 				frmvalidator.addValidation("emailAddress","email","Enter a valid Email Address");
 
 				frmvalidator.addValidation("state","dontselect=0","Please Select a State");
				frmvalidator.addValidation("state","req","Please enter your State");
				</script>
		</div>
		</div>
		

		<div id="formbotm">&nbsp;</div>	
		
	</body>

</html>


