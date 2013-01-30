<div>
	<h3>Youtube Videos</h3>
</div>
<table cellspacing="0">
	<thead>
		<tr>
			<th>Preview IMG</th>
			<th>Info</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($videos as $k => $v): ?>
			<tr>
				<td>
					
				</td>
				<td>
					<div><?php echo $v['title']; ?></div>
					<div><?php echo $v['video_id'] ?></div>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<script type="text/javascript">
initBootstrap();
</script>
<pre>
<?php print_r($videos); ?>
</pre>