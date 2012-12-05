<?php 

$img = $profile['UserProfileImage'][0];
 
?>
<div id='profile-details' class='clearfix'>
	<div class="image">
		<?php echo $this->Media->profileThumb($img,array("w"=>250,"h"=>250,"zc"=>1)); ?>
	</div>
	<div class="info">
		<div class="line">
			<h1>
				<?php echo strtoupper($profile['User']['first_name']." ".$profile['User']['last_name']) ?>
			</h1>
		</div>
		<div class="line">
			<?php if (($profile['User']['am_skater']) || ($profile['User']['pro_skater'])): ?>
				<strong>Class: </strong><?php echo ($profile['User']['pro_skater']) ? "Professional":"Amateur"; ?> // 
			<?php endif ?>
			<strong>DOB: </strong> 
			<?php if (!empty($profile['User']['birth_date'])): ?>
				<?php echo date("F m, Y",strtotime($profile['User']['birth_date'])) ?>
			<?php else: ?>
				NA //
			<?php endif; ?>
		</div>
		<div class="line">
			<dl class='dl-horizontal'>
				<dt>Sponsors:</dt>
				<dd>
					<?php 
						foreach ($profile['Tag'] as $k => $v): 
							if(empty($v['brand_id'])) continue;
					?>
						<?php echo $v['Brand']['name']; ?>
					<?php endforeach ?>
				</dd>
			</dl>
		</div>
	</div>
</div>	