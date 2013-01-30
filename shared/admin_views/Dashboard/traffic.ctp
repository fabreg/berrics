<h3>Realtime Traffic 
	<a href="/reports/realtime_videos" class="btn btn-mini btn-primary">Videos</a>
	<a href="/reports/realtime_pages" class="btn btn-mini btn-primary">Pages</a>
	<a href="/reports/realtime" class="btn btn-mini btn-primary">Both</a>
</h3>
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