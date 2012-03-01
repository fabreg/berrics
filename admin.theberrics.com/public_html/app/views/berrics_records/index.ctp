<div class='index'>
	<h2>Berrics Records</h2>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("record_name"); ?></th>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($records as $record): ?>
		<tr>
			<td><?php echo $record['BerricsRecord']['id'];?></td>
			<td align='center'><?php echo $this->Time->niceShort($record['BerricsRecord']['created'])?></td>
			<td align='center'><?php 
				
				switch($record['BerricsRecord']['active']) {
					
					case 1:
						echo "<span style='color:green'>YES</span>";
					break;
					default:
						echo "<span style='color:Red;'>NO</span>";
					break;
				}
			
			?></td>
			<td>
				<?php echo $record['BerricsRecord']['record_name']; ?>
			</td>
			<td></td>
			<td class='actions'>
				<a href='/berrics_records/edit/<?php echo $record['BerricsRecord']['id']; ?>'>Edit</a>
				<a href='/berrics_records/uploads/<?php Echo $record['BerricsRecord']['id']; ?>'>View Uploads</a>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
</div>