<script>
$(document).ready(function() { 


	$("a[rel=toggle-search]").click(function() { 

		$("#search").toggle();
		return false;

	});

	
	$("#dupe_uri_button").click(function() { 

		$("tr[dailyop_id]").each(function() { 

			var id=$(this).attr("dailyop_id");
			var sid=$(this).attr("section_id");
			var uri = $(this).attr("uri");
			dupe_uri_check(id,sid,uri);
		});

	});
	
});


function dupe_uri_check(dailyop_id,section_id,uri) {

	
	$.ajax({

		"url":"/dailyops/dupe_uri_check/"+dailyop_id+"/"+section_id+"/"+uri,
		"success":function(d) {
			var color = "green";
			var msg = "(OK)"
			if(d==0) {
	
				color="red";
				msg="(Duplicate Found)";
				
			} 
		 	$("tr[dailyop_id="+dailyop_id+"]").find(".uri").append("<span style='color:"+color+";'>"+msg+"</span>");
		
		}

	});
	
	
}

</script>
<style>
#dopt {

	font-size:95%;

}
</style>
<div class="dailyops index">
	<h2><?php __('Dailyops');?></h2>
	<div class='form'>
		<fieldset>
			<legend><a href='#' rel='toggle-search'>Search</a></legend>
			<div id='search' style='display:none;'>
				<?php 
				
					echo $this->Form->create("Dailyop",array("url"=>array("action"=>"search")));
					echo $this->Form->input("name");
					echo $this->Form->input("sub_title");
					echo $this->Form->input("DailyopSection",array("empty"=>"All *"));
					echo $this->Form->end("Run Search");
					
				?>
			</div>
		</fieldset>
	</div>
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
	<div><input type='button' value='Check For Duplicate URI' id='dupe_uri_button' /></div>
	<table cellpadding="0" cellspacing="0" id='dopt'>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort("active"); ?>
			<th><?php echo $this->Paginator->sort("promo"); ?></th>
			<th><?php echo $this->Paginator->sort("fix_later"); ?></th>
			<th><?php echo $this->Paginator->sort("title_episode"); ?></th>
			<th><?php echo $this->Paginator->sort("Featured","featured_archive"); ?></th>
			<th><?php echo $this->Paginator->sort("contest_post"); ?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort("publish_date"); ?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('dailyop_section_id');?></th>
			<th>URI</th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($dailyops as $dailyop):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>  dailyop_id='<?php echo $dailyop['Dailyop']['id']; ?>' section_id='<?php echo $dailyop['DailyopSection']['id']; ?>' uri='<?php echo $dailyop['Dailyop']['uri']; ?>'>
		<td><?php echo $dailyop['Dailyop']['id']; ?>&nbsp;</td>
		<td><?php 
				
			switch($dailyop['Dailyop']['active']) {
				
				case 1:
					echo "Yes";
				break;
				default:
					echo "No";
				break;
				
			}
		
		?></td>
			<td><?php 
				
			switch($dailyop['Dailyop']['promo']) {
				
				case 1:
					echo "Yes";
				break;
				default:
					echo "No";
				break;
				
			}
		
		?></td>
		<td><?php 
				
			switch($dailyop['Dailyop']['fix_later']) {
				
				case 1:
					echo "Yes";
				break;
				default:
					echo "No";
				break;
				
			}
		
		?></td>
			<td><?php 
				
			switch($dailyop['Dailyop']['title_episode']) {
				
				case 1:
					echo "Yes";
				break;
				default:
					echo "No";
				break;
				
			}
		
		?></td>
		<td><?php 
				
			switch($dailyop['Dailyop']['featured_archive']) {
				
				case 1:
					echo "Yes";
				break;
				default:
					echo "No";
				break;
				
			}
		
		?></td>
		<td><?php 
				
			switch($dailyop['Dailyop']['contest_post']) {
				
				case 1:
					echo "Yes";
				break;
				default:
					echo "No";
				break;
				
			}
		
		?></td>
		<td><?php echo $this->Time->niceShort($dailyop['Dailyop']['modified']); ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($dailyop['Dailyop']['publish_date']); ?></td>
		<td><?php echo $dailyop['Dailyop']['name']; ?> - <?php echo $dailyop['Dailyop']['sub_title']; ?></td>
		<td>
			<?php echo $this->Html->link($dailyop['User']['last_name'].", ".$dailyop['User']['first_name']." ( ".$dailyop['User']['email']." )", array('controller' => 'users', 'action' => 'view', $dailyop['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($dailyop['DailyopSection']['name'], array('controller' => 'dailyop_sections', 'action' => 'view', $dailyop['DailyopSection']['id'])); ?>
		</td>
		<td class='uri'>
			<?php 
			
				$uri = "/".$dailyop['DailyopSection']['uri']."/".$dailyop['Dailyop']['uri'];
				echo "<a href='http://dev.theberrics.com{$uri}' target='_blank'>{$uri}</a>"
			?>
		</td>
		<td class="actions">
			<?php //echo $this->Html->link("View", "http://dev.theberrics.com/dailyops/view/".$dailyop['Dailyop']['id']."/".$dailyop['Dailyop']['uri'],array("target"=>"_blank")); ?>
			<?php echo $this->Html->link(__('Edit New Window', true), array('action' => 'edit', $dailyop['Dailyop']['id'],base64_encode($this->here)),array("target"=>"_blank")); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $dailyop['Dailyop']['id'],base64_encode($this->here))); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $dailyop['Dailyop']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dailyop['Dailyop']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
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
</div>
