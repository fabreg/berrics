<div class='index'>
	<h2>Battle At The Berrics Events</h2>
	
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th><?php echo $this->Paginator->sort("user_id"); ?></th>
			<th><?php echo $this->Paginator->sort("official_event"); ?></th>
			<th>Actions</th>
		</tr>
	
	<?php 
		
		foreach($events as $event):
	
	?>
		<tr>
			<td><?php echo $event['BatbEvent']['id']; ?></td>
			<td><?php echo $event['BatbEvent']['created']; ?></td>
			<td><?php echo $event['BatbEvent']['modified']; ?></td>
			<td><?php echo $event['BatbEvent']['name']; ?></td>
			<td><?php echo $event['BatbEvent']['user_id']; ?></td>
			<td><?php echo $event['BatbEvent']['official_event']; ?></td>
			<td class='actions'>
				<?php echo $this->Admin->link("View Brackets",array("action"=>"view",$event['BatbEvent']['id'])); ?>
				<?php echo $this->Admin->link("Update User Rankings",array("controller"=>"batb_events","action"=>"update_user_rankings",$event['BatbEvent']['id'])); ?>
			</td>
			
		</tr>
	<?php 
	
		endforeach;
	
	?>
	
	</table>
	
</div>
<?php 

//pr($events);

?>