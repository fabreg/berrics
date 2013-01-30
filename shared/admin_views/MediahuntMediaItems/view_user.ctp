<style>
.media-item {

	float:left;
	width:20%;
	margin:10px;
	border:1px solid #ccc;
	min-height:175px;
}

.media-item .img {

	text-align:center;

}

.media-item .task {

	font-weight:bold;
	padding:3px;
}

.media-item .details {

	font-style:italic;
	font-size:12px;

}

</style>
<div class='index'>
	<h2><?php echo $user['User']['first_name']; ?> <?php Echo $user['User']['last_name']; ?></h2>
	<div>
		<?php if($user['UserProfile']['mediahunt_winner'] == 1): ?>
		<a href='/mediahunt_media_items/mark_winner/<?php echo $user['UserProfile']['id']; ?>/0/<?php echo base64_encode($this->request->here); ?>'>Remove as Possible Winner</a>
		<?php else: ?>
		<a href='/mediahunt_media_items/mark_winner/<?php echo $user['UserProfile']['id']; ?>/1/<?php echo base64_encode($this->request->here); ?>'>Mark as Possible Winner</a>
		<?php endif; ?>
	</div>
	<?php foreach($items as $i): ?>
	<div class='media-item'>
		<div class='img'>
			<a href='http://img.theberrics.com/mediahunt-media/<?php echo $i['MediahuntMediaItem']['file_name']; ?>' target='_blank'>
				<img src='http://img.theberrics.com/i.php?src=/mediahunt-media/<?php echo $i['MediahuntMediaItem']['file_name']; ?>&h=100' border='0'/>
			</a>
		</div>
		<div class='task'>
			<?php echo $i['MediahuntTask']['name']; ?>
		</div>
		<div class='details'>
			<?php echo $i['MediahuntTask']['details']; ?>
		</div>
	</div>
	<?php endforeach; ?>
	<div style='clear:both;'></div>
</div>
<?php 
pr($user);
?>