<script>

$(document).ready(function() { 

	
	$("a[rel=toggle-search]").click(function() { 


		$("#search").toggle();

		
	});
	
});

</script>
<div class="users index">
	<h2><?php __('Users');?></h2>
	<div class='form'>
		<fieldset>
			<legend><a href='#' rel='toggle-search'>Search</a></legend>
			<div id='search' style='display:none;'>
			<?php 
			
				echo $this->Form->create("User",array("url"=>array("action"=>"search")));
				echo $this->Form->input("first_name");
				echo $this->Form->input("last_name");
				echo $this->Form->input("email");
				echo $this->Form->input("UserGroup",array("empty"=>"* ALL"));
				echo $this->Form->end("Search");
			
			
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
	<table cellpadding="0" cellspacing="0">
	<tr>	
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort("last_name"); ?></th>
			<th><?php echo $this->Paginator->sort("first_name"); ?></th>
			
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort("email"); ?>
			<th><?php echo $this->Paginator->sort('twitter_account_num');?></th>
			<th><?php echo $this->Paginator->sort('facebook_account_num');?></th>
			<th><?php echo $this->Paginator->sort('user_group_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td style='font-size:10px;'><?php echo $user['User']['id']; ?>&nbsp;</td>
				<td><?php echo $user['User']['last_name']; ?></td>
		<td><?php echo $user['User']['first_name']; ?></td>
		
		<td><?php echo $this->Time->niceShort($user['User']['created']); ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($user['User']['modified']); ?>&nbsp;</td>

		<td><?php echo $user['User']['email']; ?></td>
		<td><?php echo $user['User']['twitter_account_num']; ?>&nbsp;</td>
		<td><?php echo $user['User']['facebook_account_num']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($user['UserGroup']['name'], array('controller' => 'user_groups', 'action' => 'view', $user['UserGroup']['id'])); ?>
		</td>
		<td class="actions">
			
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
			<?php echo $this->Html->link("Update Password",array("controller"=>"users","action"=>"update_password",$user['User']['id'])); ?>
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
