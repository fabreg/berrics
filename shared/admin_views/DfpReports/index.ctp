<div class='index form'>

<h2>Double Click Reports</h2>
	<table cellspacing='0' >
		<tr>
			
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("date_start"); ?></th>
			<th><?php echo $this->Paginator->sort("date_end"); ?></th>
			<th><?php echo $this->Paginator->sort("notes"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($reports as $r): $r = $r['DfpReport']; ?>
		<tr>
			
			<td><?php echo $r['name']; ?></td>
			<td><?php echo $r['created']; ?></td>
			<td><?php echo $r['date_start']; ?></td>
			<td><?php echo $r['date_end']; ?></td>
			<td><?php echo $r['notes']; ?></td>
			<td class='actions'>
				<a href='/dfp_reports/view_report/<?php echo $r['hash']; ?>'>Preview Report</a>
				<a href='/dfp_reports/public/<?php echo $r['hash']; ?>' target='_blank'>Public Report View</a>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
</div>