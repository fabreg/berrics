<?php 

$c = Arr::countries();

?>
<div class='index'>
	<h2>Younited Nations Event: <?php echo $event['YounitedNationsEvent']['name']; ?></h2>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("ID","YounitedNationsEventEntry.id"); ?></th>
			<th><?php echo $this->Paginator->sort("Created","YounitedNationsEventEntry.created"); ?></th>
			<th><?php echo $this->Paginator->sort("Modified","YounitedNationsEventEntry.modified"); ?></th>
			<th><?php echo $this->Paginator->sort("Name","YounitedNationsPosse.name"); ?></th>
			<th><?php echo $this->Paginator->sort("Country","YounitedNationsPosse.country"); ?></th>
			<th><?php echo $this->Paginator->sort("Formatted","YounitedNationsPosse.geo_formatted"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($entries as $e): ?>
		<tr>
			<td align='center'><?php echo $e['YounitedNationsEventEntry']['id']; ?></td>
			<td align='center'><?php echo $this->Time->niceShort($e['YounitedNationsEventEntry']['created']); ?></td>
			<td align='center'><?php echo $this->Time->niceShort($e['YounitedNationsEventEntry']['modified']); ?></td>
			<td><?php echo $e['YounitedNationsPosse']['name']; ?></td>
			<td><?php echo $c[$e['YounitedNationsPosse']['country']];  ?></td>
			<td><?php echo $e['YounitedNationsPosse']['geo_formatted']; ?></td>
			<td class='actions'>
				<a href='/younited_nations_events/view_posse/<?php echo $e['YounitedNationsPosse']['id']; ?>/<?php echo base64_encode($this->here); ?>'>View</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>