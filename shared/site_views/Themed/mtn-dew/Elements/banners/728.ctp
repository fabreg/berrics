<?php 
$b_var = "banner-".md5(microtime().mt_rand(9999,99999));
if(!isset($unit)) { 

	$unit = "MOUNTAINDEW_A";
	$tile = "";

} else {

	$tile = "";
	$unit = "MOUNTAINDEW_B";
}
?>
<?php if (!$this->request->is('ajax')): ?>
<div class="banner-728" id='<?php echo $b_var ?>'>
	<!-- dopsv3_728 -->
	<script type="text/javascript">
	  var ord = window.ord || Math.floor(Math.random() * 1e16);
	  document.write('<script type="text/javascript" src="https://ad.doubleclick.net/N5885/adj/<?php echo $unit; ?>;<?php echo $tile; ?>sz=728x90;ord=' + ord + '?"><\/script>');
	</script>
	<noscript>
	<a href="https://ad.doubleclick.net/N5885/jump/<?php echo $unit; ?>;sz=728x90;ord=[timestamp]?">
	<img src="https://ad.doubleclick.net/N5885/ad/<?php echo $unit; ?>;sz=728x90;ord=[timestamp]?" width="728" height="90" />
	</a>
	</noscript>
</div>
<?php elseif($this->request->is('ajax')): ?>
<div class="banner-728" id='<?php echo $b_var ?>'>
	<!-- dopsv3_728 -->


</div>
	<script type="text/javascript">
	  var ord = window.ord || Math.floor(Math.random() * 1e16);
	 $('#<?php echo $b_var ?>').writeCapture().html('<script type="text/javascript" src="https://ad.doubleclick.net/N5885/adj/<?php echo $unit; ?>;<?php echo $tile; ?>sz=728x90;ord=' + ord + '?"><\/script>');
	</script>

<?php endif; ?>