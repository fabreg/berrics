<div class='page-header'>
	<h1>Splash Dates</h1>
</div>
<div>
	<ul class='nav nav-tabs'>
		<li class='dropdown'>
			<a data-toggle='dropdown' href='#'>Actions <b class='caret'></b></a>
			<ul class='dropdown-menu'>
				<li>
					<a href='<?php echo $this->Html->url(array("plugin"=>"splash","controller"=>"dates","action"=>"edit"));?>'>
						<i class='icon icon-plus-sign'></i> Add New Date
					</a>
				</li>
			</ul>
		</li>
	</ul>
	<div class='tab-content'>
		<div class='tab-pane' id='search'>
			<div class='well'>
			
			</div>
		</div>
	</div>
</div>
<div class='index'>
	<table cellspacing='0'>
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort("id"); ?></th>
				<th><?php echo $this->Paginator->sort("publish_date"); ?></th>
				<th>&nbsp;</th>
				<th>-</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($dates as $d): ?>
			<tr>
				<td>
					<?php echo $d['SplashDate']['id']; ?>
				</td>
				<td><?php echo date('l, F dS Y',strtotime($d['SplashDate']['publish_date'])); ?></td>
				<td>
					<?php echo $d['SplashCreative']['page_title']; ?>
				</td>
				<td class='actions'>
					<a class='btn btn-primary btn-small' href='<?php echo $this->Html->url(array("action"=>"edit",$d['SplashDate']['publish_date'])); ?>'><i class='icon icon-white icon-edit'></i> Edit Date</a> 
					<?php 
						echo $this->Html->link("Delete",array("action"=>"delete",$d['SplashDate']['id']),array("confirm"=>"Are you sure you want to delete this entry?"));
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>