<?php 

if(!isset($unit))  { 
	$unit = "PROMO_BANNERS_A";
	$tile = "tile=2;";
} else {
	$unit = "PROMO_BANNERS_B";
	$tile = "tile=4;";
}

?>
<div class='banner-300'>
<!-- dopsv3_300 -->
<script type="text/javascript">
  var ord = window.ord || Math.floor(Math.random() * 1e16);
  document.write('<script type="text/javascript" src="https://ad.doubleclick.net/N5885/adj/<?php echo $unit; ?>;<?php echo $tile; ?>sz=300x250;ord=' + ord + '?"><\/script>');
</script>
<noscript>
<a href="https://ad.doubleclick.net/N5885/jump/<?php echo $unit; ?>;sz=300x250;ord=[timestamp]?">
<img src="https://ad.doubleclick.net/N5885/ad/<?php echo $unit; ?>;sz=300x250;ord=[timestamp]?" width="300" height="250" />
</a>
</noscript>
</div>