<div class='index form'>
	
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modifed"); ?></th>
			<th><?php echo $this->Paginator->sort("start_date"); ?></th>
			<th><?php echo $this->Paginator->sort("end_date"); ?></th>
			<th><?php echo $this->Paginator->sort("title"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($data as $c): ?>
		<tr>
			<td><?php echo $c['UserContest']['id']; ?></td>
			<td align='center'>
				<?php 
				
					switch($c['UserContest']['active']) {
						case 1:
							echo "<span style='color:green;'>Yes</span>";
						break;
						default:
							echo "<span style='color:red;'>No</span>";
						break;
					}
				
				?>
			</td>
			<td><?php 
			
				echo $this->Time->niceShort($c['UserContest']['created']);
			
			?></td>
			<td><?php 
			
				echo $this->Time->niceShort($c['UserContest']['modified']);
			
			?></td>
			<td><?php 
			
				echo $this->Time->niceShort($c['UserContest']['start_date']);
			
			?></td>
			<td><?php 
			
				echo $this->Time->niceShort($c['UserContest']['end_date']);
			
			?></td>
			<td><?php echo $c['UserContest']['name']; ?></td>
			<td class='actions'>
				<a href='/user_contests/edit/<?php echo $c['UserContest']['id']; ?>/<?php echo base64_encode($this->request->here); ?>'>Edit</a>
				<a href='/user_contests/view_entries/<?php echo $c['UserContest']['id']; ?>'>View Entries</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>