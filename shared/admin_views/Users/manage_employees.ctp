<div class="page-header">
	<h1>Manage Employees</h1>
</div>
<div class="index">
	<table>
		<thead>
			<tr>
				<th>
					<?php echo $this->Paginator->sort("id") ?>
				</th>
				<th>
					<?php echo $this->Paginator->sort("modified") ?>
				</th>
				<th>Name</th>
				<th></th>
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
				<td>
					<?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?>
				</td>
				<td>
					
				</td>
				<td></td>
				<td></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>