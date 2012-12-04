<?php 
$b_var = "banner-".md5(microtime().mt_rand(9999,99999));
?>
<?php if (!$this->request->is('ajax')): ?>
	

<div class="banner-728" id='<?php echo $b_var ?>'>
	<!-- dopsv3_728 -->
	<script type="text/javascript">
	  var ord = window.ord || Math.floor(Math.random() * 1e16);
	  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/dopsv3_728;sz=728x90;ord=' + ord + '?"><\/script>');
	</script>
	<noscript>
	<a href="http://ad.doubleclick.net/N5885/jump/dopsv3_728;sz=728x90;ord=[timestamp]?">
	<img src="http://ad.doubleclick.net/N5885/ad/dopsv3_728;sz=728x90;ord=[timestamp]?" width="728" height="90" />
	</a>
	</noscript>
</div>
<?php endif ?>