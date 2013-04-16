<script type="text/javascript">
	dailyops_date = new Date(<?php echo strtotime($dateIn)*1000; ?>);
</script>
<div class='dailyops-day' data-date='<?php echo date('Y-m-d',strtotime($dateIn)) ?>' data-next-uri='<?php echo date("/Y/m/d",strtotime("-1 Day",strtotime($dateIn))); ?>' data-timestamp='<?php echo strtotime($dateIn)*1000; ?>'>
<?php echo $this->element("banners/728") ?>
<?php 
	$lazy = true;
	//if(!$this->request->is('ajax')) $lazy = false;

	foreach ($posts['posts'] as $k => $v): 
?>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$v,"lazy"=>$lazy)); ?>
	<?php if ($k==2): ?>
			<?php echo $this->element("banners/728",array("unit"=>"dopsv3_728b")); ?>
	<?php endif ?>
	<?php endforeach ?>
</div>