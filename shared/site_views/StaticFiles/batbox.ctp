<?php 

$Dailyop = ClassRegistry::init("Dailyop");

$post = $Dailyop->returnPost(array("Dailyop.id"=>6967),1);

$this->set("title_for_layout","BATBOX");

?>
<style>
@font-face {
    font-family: 'gotham';
    src: url('/img/v3/batbox/GothamHTF-Book.eot?') format('eot'),
         url('/img/v3/batbox/GothamHTF-Book.woff') format('woff'),
         url('/img/v3/batbox/GothamHTF-Book.ttf') format('truetype'),
         url('/img/v3/batbox/GothamHTF-Book.svg') format('svg');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'gothamb';
    src: url('/img/v3/batbox/GothamHTF-Black.eot?') format('eot'),
         url('/img/v3/batbox/GothamHTF-Black.woff') format('woff'),
         url('/img/v3/batbox/GothamHTF-Black.ttf') format('truetype'),
         url('/img/v3/batbox/GothamHTF-Black.svg') format('svg');
    font-weight: normal;
    font-style: normal;
}

#batbox .heading {

	font-family: 'gothamb';
	text-align: center;
	border:1px solid #000;

	border-left:none;
	border-right:none;


}

#batbox strong {

	font-family: 'gothamb';

}

#batbox .promo-text,
#batbox .tickets,
#batbox .retailers {

	font-family: 'gotham';

}

#batbox .promo-text {

	text-align: center;
	padding:5px;
}

#batbox .tickets {

	padding-top:5px;
	padding-bottom:5px;

}

#batbox .tickets .ticket {

	float:left;
	margin-bottom:2px;

}
#batbox .tickets .ticket:nth-child(even) {

	float:right;

}

#post {

border-top:1px solid #000;

}

#post .post {

	border:none;

}

#post .post .text-content {

	display:none;

}

