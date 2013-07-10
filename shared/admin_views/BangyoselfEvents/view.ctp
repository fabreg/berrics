<?php 

$e = $event['BangyoselfEvent'];

?>
<script>
$(document).ready(function() { 

	$("#search-form").submit(function() { 

		var file = $("#BangyoselfEntryFile").val();

		if(file.length>0) {

			document.location.href="?file="+file;
			
		} else {

			alert("You gotta enter a file man!");

		}

		return false;
		
	});
	
});
</script>
<div class="bangyoselfEvents index">

<h2><?php echo $e['name']; ?></h2>
<div class='form'>
	<fieldset>
		<legend>Search Files</legend>
	<?php 
	
		echo $this->Form->create("BangyoselfEntry",array("id"=>"search-form"));
		echo $this->Form->input("file");
		echo $this->Form->end("Search");
	
	?>
	<a href='<?php echo $this->request->here; ?>'>Reset Search</a>
	</fieldset>
</div>
<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<table cellspacing='0'>
		<tr>
			<th>
				<?php echo $this->Paginator->sort('created'); ?>
			</th>
			<th><?php echo $this->Paginator->sort('like_count'); ?></th>
			<th>
				<?php echo $this->Paginator->sort('name'); ?>
			</th>
			<th><?php echo $this->Paginator->sort("Dailyops Post","dailyop_id"); ?></th>
			<th>-</th>
		</tr>
		<?php 
		 
			foreach($entries as $entry):
			$e = $entry['BangyoselfEntry'];
			$u = $entry['User'];
		?>
		<tr>
			<td>
				<?php echo date("Y-m-d",strtotime($e['created'])); ?>
			</td>
			<td>
				<?php echo $e['like_count']; ?>
			</td>
			<td>
				<a href='/users/edit/<?php echo $e['user_id']; ?>' target='_blank'><?php echo $u['first_name']." ".$u['last_name']; ?></a>
			</td>
			<td>
			<?php if(!empty($e['dailyop_id'])): ?>
				<a href='/dailyops/edit/<?php echo $e['dailyop_id']; ?>'><?php echo $e['dailyop_id']; ?></a>
			<?php endif; ?>
			</td>
			<td class='actions'>
				<?php 
				
					if(empty($e['dailyop_id'])):
				
				?>
					<a href='/bangyoself_events/create_post/<?php echo $e['id']; ?>'>Create Post</a>
				<?php 
				
					else:
				
				?>
				<a href='/bangyoself_events/update_facebook_likes/<?php echo $e['id']; ?>'>Update Facebook Likes</a>
				<a href='/bangyoself_events/delete_post/<?php echo $e['id']; ?>'>Delete Post</a>
				<?php 
				
					endif; 
				?>
				<a href='http://img01.theberrics.com/bang-yoself/<?php echo $e['file_name']; ?>' target='_blank'>View File</a>
				
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>

</div>
