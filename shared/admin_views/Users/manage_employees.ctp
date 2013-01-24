<?php 

$eg = User::employeeGroups();

?>
<div class="page-header">
	<h1>Manage Employees</h1>
</div>
<div class="index">
	<table>
		<thead>
			<tr>
				<th>
					<?php echo $this->Paginator->sort("id"); ?>
				</th>
				<th>
					<?php echo $this->Paginator->sort("modified"); ?>
				</th>
				<th>Group</th>
				<th>Name</th>
				<th><?php echo $this->Paginator->sort("berrics_email"); ?></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach ($users as $k => $user): 
				$u = $user['User'];
			?>
			<tr>
				<td><?php echo $u['id'] ?></td>
				<td><?php echo $this->Time->niceShort($u['modified']) ?></td>
				<td><?php echo $eg[$u['employee_group']]; ?></td>
				<td>
					<?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?>
				</td>
				<td>
					<?php echo $u['berrics_email']; ?>
				</td>
				<td></td>
				<td class='actions'>
					<a href="<?php echo $this->Admin->url(array("action"=>"edit",$u['id'])); ?>" class="btn btn-primary btm-small"><i class="icon icon-white icon-edit"></i> Edit</a>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>