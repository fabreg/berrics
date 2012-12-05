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
<div id='profile-instagram' class='profile'>
	<?php echo $this->element("profiles/details"); ?>
	<?php echo $this->element("profiles/tabs"); ?>
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
	</div>
</div>

