<?php 

$u = $user['User'];

?>
<div class='featured-blogger-bit'>
	<div class='profile-image'>
		<?php echo $this->Html->image($u['profile_image_url']); ?>
	</div>
	<div class='profile-info'>
		<div class='name'>
			<?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?>
		</div>
		<div class='post-title'>
			Some Blog Post Title
		</div>
 	</div>
	<div style='clear:both;'></div>
</div>