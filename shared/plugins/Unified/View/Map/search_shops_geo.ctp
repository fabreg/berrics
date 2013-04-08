<?php if (!isset($res) || empty($res)): ?>
	<div class="label">
		No Stores Found
	</div>
<?php else: ?>
	<div>
		<?php echo count($res); ?>
	</div>
	<?php foreach ($res as $k => $v): ?>
		<div class='shop-result'>
			<div class="name">
				<?php echo $k+1; ?> <?php echo strtoupper($v['Store']['UnifiedStore']['shop_name']); ?>
			</div>
		</div>
	<?php endforeach ?>
<?php endif ?>