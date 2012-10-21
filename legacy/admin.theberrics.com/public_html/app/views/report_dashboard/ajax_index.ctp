<div class='index'>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th>User</th>
			<th>-</th>
		</tr>
		<?php foreach($data as $report): 
			$r = $report['BqReport'];
		?>
		<tr>
			<td><?php echo $r['id']; ?></td>
			<td><?php echo $this->Time->niceShort($r['created']); ?></td>
			<td>-</td>
			<td>-</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>