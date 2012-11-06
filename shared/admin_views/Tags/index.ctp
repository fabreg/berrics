<script type="text/javascript">
	

</script>
<div class='page-header'>
	<h1>Tags</h1>
</div>
<div>
	<ul class="nav nav-tabs">
		<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Actions <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="/tags/add">New Tag</a></li>
					
				</ul>
			
		</li>
		<li><a href="#search" data-toggle='tab'>Search</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane" id="search">
			<div class="well well-small">
				<?php 

				echo $this->Form->create("Tag",array("url"=>array("action"=>"search")));
				echo $this->Form->input("name");
				echo $this->Form->end("Search");

			?>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Admin->adminPaging();
?>
<div class="tags index">
	
	<table cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th>User</th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	</thead>
	<?php
	$i = 0;
	foreach ($tags as $tag):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $tag['Tag']['id']; ?>&nbsp;</td>
		<td><?php echo $tag['Tag']['modified']; ?>&nbsp;</td>
		<td><?php echo $tag['Tag']['name']; ?>&nbsp;</td>
		<td>
			<?php if (!empty($tag['User']['id'])): ?>
				<i class="icon icon-user"></i> <?php echo $tag['User']['first_name'];  ?> <?php echo $tag['User']['last_name']; ?>
			<?php else: ?>
				<span class="label label-important">No User</span>
			<?php endif ?>
		</td>
		<td class="actions">
			
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $tag['Tag']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $tag['Tag']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tag['Tag']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Admin->adminPaging(); ?>
</div>
