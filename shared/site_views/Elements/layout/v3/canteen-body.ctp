<?php 

$CanteenCategory = ClassRegistry::init("CanteenCategory");

$cats = $CanteenCategory->treeArray();

?>
<div id="canteen-nav" class='clearfix column-shadow '>
	<ul>
		<?php foreach ($cats as $k => $v): ?>
			<li>
				<?php echo $v['name'] ?>
				<ul>
					<?php foreach ($v['sub_categories'] as $kk => $vv): ?>
					<li>
						<?php echo $vv['name']; ?>
					</li>
					<?php endforeach ?>
				</ul>
			</li>
		<?php endforeach ?>
	</ul>
</div>
<div id="canteen-body">
	<?php echo $content_for_layout; ?>
</div>