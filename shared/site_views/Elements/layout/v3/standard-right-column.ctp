<?php 

$TrendingPost = ClassRegistry::init("TrendingPost");

$trending_posts = $TrendingPost->currentTrending('weekly');

?>
<div id="standard-right-column">
	<div id="trending-content">
		<h2>BANGIN! CONTENT: </h2>
		<div class="tab-row clearfix">
			<div class="tab">The Week</div>
			<div class="tab">This Month</div>
			<div class="tab">This Year</div>
		</div>
		<div class="content">
			<table cellspacing='0'>
				<tbody>
					<?php foreach ($trending_posts as $k => $v): ?>
					<tr>
						<td width='100'>
							<?php echo $this->Media->mediaThumb(array(
								"MediaFile"=>$v['Dailyop']['DailyopMediaItem'][0]['MediaFile'],
								"w"=>90,
								
							)); ?>
						</td>
						<td>
							<?php echo $this->Text->truncate($v['Dailyop']['name'],36); ?>
							<div>
								<small>
									<?php echo $this->Text->truncate($v['Dailyop']['sub_title'],36); ?>&nbsp;
								</small>
							</div>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<hr class='hr1' />
	<div style='max-width:300px; margin:auto;'>
		<img src="/img/v3/layout/banner300.jpg" alt="" border="0" />
	</div>
</div>