<?php 

$TrendingPost = ClassRegistry::init("TrendingPost");

$trending_posts = $TrendingPost->currentTrending('daily');

?>
<div id="trending-content">
	<h2>TRENDING CONTENT: </h2>
	<div class="tab-row">
		<div class="tab">The Week</div>
		<div class="tab">This Month</div>
		<div class="tab">This Year</div>
	</div>
	<div class="content">
		<table cellspacing='0'>
			<tbody>
				<?php foreach ($trending_posts as $k => $v): ?>
				<tr>
					<td>
						
					</td>
					<td>
						
					</td>
				</tr>
				<?php endforeach ?>
				
			</tbody>
		</table>
	</div>
</div>