</style>
<div id="batbox">
	<?php echo $this->element("banners/728"); ?>
	<div class="">
		<img src="/img/v3/batbox/heading.jpg" alt="">
	</div>	
	<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class="heading">
			BATBOX MEMORIAL PACK CONTENTS
	</div>
	<div class="promo-text">
		DC Teak shoes in a limited Berrics color-way.
			<br />+</br />
			A pair of Stance socks.
			<br />+</br />
			A piece of the old Berrics skatepark.
			<br />+</br />
			A photo print of the old park, shot and signed by Yoon Sul.
			<br />+</br />
			One entrance ticket to attend BATB6 Finals, and a chance<br />
			  for an all expense paid trip to BATB6 finals via a “BLACK TICKET”.<br />
			  (details inside every BATBOX).
	</div>
	<div class="heading">
		REMAINING TICKETS
	</div>
	<div class="tickets clearfix">
		<?php 
			$items = Set::extract("/DailyopMediaItem[display_weight>1]",$post);
			
			foreach ($items as $k => $v): 

		?>
		<div class="ticket">
			<img src="//img.theberrics.com/images/<?php echo $v['DailyopMediaItem']['MediaFile']['file']; ?>" alt="">
		</div>
		<?php endforeach ?>
	</div>
	<div class="heading">
		BATBOX MEMORIAL RETAILERS
	</div>
	<div class="retailers">
		<table border=0 cellpadding=0 cellspacing=0 width=100%>
  <tr height=17>
    <td width=70% height=17><strong>Active
      Ride Shop</strong></td>
    <td width=30%>&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>Burbank - 328
      N. San Fernando Suite 1. Burbank, CA 91502</td>
    <td width="30%">818-333-1580</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>Chino - 5501-A
      Philadelphia Street. Chino, CA 91710</td>
    <td width="30%">909-465-1600</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>Costa Mesa -
      2937 Bristol Street.&nbsp; Costa Mesa,
      CA 92626</td>
    <td width="30%">714-432-1918</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>El Segundo -
      720-A Allied Way.&nbsp; El Segundo, CA
      90245</td>
    <td width="30%">310-606-8621</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>Temecula -
      29720 Rancho California Rd.&nbsp; Temecula, CA 92591</td>
    <td width="30%">951-693-4155</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Cowtown
      Skateboards</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>Phoenix - 5024
      N. Central Avenue.&nbsp; Phoenix, AZ
      85012</td>
    <td width="30%">602-212-9687</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>Glendale -
      5708 W. Union Hills Rd.&nbsp; Glendale,
      AZ 85308</td>
    <td width="30%">623-580-5124</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>Tempe - 215 W
      University.&nbsp; Tempe, AZ 85281</td>
    <td width="30%">480-379-3605</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>Litchfield
      Park - 13000 W. Indian School Rd.&nbsp; Unit 4-A Litchfield, AZ 85340</td>
    <td width="30%">623-536-2345</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>The Boardroom</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>6264 N.
      Blackstone Ave.&nbsp; Fresno, CA 93710</td>
    <td width="30%">559-435-8600</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Classic Skate
      Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;776 Broadway Between 34th and 35th
      Street.&nbsp; Bayonne, NJ 07002</td>
    <td width="30%">201-243-0400</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Comfort Skate
      Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>133 River St,<font
  class="font8"><strong>Chattanooga</strong></font><strong><font class="font7">,&nbsp;</font><font
  class="font8">TN</font></strong><font class="font7">&nbsp;37405</font></td>
    <td width="30%">423) 305-0494</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Crooks Skate
      Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>3498
      University Ave. Riverside, CA 92501</td>
    <td width="30%">951-201-0508</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Faction Board
      Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>612 Broadway
      Suite B • Alexandria, MN 56308</td>
    <td width="30%">320.762.2573</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Faith Skate
      Supply</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>2328 2nd Ave
      N&nbsp;&nbsp;Birmingham, AL 35203</td>
    <td width="30%">(205) 244-1102</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Impact
      Streetwear</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width=70% height=16>2701 Ming Ave&nbsp;&nbsp;Bakersfield, CA 93304</td>
    <td width="30%">661) 835-7323</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Long Beach
      Skate</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>3142 E 7th
      St&nbsp;&nbsp;Long Beach, CA 90804</td>
    <td width="30%">(562) 434-5527</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Prime Skate
      Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>430 US Highway
      206&nbsp;&nbsp;Hillsborough Township, NJ 08844</td>
    <td width="30%">908) 281-2200</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Recess Skate
      &amp; Snow</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>1158 Highway
      105&nbsp;&nbsp;Boone, NC 28607</td>
    <td width="30%">(828) 355-9013</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Revolution
      Ride Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>232 King
      Street.&nbsp; West Brockville, ON
      K6V3S8</td>
    <td width="30%">613-342-3179</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>This Skate
      &amp; Snow</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width=70% height=16>625 1st Ave N&nbsp;&nbsp;Fargo, ND 58102</td>
    <td width="30%">(701) 365-8017</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Underground
      Skate Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>66 Franklin
      Ave, Nutley, NJ 07110&nbsp;</td>
    <td width="30%">973 320 2070</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>43 Hudson
      Street, Ridgewood, NJ 07450</td>
    <td width="30%">201 857 3000</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>116 South
      Washington St, Bergenfield, NJ 07621</td>
    <td width="30%">973 320 2070</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>VU Skateboard
      Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>7118 Harford
      Rd. Baltimore, MD 21234</td>
    <td width="30%">410-254-2552</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>35th Ave.
      Skate Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>28717 Pacific
      Hwy. South # 5.&nbsp; Federal Way, WA
      98003</td>
    <td width="30%">253-839-5202</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>628 Skate Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>403 South 5th
      Street.&nbsp; Pocatella ID, 83201</td>
    <td width="30%">208-921-2590</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Prodigy
      Boardshop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>1050 Shaw
      Avenue.&nbsp; # 1121 Clovis, CA 93612</td>
    <td width="30%">559-297-1515</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Continuum
      Skate Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>49 Spring
      St&nbsp;&nbsp;Charleston, SC 29403</td>
    <td width="30%">843) 577-2758</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Ideal Skate
      Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>124 Main
      Street.&nbsp; Deep River, CT 06417</td>
    <td width="30%">860-334-5277</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>175 Central
      Avenue.&nbsp; Norwich, CT 06360</td>
    <td width="30%">860-334-5277</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Lattakz Skate
      Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>37 Rue
      Prince.&nbsp; Sorel-Tracy, QC J3P4J5</td>
    <td width="30%">450-908-0501</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Old Skull
      Skateboards</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>84 High
      Street.&nbsp; Fairport, NY 14450</td>
    <td width="30%">585-678-9379</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Pitcrew
      Skateboards</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>207 N Market
      St&nbsp;&nbsp;Frederick, MD 21701</td>
    <td width="30%">301) 698-1813</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16><strong>Tekgnar Skate
      Shop</strong></td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=16>
    <td width=70% height=16>305 W Martin Luther King Jr Blvd&nbsp;&nbsp;Austin, TX 78701</td>
    <td width="30%">(512) 472-7343</td>
  </tr>
  <tr height=16>
    <td width="70%" height=16>&nbsp;</td>
    <td width="30%">&nbsp;</td>
  </tr>
  <tr height=14>
    <td colspan=2></td>
  </tr>
</table>
	</div>
</div>