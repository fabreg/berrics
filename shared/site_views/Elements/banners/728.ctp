<?php 
$b_var = "banner-".md5(microtime().mt_rand(9999,99999));
?>
<div class="banner-728 <?php echo $b_var ?>" >
	<?php if (!$this->request->is('ajax')): ?>
	<script type="text/javascript">
	 var ord = window.ord || Math.floor(Math.random() * 1e16);
	  document.write('<script type="text/javascript" src="https://ad.doubleclick.net/N5885/adj/dailyops_p1;sz=728x90;tile=1;ord=' + ord + '?"><\/script>');
	</script>
	<noscript>
	<a href="https://ad.doubleclick.net/N5885/jump/dailyops_p1;sz=728x90;tile=1;ord=[timestamp]?">
	<img src="https://ad.doubleclick.net/N5885/ad/dailyops_p1;sz=728x90;tile=1;ord=[timestamp]?" width="728" height="90" />
	</a>
	</noscript>	
	<?php endif ?>
</div>
<?php if ($this->request->is('ajax')): ?>
<script type="text/javascript">
	//var script=document.createElement('script');
	//script.type='text/javascript';
	//script.src=;
	// var ord = window.ord || Math.floor(Math.random() * 1e16);

	//$(".<?php echo $b_var ?>").writeCapture(script);
</script>
<?php endif ?>
