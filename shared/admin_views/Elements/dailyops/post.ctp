<div class='post'>
		
	<strong>
		<?php echo $post['Dailyop']['name']; ?> <?php echo (!empty($post['Dailyop']['sub_title'])) ? " - ".$post['Dailyop']['sub_title']:""; ?>
	</strong>
	<div style='margin-top: 1px;'>
		<?php 
		$puri = $this->Berrics->dailyopsPostUrl($post);
		?>
		<small><em><a
				href='http://dev.theberrics.com<?php echo $puri; ?>'><?php echo $puri; ?>
			</a> </em> </small>
	</div>
	<div style='margin-top: 3px;'>
		<?php if($post['Status']['pass']): ?>
		<button class='btn btn-mini btn-success'>
			<i class='icon icon-white icon-thumbs-up'></i>
		</button>
		<?php else: ?>
		<button value='button' class='btn btn-mini btn-danger post-error' data-toggle='collapse' data-target='#errors-<?php echo $post['Dailyop']['id']; ?>'><i class='icon icon-white icon-thumbs-down'></i></button>
		
		<?php endif; ?>
		<button type='button' value='' data-toggle='collapse' data-target='#users-<?php echo $post['Dailyop']['id']; ?>' class='btn btn-primary btn-mini users-button'><i class='icon icon-white icon-user'></i> <?php echo count($post['UserAssignedPost']); ?></button>
		<a class='btn btn-primary btn-mini'
			href='<?php echo $this->Admin->url(array("controller"=>"dailyops","action"=>"edit",$post['Dailyop']['id'],"cb"=>$this->here)); ?>'><i
			class='icon icon-edit icon-white'></i> Edit</a> 
			<a href="<?php echo $this->Admin->url(array("controller"=>"trending_posts","action"=>"add_post",$post['Dailyop']['id'])); ?>" class="btn btn-success btn-mini"><i class="icon icon-white icon-plus-sign"></i> Make Tredning</a>
		<?php
			$tq = array(
						"original_referer"=>"http://theberrics.com/{$post['DailyopSection']['uri']}/{$post['Dailyop']['uri']}",
						"source"=>"tweetbutton",
						"text"=>"http://theberrics.com/{$post['DailyopSection']['uri']}/{$post['Dailyop']['uri']}",
						"hashtags"=>"berrics"
					);
			
			?>
			<a href='https://twitter.com/intent/tweet?<?php echo http_build_query($tq); ?>' target='_blank' class='btn btn-primary btn-mini'><i class="icon-twitter-sign"></i> Tweet </a>


	</div>
	<div style='margin-top: 3px;'>
		<span
			class='label label-info'> <?php echo date('g:iA',strtotime($post['Dailyop']['publish_date'])); ?>
		</span>&nbsp;

		<?php if($post['Dailyop']['hidden']) echo "<span class='label label-inverse'>Hidden</span> "; ?>
		<?php if($post['Dailyop']['pinned']) echo "<span class='label label-warning'>Pinned</span> "; ?>
		<?php if($post['Dailyop']['active'] == 0) echo "<span class='label label-inverse'>Not Active</span> "; ?>
	</div>
	<?php if(count($post['UserAssignedPost'])>0): ?>
	<div id='users-<?php echo $post['Dailyop']['id']; ?>' class='collapse' style='padding-top:5px;'>
		<div class='alert alert-info'>
			
			<strong>Users</strong>
			<ul>
				<?php foreach($post['UserAssignedPost'] as $up): ?>
				<li><?php echo $up['User']['first_name']; ?> <?php echo $up['User']['last_name']; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	
	<?php endif; ?>
	
	
	<?php if(!$post['Status']['pass']): ?>
	<div id="errors-<?php echo $post['Dailyop']['id']; ?>" class='collapse post-errors'>
			<div class='heading'>Post Errors</div>
			<div class='inner'>
			<ul>
				<?php 
					
					foreach($post['Status']['msg'] as $v) {
						
						echo "<li>{$v}</li>";
						
					}
						
				?>
			</ul>
			</div>
	</div>
	<?php endif; ?>
</div>