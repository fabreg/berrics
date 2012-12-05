<?php 

$img = $profile['UserProfileImage'][0];

?>
<div id='profile-details'>
	<div class="heading">
		THE BERRICS PROFILE ARCHIVE
	</div>
	<div class="row-fluid">
		<div class="span4">
			<div class="img">
				
			</div>
		</div>
		<div class="span8 info">
			<div class="inner">
				<h1>	
				<?php 
					echo strtoupper($profile['User']['first_name']." ".$profile['User']['last_name']); 
				?>
				
				</h1>
				<?php if($profile['User']['pro_skater'] || $profile['User']['am_skater']): ?>
					<div class='pro-status'>
						Status: <?php echo ($profile['User']['pro_skater']) ? "Professional":"Amateur"; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div style='clear:both;'></div>
</div>	