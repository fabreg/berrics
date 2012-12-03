<script type="text/javascript">
	dailyops_date = new Date(<?php echo strtotime($dateIn)*1000; ?>);
</script>
<div class='dailyops-day' data-date='<?php echo date('Y-m-d',strtotime($dateIn)) ?>'>
<div class="banner-728" id='banner1'>
		<img src="/img/v3/layout/728-banner.png" alt="" border='0'>
</div>
<?php 
	$lazy = true;
	if($home_mode && !$this->request->is('ajax')) $lazy = false;

	foreach ($posts['posts'] as $k => $v): 
?>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$v,"lazy"=>$lazy)); ?>
	<?php endforeach ?>
	<?php foreach ($posts['news'] as $k => $v): ?>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$v)); ?>
	<?php endforeach ?>
<script type="text/javascript">
	$('img.lazy').lazyload({
		threshold : 200
	});
</script>
</div>