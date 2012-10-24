<script>

$(document).ready(function() { 

	
	
});

</script>
<style>
.index table td {

	font-size:10px;

}
</style>
<div class='page-header'>
<h1>Users</h1>
</div>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class='dropdown'>
			<a href="#" class='dropdown-toggle' rel="noAjax" data-toggle="dropdown">Actions <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li>
					<a href="/users/add" rel="noAjax"><i class="icon icon-plus-sign"></i> Add New User</a>
				</li>
			</ul>
		</li>
		<li><a href="#2" rel="noAjax" data-toggle="tab">Search</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane" id="2">
			<div class="row-fluid">
				<div class="span12">
					<div class="well well-small">
						

					<?php 
						echo $this->Form->create("User",array("url"=>array("action"=>"search")));
					?>
					<?php 
						echo $this->Form->input("first_name");
						echo $this->Form->input("last_name");
						echo $this->Form->input("email");
						echo $this->Form->input("UserGroup",array("empty"=>"* ALL"));
						echo $this->Form->input("twitter_handle");
						echo $this->Form->input("instagram_handle");
					?>
					<div class="form-actions"><button type="submit" class="btn btn-primary">Run Search</button></div>
					<?php 
						echo $this->Form->end();
					?>
					</div>
				</div>
			</div>
			<?php 
					echo $this->Form->create("User",array("url"=>array("action"=>"search")));
				?>
				
				
		</div>
	</div>
</div>
<div class="users index">
	
	
	<?php echo $this->Admin->adminPaging(); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>	
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort("email_verified"); ?></th>
			<th><?php echo $this->Paginator->sort("pro_skater") ?></th>
			<th><?php echo $this->Paginator->sort("am_skater") ?></th>
			<th><?php echo $this->Paginator->sort("last_name"); ?></th>
			<th><?php echo $this->Paginator->sort("first_name"); ?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort("email"); ?></th>
			<th><?php echo $this->Paginator->sort("twitter_handle"); ?></th>
			<th><?php echo $this->Paginator->sort("instagram_handle"); ?></th>
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
		
		<td><?php echo $user['User']['email_verified']; ?></td>
		<td>
			<?php if ($user['User']['pro_skater']): ?>
				<span class="label label-success"><i class="icon icon-white icon-thumbs-up"></i></span>
			<?php else: ?>
				<span class="label label-important"><i class="icon icon-white icon-thumbs-down"></i></span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($user['User']['am_skater']): ?>
				<span class="label label-success"><i class="icon icon-white icon-thumbs-up"></i></span>
			<?php else: ?>
				<span class="label label-important"><i class="icon icon-white icon-thumbs-down"></i></span>
			<?php endif ?>
		</td>
		<td><?php echo $user['User']['last_name']; ?></td>
		<td><?php echo $user['User']['first_name']; ?></td>
		
		<td><?php echo $this->Time->niceShort($user['User']['created']); ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($user['User']['modified']); ?>&nbsp;</td>

		<td><?php echo $user['User']['email']; ?> <span style='font-size:10px;'><a target='_blank' href='http://facebook.com/profile.php?id=<?php echo $user['User']['facebook_account_num']; ?>'>(Facebook)</a></span></td>
		<td><?php echo $user['User']['twitter_handle']; ?></td>
		<td><?php echo $user['User']['instagram_handle']; ?></td>
		<td>
			<?php echo $this->Admin->link($user['UserGroup']['name'], array('controller' => 'user_groups', 'action' => 'view', $user['UserGroup']['id'])); ?>
		</td>
		<td class="actions">
			<?php if ($this->request->is("ajax")): ?>
				<button class="btn btn-success btn-small attach-user-btn" type="button" value='<?php echo $user['User']['id']; ?>'><i class="icon icon-plus icon-white"></i> Attach User</button>
			<?php else: ?>
				<?php echo $this->Admin->link("Edit Account", array('action' => 'edit', $user['User']['id'],base64_encode($this->here))); ?>
				<?php echo $this->Admin->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
				<?php echo $this->Admin->link("Update Password",array("controller"=>"users","action"=>"update_password",$user['User']['id'])); ?>
				<a href='/users/force_login/<?php echo $user['User']['id']; ?>'>Login AS</a>
				<a href="<?php echo $this->Html->url(array('controller'=>'tags', 'action'=>'disambig',$user['User']['id']), false); ?>" target="_blank" class="btn btn-small btn-info">Disambiguate</a>
			<?php endif ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Admin->adminPaging(); ?>
</div>
