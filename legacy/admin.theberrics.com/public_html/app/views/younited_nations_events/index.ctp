<div class='index'>
	<h2>Younited Nations Events</h2>
	<div><a href='/younited_nations_events/add'>Add New Event</a></div>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modifed"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th>-</th>
		</tr>
		<?php 
			foreach($events as $e):
		?>
		<tr>
			<td width='10%' align='center'><?php echo $e['YounitedNationsEvent']['id']; ?></td>
			<td width='10%' align='center'><?php echo $this->Time->niceShort($e['YounitedNationsEvent']['created']); ?></td>
			<td width='10%' align='center'><?php echo $this->Time->niceShort($e['YounitedNationsEvent']['modified']); ?></td>
			<td><?php echo $e['YounitedNationsEvent']['name']; ?></td>
			<td class='actions'>
				<a href='/younited_nations_events/view/<?php echo $e['YounitedNationsEvent']['id']; ?>'>View Entries</a>
				<a href='/younited_nations_events/edit/<?php echo $e['YounitedNationsEvent']['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
			</td>
		</tr>
		<?php 
			endforeach;
		?>
	</table>
</div>
<?php 

pr($events);

?>