<style>
.instagram-item {

	float:left;
	margin:5px;
	padding:4px;
	background-color:black;
	width:315px;
	
}

.instagram-item .caption {

	font-size:12px;
	padding:5px;
	height:60px;
}

.instagram-item .image {

	text-align:center;

}

#instagram-profile .profile-image {
	
	width:100px;
	height:100px;

}

</style>
<div>
<?php 
	echo $this->element("profiles/main-details");	
?>

</div>
<div id='instagram-profile'>
<div class='profile-image'>
<img src='<?php echo $profile['User']['instagram_profile_image']; ?>' border='0' width='100%' height='100%' />
</div>
@<?php echo $profile['User']['instagram_handle']; ?>
</div>
<div>

	<?php foreach($instagram as $img):
		$item = $img['InstagramImageItem'];
		$images = unserialize($item['images']);
	?>
		<div class='instagram-item'>
			<div class='image'>
				<img border='0' src='<?php echo $images['low_resolution']['url']; ?>' />
			</div>
			<div>
				Likes: <?php echo $item['likes']; ?>
			</div>
			<div class='caption'>
				<?php echo $this->Text->truncate($item['caption'],120); ?>
			</div>
		</div>
	<?php endforeach; ?>
	<div style='clear:both;'></div>
</div>
