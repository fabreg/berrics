<div class='index'>
	<h2>Generated Reports</h2>
	<table cellspacing='0'>	
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th>User</th>
			<th><?php echo $this->Paginator->sort("template"); ?></th>
			<th><?php echo $this->Paginator->sort("bq_status"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($data as $d): ?>
		<tr>
			<td><?php echo $d['BqReport']['id']; ?></td>
			<td>
			<?php echo $d['User']['first_name']; ?> <?php echo $d['User']['last_name']; ?>
			</td>
			<td><?php echo $d['BqReport']['template']; ?></td>
			<td><?php echo strtoupper($d['BqReport']['bq_status']); ?></td>
			<td class='actions'>-</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>