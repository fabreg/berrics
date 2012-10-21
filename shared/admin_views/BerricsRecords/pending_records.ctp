<style type="text/css">
	.uploads {



	}
	.uploads table {

		font-size:12px;

	}
</style>
<?php if ($this->request->is('ajax')): ?>
<h3>FTW Uploads <small><a href="<?php echo $this->Html->url(array('controller'=>'berrics_records', 'action'=>'pending_records'), false); ?>"><i class="icon icon-zoom-in"></i> View All</a></small></h3>
<?php else: ?>
<div class="page-header">
	<h1>For The Record: Pending Uploads</h1>
</div>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#1" data-toggle="tab">Search</a></li>
		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="1">
			<div class="well well-small">
				<?php echo $this->Form->create('MediaFileUpload',array(
					"id"=>'MediaFileUploadForm',
					"url"=>$this->request->here
				)); ?>

				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
<?php endif;  ?>
<?php echo $this->Admin->adminPaging(); ?>
<div class="index uploads">
	<table cellspacing="0">
		<thead>
			<tr>
				<th>Details</th>
				<th>Status</th>
				<?php if (!$this->request->is('ajax')): ?>
				<th>Notes</th>
				<th>File Name</th>
				<?php endif ?>
				<th>-</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($uploads as $k => $v): ?>
			<tr>
				<td>
					<div><strong><?php echo $v['BerricsRecord']['record_name']; ?></strong></div>
					<div><small><em><?php echo $this->Time->nice($v['MediaFileUpload']['created']); ?></em></small></div>
					<div><small>
						<?php //echo $v['MediaFileUpload'][''] ?>
					</small></div>
				</td>
				<td>
					<span class="label label-info">
						<?php echo strtoupper($v['MediaFileUpload']['file_status']); ?>
					</span>
				</td>
				<?php if (!$this->request->is('ajax')): ?>
				<td>
					<?php echo $v['MediaFileUpload']['notes']; ?>

				</td>
				<td>
					<?php echo $v['MediaFileUpload']['name']; ?>
				</td>
				<?php endif ?>
				<td width='1%'>
					<span class="dropdown">
							<a href="#" class='btn btn-primary' data-toggle='dropdown'>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu pull-right">
								<li><a href="http://50.57.104.64/<?php echo $v['MediaFileUpload']['file_name']; ?>" target='_blank'>
										<i class="icon-download"></i>Download File
									</a></li>
								<li>
									<a href="<?php echo $this->Html->url(array('action'=>'reject', $v['MediaFileUpload']['id']), false); ?>">
									<i class="icon-remove-sign"></i> Reject File</a>
									
								</li>
							</ul>
						</span>
				</td>
			</tr>	
			<?php endforeach ?>
		</tbody>
	</table>
</div>