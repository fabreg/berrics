<script>
$(document).ready(function() { 

	$("#canteen-navbar ul li").hover(
		function() { 

			//$("#canteen-navbar ul li ul").hide();
			
			$(this).find("ul").fadeIn('normal');
			$(this).addClass("over");
		},
		function() { 

			$(this).find("ul").hide();
			$(this).removeClass("over");
		}
	);
	$("#canteen-navbar ul li ul li").click(function() { 

		var ref = $(this).find("a").attr("href");

		document.location.href=ref;
		
	});
	
});
</script>
<div id='canteen-navbar'>
<ul>
	<li><a href='/canteen' style='text-decoration:none;'>HOME</a></li>
	<li> | </li>
	<?php foreach($main_canteen_categories as $cat): ?>
	<li><a><?php echo strtoupper($cat['name']); ?></a>
		<ul>
			<?php foreach($cat['sub_categories'] as $scat): ?>
			<li><a href='/canteen/<?php echo $scat['uri']; ?>'><?php echo strtoupper($scat['name']); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</li>
	<li> | </li>
	<?php endforeach; ?>
</ul>
</div>
<div id='canteen-container'>

<?php echo $content_for_layout; ?>

</div>