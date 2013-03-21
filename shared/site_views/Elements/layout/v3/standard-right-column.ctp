<?php 

$TrendingPost = ClassRegistry::init("TrendingPost");

$trending_posts = $TrendingPost->currentTrending('weekly');

$trending_news = $TrendingPost->currentTrending('featured-news');
//die(pr($trending_news));
?>
<div id="standard-right-column" style='clearfix'>
	<?php echo $this->element("layout/v3/standard-right-column-top"); ?>
	<!--Trending Content!-->
	<div id="trending-content">
		<h2>TRENDING VIDEOS</h2>
		<div class="tab-row clearfix">
			<div class="tab active" data-section='weekly'>The Week</div>
			<div class="tab" data-section='monthly'>This Month</div>
			<div class="tab" data-section='yearly'>This Year</div>
		</div>
		<div class='content'>
			<table cellspacing='0'>
				<tbody class="content">
					<?php foreach ($trending_posts as $k => $v): ?>
					<?php echo $this->element("layout/v3/trending-tr",array("post"=>$v)) ?>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<hr class='hr1' />
	<?php echo $this->element("banners/300x250") ?>
	<div id="trending-news">
		<h2>LATEST NEWS:</h2>
		<div class="content">
			<table cellspacing="0">
				<tbody class="content">
					<?php 
						foreach ($trending_news as $k => $v): 
						$link = "/".$v['DailyopSection']['uri']."/".$v['Dailyop']['uri'];
						$t = $v['DailyopTextItem'][0];
					?>
					<tr>
						<td width='100'>
							<a href='<?php echo $link; ?>'>
							<?php 
								$media_file = $v['DailyopTextItem'][0]['MediaFile'];
								echo $this->Media->mediaThumb(array(
									"MediaFile"=>$media_file,
									"w"=>90
								));
							?>
							</a>
						</td>
						<td>
							<a href='<?php echo $link; ?>'><?php echo $this->Text->truncate($v['Dailyop']['name'],26); ?></a>
							<div>
								<small>
									<a href='<?php echo $link; ?>'><?php echo $this->Text->truncate($v['Dailyop']['sub_title'],54); ?></a>
								</small>
							</div>
							<p>
								<a href='<?php echo $link; ?>'><?php echo $this->Text->truncate($t['text_content'],60); ?></a>
							</p>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
	<hr class='hr1' />
	<?php if ($this->theme == "mtn-dew"): ?>
	<?php echo $this->element("layout/v3/standard-right-column-bottom"); ?>
	<?php else: ?>
	<?php echo $this->element("banners/300x250",array("unit"=>"dopsv3_300b")) ?>
	<?php endif; ?>
	<hr class='hr1' />
	
	<div id="calendar-widget">
		<?php 

			echo $this->element("dailyops/calendar-widget"); 

		?>
	</div>
</div>