<div class="row-fluid">
	<div class="span12">
		<table cellspacing='0'>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>UserGroup</th>
		<th>Pro</th>
		<th>am</th>
		<th>-</th>
	</tr>
	<?php foreach($results as $r): ?>
	<tr>
		<td width='1%' nowrap='nowrap'><?php echo $r['User']['id']; ?></td>
		<td align='center'><?php echo $r['User']['first_name']; ?> <?php echo $r['User']['last_name']; ?></td>
		<td align='center'><?php echo $r['User']['email']; ?></td>
		<td align='center'><?php echo $r['UserGroup']['name']; ?></td>
		<td><?php echo $r['User']['pro_skater']; ?></td>
		<td><?php echo $r['User']['am_skater']; ?></td>
		<td>
			<a href='javascript:UserSearch.handleSelect(<?php echo json_encode($r); ?>);'>Select User</a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
	</div>
</div>