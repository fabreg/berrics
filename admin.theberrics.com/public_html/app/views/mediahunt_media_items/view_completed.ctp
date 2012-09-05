<div class='index'>
	<h2>Completed Media Hunt</h2>
	<table cellspacing='0'>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Email</th>
			<th>Flagged</th>
			<th>Actions</th>
		</tr>
		<?php foreach($users as $k=>$user): $u = $user['User']; ?>
		<tr>
			<td>
				<?php echo $k; ?>
			</td>
			<td>
				<?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?>
			</td>
			<td>
				<?php echo $u['email']; ?>
			</td>
			<td>
				&nbsp;<?php if($user['UserProfile']['mediahunt_winner'] == 1) echo "<span style='color:green; font-weight:bold;'>FLAGGED</span>"; ?>
			</td>
			<td class='actions'>
				<a href='/mediahunt_media_items/view_user/<?php echo $u['id']; ?>' target='_blank'>
					View Entries
				</a>
			</td>		
		</tr>
		<?php endforeach; ?>
	</table>
</div>