<?php 

$TrendingPost = ClassRegistry::init("TrendingPost");

$trending_posts = $TrendingPost->currentTrending('weekly');

$trending_news = $TrendingPost->currentTrending('featured-news');
//die(pr($trending_news));
?>
<div id="standard-right-column" style='clearfix'>
	<div id='batb6-feed'>
		<div style="text-align:center;">
			<img src="/img/v3/layout/loader-clear.gif" alt="">
		</div>
	</div>
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
			<?php echo $this->element("dailyops/post-table/table",array("posts"=>$trending_posts)) ?>
		</div>
	</div>
	<hr class='hr1' />
	<?php echo $this->element("banners/300x250") ?>
	<div id="trending-news">
		<h2>LATEST NEWS:</h2>
		<div class="content">
			<?php echo $this->element("dailyops/post-table/table",array("posts"=>$trending_news)); ?>
		</div>
	</div>
	<hr class='hr1' />
	<?php if ($this->theme == "mtn-dew" && $this->request->params['controller'] != "dailyops"): ?>
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
	<?php if (time()>strtotime("2013-04-06") || preg_match("/(admin|web2vm)/i",php_uname('n'))): ?>
	<div id="mtn-dew-spec-link">
		<a href="/mtn-dew">
			<img src="/img/v3/layout/mtn-dew-spec-ops-link.jpg" alt="">
		</a>
	</div>
	<?php endif ?>
</div>