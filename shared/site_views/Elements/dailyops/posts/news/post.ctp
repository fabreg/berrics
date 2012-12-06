<?php 

$url = $this->Berrics->dailyopsPostUrl($post);

?>
<div class='post news-post'>
	<?php echo $this->element("dailyops/posts/news/post-top",array("post"=>$post)); ?>
	<div class="clearfix">
		<div class="image">
			<a href="<?php echo $url; ?>">
			<?php 

				
				 echo $this->Media->mediaThumb(array(
				"MediaFile"=>$post['DailyopTextItem'][0]['MediaFile'],
				"w"=>350,
				"h"=>200,
				"zc"=>1,
				"lazy"=>true
			)); 
			?>
			</a>
		</div>
		<div class="summary">
			<h2><a href="<?php echo $url; ?>" ><?php echo $post['Dailyop']['name']; ?></a> <br /> <small><?php echo $post['Dailyop']['sub_title']; ?>&nbsp;</small></h2>
			<p>
				<?php echo $post['DailyopTextItem'][0]['text_content']; ?>
			</p>
			<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)) ?>
		</div>
	</div>
</div>