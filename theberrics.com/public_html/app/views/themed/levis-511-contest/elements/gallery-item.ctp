<?php 

$m = $image['MediahuntMediaItem'];
$t = $image['MediahuntTask'];
$u = $image['User'];

$ig_data = json_decode($m['instagram_data'],true);


?>
<div class='image'>
			
				<img src='http://img.theberrics.com/i.php?w=400&h=350&src=/mediahunt-media/<?php echo $image['MediahuntMediaItem']['file_name']; ?>' border='0' />
			
		</div>
		<div class='task-div'>
			<div style='text-align:center;'>
				<img src='/theme/levis-511-contest/img/upload-logo.png' />
			</div>
			<div class='task-info'>
				<div class='label'>Photo Challenge #<?php echo $t['sort_order']; ?></div>
				<div class='value'><?php echo $t['name']; ?></div>
				<div class='label'>Photo By:</div>
				<div class='value'><?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?></div>
				<?php if(!empty($m['instagram_id'])): ?>
				<div class='label'>Instagram:</div>
				<div class='value'><a rel='no-ajax' href='<?php echo $ig_data['data']['link']; ?>' target='_blank'><?php echo $ig_data['data']['link']; ?></a></div>
				<?php endif; ?>
				<?php if($m['rank']>0): ?>
				<div class='label'>Rank:</div>
				<div class='value'><?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?></div>
				<?php endif; ?>
			</div>
		</div>
		<div style='clear:both;'></div>