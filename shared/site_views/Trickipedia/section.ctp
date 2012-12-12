<?php 



foreach ($posts as $k => $v) {
	
}

?>
<div id="trickipedia">
	<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)) ?>
	</div>
	<div id="select-menu">
		<?php echo $this->Form->input("trick_select",array("options"=>$trick_menu)) ?>
	</div>
	<div id="posts" class='clearfix'>
		<?php 
			foreach ($posts as $k => $v): 
				$user = Set::extract("/Tag/User",$v);
				$trick = Set::extract("/Meta[key=/trick/i]/val",$v);
				$img = $v['DailyopMediaItem'][1]['MediaFile'];
		?>
			<div class="trick-div">
				<div class="img">
					<img src='http://img.theberrics.com/i.php?src=/loading-imgs/loading-700.jpg&amp;h=60&amp;w=60&amp;zc=1' data-original="http://img.theberrics.com/i.php?src=/images/<?php echo $img['file']; ?>&amp;w=60&amp;h=60&amp;zc=1" alt="" class='lazy' />
				</div>
				<div class="info">
					<div class="name">
						<?php echo strtoupper($user[0]['User']['first_name']); ?> <?php echo strtoupper($user[0]['User']['last_name']); ?>
					</div>
					<div class="trick">
						<?php echo strtoupper($trick[0]); ?>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>