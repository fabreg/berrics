<script>
$(document).ready(function() { 

	$("#canteen-navbar ul li").hover(
		function() { 

			//$("#canteen-navbar ul li ul").hide();
			
			$(this).find("ul").show('normal');
			
		},
		function() { 

			$(this).find("ul").hide();
			
		}
	);

	
});
</script>
<div id='canteen-navbar'>
<ul>
	<?php foreach($main_canteen_categories as $cat): ?>
	<li><a><?php echo strtoupper($cat['name']); ?></a>
		<ul>
			<?php foreach($cat['sub_categories'] as $scat): ?>
			<li><a href='/canteen/<?php echo $scat['uri']; ?>'><?php echo strtoupper($scat['name']); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</li>
	<li>//</li>
	<?php endforeach; ?>
</ul>
</div>
<div id='canteen-container'>

<?php echo $content_for_layout; ?>

</div>