<?php 

$pub_timestamp = strtotime($post['Dailyop']['publish_date']);
$now_timestamp = time();

$is_published = ($pub_timestamp<$now_timestamp) ? true:false;

$is_published = true;

$dataLink = '';

if($is_published) {

	$dataLink = "data-link='/run-and-gun/{$post['Dailyop']['uri']}'";

}



?>
<div class="entry clearfix" <?php echo $dataLink; ?> >
	<div class="portrait">
		<img src="//img.theberrics.com/images/<?php echo $post['DailyopMediaItem'][1]['MediaFile']['file']; ?>" alt="">		
	</div>
	<div class="name-img">
		<?php if ($is_published): ?>
			
			<a href="/run-and-gun/<?php echo $post['Dailyop']['uri']; ?>">
				<img src="//img.theberrics.com/images/<?php echo $post['DailyopMediaItem'][3]['MediaFile']['file']; ?>" alt="" border='0' />
			</a>

		<?php else: ?>
			<img src="//img.theberrics.com/images/<?php echo $post['DailyopMediaItem'][2]['MediaFile']['file']; ?>" alt="" border='0' />
		<?php endif ?>
		
	</div>
	<div class="score-col" data-post-id='<?php echo $post['Dailyop']['id']; ?>'>
		<?php if ($is_published): ?>
			<?php if (isset($post['RgVote']['id'])): ?>
				<div class="score-div">
					<?php echo $post['RgVote']['score']; ?>
				</div>
			<?php else: ?>
				?
			<?php endif ?>
		<?php else: ?>
			<img src="/theme/run-and-gun/img/coming-soon.png" alt="">
		<?php endif ?>
	</div>
</div>