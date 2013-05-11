<?php 

//$this->Html->script(array("commander/view"),array("inline"=>false));

//check to see if there is a theme override and manually check for the CSS
if(!empty($viewing['Dailyop']['theme_override'])) {
	
	//$this->Html->css("/theme/{$viewing['Dailyop']['theme_override']}/css/layout_override.css","stylesheet",array("inline"=>false));
	
}


#battle-commander
//set the title
$title_for_layout = $viewing['Dailyop']['name'];



//get the meta keywords for the post
$meta_k = array();

foreach($viewing['Tag'] as $v) $meta_k[] = $v['name'];

$meta_k = implode(",",$meta_k);

$this->set(compact("title_for_layout","meta_k"));


?>


<div id='commander-view' class='commander-view <?php echo $this->request->params['section']; ?>'>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $this->element("banners/728") ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
				<?php 
	
					echo $this->element("dailyops/post-bit",array("dop"=>$viewing,"lazy"=>false));
						
				?>
		</div>
	</div>

	<?php foreach ($posts as $year => $posts): ?>
	<div class="posts-menu clearfix">
		<h3><?php echo $year ?> <?php echo strtoupper(Inflector::pluralize($viewing['DailyopSection']['name'])) ?></h3>
		<?php 
			foreach ($posts as $k => $post): 
			$img = $post['DailyopMediaItem'][2]['MediaFile'];
			$url = $this->Berrics->dailyopsPostUrl($post);
		?>
			<div class='menu-item'>
				<a href="<?php echo $url; ?>">
					<?php if(!empty($img)): ?>
						<img src="http://img.theberrics.com/images/<?php echo $img['file']; ?>" alt="" />
					<?php else: ?>
						<?php echo $post['Dailyop']['name']; ?> - <?php echo $post['Dailyop']['sub_title']; ?>
					<?php endif ?>
				</a>
			</div>
			
		<?php endforeach ?>
	</div>
	<?php endforeach ?>

</div>
