<?php 

$click_thru = "http://ad.doubleclick.net/clk;251260568;83376869;y";
$tracking = "http://ad.doubleclick.net/ad/N5865.236219.THEBERRICS/B6085509;sz=1x1;ord=[timestamp]?";

switch(date("Y-m-d")) {
	
	case "2012-07-16":
		$tracking = "http://ad.doubleclick.net/ad/N5865.236219.THEBERRICS/B6085509.2;sz=1x1;ord=[timestamp]?";
		$click_thru = "http://ad.doubleclick.net/clk;251260568;83376872;s";
		break;
	case "2012-07-17":
		$click_thru = "http://ad.doubleclick.net/clk;251260568;83376897;z";
		$tracking = "http://ad.doubleclick.net/ad/N5865.236219.THEBERRICS/B6085509.11;sz=1x1;ord=[timestamp]?";
		break;
}


$this->set("title_for_layout","The Berrics - Adidas Footwear Presents: Lucas & Friends");

?>
<style>
* {

	padding:0px;
	margin:0px;

}

body {

	background-color:#f0f0f0;

}

.splash-image {

	background-color: #f9efdc;
	padding:10px;
	border:1px solid #999;
	margin:auto;
	width:900px;
-webkit-box-shadow:  1px 1px px 1px #000;
        
        box-shadow:  1px 1px px 1px #000;
	
}

.splash-image img {

	border:1px solid #999;

}

.enter {

	text-align:center;
	padding-top:10px;
}

.enter a {

	font-size:28px;
	color:#333;

}
</style>
<div id='adidas-lucas'>
	<div class='shim'>
		<img src='<?php echo $tracking; ?>' width='1' height='1'/>
	</div>
	<div class='splash-image'>
		<a target='_blank' title='Adidas Presents: Lucas & Friends' href='<?php echo $click_thru; ?>'>
			<img border='0' alt='Adidas Present: Lucas & Friends' src='/img/splash/adidas/splash-adidas-lucas.jpg'/>
		</a>
	</div>
	<div class='enter'>
		<a href='/dailyops'>- ENTER THE BERRICS -</a>
	</div>
</div>