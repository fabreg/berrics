<div id='canteen-navbar'>
<ul>
	<?php foreach($main_canteen_categories as $cat): ?>
	<li><a><?php echo strtoupper($cat['name']); ?></a></li>
	<li>//</li>
	<?php endforeach; ?>
</ul>
</div>
<div id='canteen-container'>

<?php echo $content_for_layout; ?>

</div>