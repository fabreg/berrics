<style type="text/css">

.instagram-photo {
	margin-bottom:5px;
	text-align: center;
	color:#fff;
	padding:5px;
	border-radius: 5px;
}

.goofy {

		background-color:#147fc3;

}

.regs {

	background-color:#d94e23;

}

.instagram-photo .comment {

	font-size:11px;
	line-height:12px;
	padding:5px;

}
</style>
<div style="text-align:center;">
	<a href="http://instagram.com/berrics" target='_blank'>
		<img src="/img/v3/layout/batb6-feed-heading.png" style='margin-bottom:5px; border-radius:5px;' alt="">
	</a>
</div>
<?php foreach ($pics as $k => $v): ?>
	<?php 
		if($k>5) continue;
		$cls = "regs";
		if($k%2) $cls = "goofy";
	?>
	<div class='instagram-photo <?php echo $cls; ?>'>
		<a href='<?php echo $v->link; ?>' target='_blank'>
		<img src="<?php echo $v->images->low_resolution->url ?>" alt="" border='0'>
		</a>
		<div class="comment">
			<?php echo $v->caption->text; ?>
		</div>
	</div>
<?php endforeach ?>