<h3>Realtime Traffic <small><a href="<?php echo $this->Html->url(array("controller"=>"reports","action"=>"realtime")); ?>">
		<i class="icon-zoom-in"></i> View
	</a></small>	</h3>
<table cellspacing='0'>
	<tr>
		<td>Page Views</td>
		<td><?php echo number_format($pages[0][0]['total']); ?></td>
	</tr>
	<tr>
		<td>Uniques</td>
		<td><?php echo number_format($uniques[0][0]['total']); ?></td>
	</tr>
	<tr>
		<td>Videos</td>
		<td><?php echo number_format($videos); ?></td>
	</tr>
</table>