<h3>Top <?php echo $this->request->params['pass'][0]; ?> Videos</h3>
<div><small><em>* Reports are only valid for videos added 24hrs ago</em></small></div>
<table cellspacing='0'>
	<tr>
		<th>Video</th>
		<th>Views</th>
	</tr>
	<?php foreach($videos as $v): ?>
	<tr>
		<td>
			<div class="dropdown">
				<button class="btn btn-primary btn-small dropdown-toggle" data-toggle='dropdown'>
					<b class="caret"></b>
				</button> &nbsp;
				<ul class="dropdown-menu">
					<li> <a href='<?php echo $this->Admin->url(array("controller"=>"media_files","action"=>"inspect",$v['MediaFile']['id'])); ?>'> <i class="icon icon-edit"></i> Edit </a></li>
					<li> 
						<a href='<?php echo $this->Admin->url(array("controller"=>"media_files","action"=>"run_report",$v['MediaFile']['id'])); ?>'>
							<i class="icon icon-search"></i> Run Report
						</a>
					</li>
				</ul>
				<small><?php echo $v['MediaFile']['name']; ?></small>
			</div>
		</td>
		<td><?php echo number_format($v[0]['total']); ?></td>
	</tr>
	<?php endforeach; ?>
</table>