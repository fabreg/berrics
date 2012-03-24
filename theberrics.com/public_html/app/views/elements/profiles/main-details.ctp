<?php 

$img = $profile['UserProfileImage'][0];

?>
<div id='profiles-main-details'>
	<div class='profile-image'>
	<?php 
	
		echo $this->Media->profileThumb($img,array("w"=>250,"h"=>200,"zc"=>1));
	
	?>
	</div>
	<div class='profile-info'>
		<h1>	
		<?php 
			echo $profile['User']['first_name']." ".$profile['User']['last_name']; 
		?>
		</h1>
		<?php if($profile['User']['pro_skater'] || $profile['User']['am_skater']): ?>
		<div class='pro-status'>
			Status: <?php echo ($profile['User']['pro_skater']) ? "Professional":"Amateur"; ?>
		</div>
		<?php endif; ?>
	</div>
	<div style='clear:both;'></div>
</div>	