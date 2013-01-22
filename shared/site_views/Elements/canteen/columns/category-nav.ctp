<?php 

$CanteenCategory = ClassRegistry::init("CanteenCategory");

$canteen_array = $CanteenCategory->treeArray();

?>
<div id="canteen-category-nav">
	<div class="heading">
	CATEGORIES
	</div>
	<ul>
		<?php 

			foreach ($canteen_array as $k => $v):
				if($v['active'] == 0) continue;
		 ?>	
		<li>
			<?php echo $v['name']; ?>
			<?php if (count($v['sub_categories'])>0): ?>
				<ul>
				<?php foreach ($v['sub_categories'] as $kk => $vv): 
						if($vv['active'] == 0) continue;
				?>
					<li><a href='/canteen/<?php echo $vv['uri']; ?>'><?php echo $vv['name']; ?></a></li>
				<?php endforeach ?>
				</ul>
			<?php endif ?>
		</li>
		<?php endforeach ?>
	</ul>
</div>
