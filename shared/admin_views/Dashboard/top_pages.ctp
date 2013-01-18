<h3>Top <?php echo $this->request->params['pass'][0]; ?> Pages</h3>
<table cellspacing='0'>
	<thead>
		<tr>
			<th>Url</th>
			<th>Views</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($pages as $p): ?>
		<tr>
			<td>
				<small>
					<a href='http://theberrics.com<?php echo $p['page_views']['script_url']; ?>' target='_blank'>
						<?php echo $this->Text->truncate($p['page_views']['script_url'],50); ?>
					</a>
				</small>
			</td>
			<td>
			<?php echo number_format($p[0]['total']); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>