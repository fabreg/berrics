<h3>Attached Posts</h3>
<div class="row-fluid">
	<div class="span6">
		<table cellspacing="0">
			<thead>
				<tr>
					<th>Display Weight</th>
					<th>Post Title</th>
					<th>-</th>
					<th>-</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->request->data['Dailyop'] as $k => $v): ?>
				<tr>
					<td><?php echo $v['name'];  ?><?php echo (!empty($v['sub_title'])) ? " - {$v['sub_title']}":"";  ?></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<div class="span6">
		
	</div>
</div>