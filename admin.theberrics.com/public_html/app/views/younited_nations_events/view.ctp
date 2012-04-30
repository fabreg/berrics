<?php 

$c = Arr::countries();

?>
<div class='index'>
	<h2>Younited Nations Event: <?php echo $event['YounitedNationsEvent']['name']; ?></h2>
	
	<fieldset>
		<legend>Search Entries</legend>
		<?php 
		
			echo $this->Form->create("YounitedNationsPosse",array("url"=>"/younited_nations_events/search_entries/".$this->params['pass'][0]));
			echo $this->Form->input("name");
			echo $this->Form->end("Search")
		
		?>
	</fieldset>
	
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
			<th><?php echo $this->Paginator->sort("Finalist","YounitedNationsEventEntry.finalist"); ?></th>
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
			<td align='center'><?php 
			
				switch($e['YounitedNationsEventEntry']['finalist']) {
					
					case 1:
						echo "<span style='color:green;'>Yes</span>";
						break;
					default:
						echo "<span style='color:red;'>No</span>";
						break;
					
				}
			
			?></td>
			<td><?php echo $e['YounitedNationsPosse']['name']; ?></td>
			<td><?php echo $c[$e['YounitedNationsPosse']['country']];  ?></td>
			<td><?php echo $e['YounitedNationsPosse']['geo_formatted']; ?></td>
			<td class='actions'>
				<a href='/younited_nations_events/view_entry/<?php echo $e['YounitedNationsEventEntry']['id']; ?>/callback:<?php echo base64_encode($this->here); ?>'>View</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>

</div>