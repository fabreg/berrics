<script>
function handleVideoUpload() {

	window.history.go();
	
}

function handleStillUpload() {

	window.history.go();
	
}
</script>
<div class='index'>
	<h2>The Dailyops</h2>
	<table cellspacing='0'>
		<tr>
			<th>Assigned Users</th>
			<th>Status</th>
			<th>Title - SubTitle</th>
			<th>Publish Date</th>
			<th>Publish Date</th>
			<th>Publish Date</th>
			<th>Publish Date</th>
			<th>Publish Date</th>
			<th>Publish Date</th>
		</tr>
		<?php foreach($posts as $post): ?>
		<tr>
			<td>
				<?php foreach($post['AssignedUser'] as $user): ?>
				<div class='<?php echo $user['id']; ?>'>
					<?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?> ( <?php echo $user['title']; ?> )
				</div>
				<?php endforeach; ?>
			</td>
			<td nowrap ><?php 
					if($post['Status']['pass']):
				?>
				<div class='dop-status-good'>Good to go</div>
				<?php else: ?>
				<?php echo $post['Status']['msg']; ?>
				<?php endif; ?>
				</td>
			<td>
				<?php echo $post['Dailyop']['name']; ?>
				<?php if(!empty($post['Dailyop']['sub_title'])): ?>
				- <?php echo $post['Dailyop']['sub_title']; ?>
				<?php endif; ?>
			</td>
						<td><?php echo date("D",strtotime($post['Dailyop']['publish_date'])); ?>, <?php echo date("M dS,Y [H:i:s]",strtotime($post['Dailyop']['publish_date'])); ?></td>
			
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td class='actions'>
				<a href='/dailyops/edit/<?php echo $post['Dailyop']['id']; ?>'>Edit</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>