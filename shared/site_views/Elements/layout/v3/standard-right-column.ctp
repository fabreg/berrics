<?php 

$TrendingPost = ClassRegistry::init("TrendingPost");

$trending_posts = $TrendingPost->currentTrending('weekly');

?>
<div id="standard-right-column" style='clearfix'>
	<!--Trending Content!-->
	<div id="trending-content">
		<h2>BANGIN! CONTENT: </h2>
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
	<div class='banner-300'>
		<img src="/img/v3/layout/banner300.jpg" alt="" border="0" />
	</div>

	<div id="news-headlines">
		<h2>SHREDLINES:</h2>
		<hr class='hr1' />
		<div class="content">
			
		</div>
	</div>
	<hr class='hr1' />
	<div class='banner-300'>
		<img src="/img/v3/layout/banner300.jpg" alt="" border="0" />
	</div>
</div>