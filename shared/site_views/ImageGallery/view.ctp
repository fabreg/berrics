<div id='gallery-view'>
	<?php if (!empty($post['DailyopSection']['section_heading_file'])): ?>
	<div class="row-fluid section-heading-div">
		<div class="span12">
			<?php echo $this->Media->sectionHeading(array(
				"DailyopSection"=>$post['DailyopSection'],
				"w"=>728
			)); ?>
		</div>
	</div>
	<?php endif; ?>
	<div class="post">
		<?php echo $this->element("dailyops/posts/post-top",array("dop"=>$post)) ?>
		<div style="height:30px"></div>
		<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)) ?>
	</div>
	<div class="viewing">
		<?php echo $this->Media->mediaThumb(array(
			"MediaFile"=>$view_item['MediaFile'],
			"w"=>728
		)) ?>
		<div class="gallery-nav clearfix">
			<div style='clear:both;'>
				<p>
					<?php echo $view_item['MediaFile']['caption']; ?>
				</p>
			</div>
			<?php if (!empty($prev_item)): ?>
			<div class="back-btn">
				<a href='/<?php echo $post['DailyopSection']['uri']; ?>/<?php echo $post['Dailyop']['uri'] ?>/view:<?php echo $prev_item['MediaFile']['id']; ?>'>
					<img src="/img/v3/layout/gallery-back-button.jpg" alt="">
				</a>	
			</div>
			
			<?php endif ?>
			<?php if (!empty($next_item)): ?>
			<div class="next-btn">
				<a href='/<?php echo $post['DailyopSection']['uri']; ?>/<?php echo $post['Dailyop']['uri'] ?>/view:<?php echo $next_item['MediaFile']['id']; ?>'>
					<img src="/img/v3/layout/gallery-next-button.jpg" alt="">
				</a>	
			</div>
			<?php endif ?>
			
		</div>
	</div>
	<div class="thumbs clearfix">
		<?php 
			foreach ($post['DailyopMediaItem'] as $k => $v): 
			$viewing_class = '';
			if($v['MediaFile']['id'] == $view_id) $viewing_class = "active";
		?>
			<div class="gallery-thumb <?php echo $viewing_class; ?>">
				<a href='/<?php echo $post['DailyopSection']['uri']; ?>/<?php echo $post['Dailyop']['uri'] ?>/view:<?php echo $v['MediaFile']['id']; ?>'>
				<?php echo $this->Media->mediaThumb(array(
					"MediaFile"=>$v['MediaFile'],
					"w"=>60,
					"h"=>40,
					"zc"=>1
				)); ?>
				</a>
			</div>
		<?php endforeach ?>
	</div>
</div>
<?php echo $this->element("dailyops/posts/recent-related-posts",array("post"=>$post)) ?>

<?php pr($prev_item); ?>