<?php if (count($videos)<=0): ?>
	<div class="label label-important label-large">No Videos</div>
<?php else: ?>
	<div class="a btn btn-large btn-warning">Clear Queue</div>
	<table cellspacing="0">
		<?php foreach ($videos as $key => $v): ?>
		<tr>
			<td><?php echo $v['MediaFile']['name']; ?></td>
		</tr>
		<?php endforeach ?>
		
	</table>		
<?php endif ?>