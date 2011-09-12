<?php 

$this->Html->script(array("commander/view"),array("inline"=>false));

//temp hack to make the jimmy theme come up

if($viewing['Dailyop']['id'] == 3112) {
	
	$this->Html->css("/theme/battle-commander-carlin/css/layout_override.css","stylesheet",array("inline"=>false));
	
}

#battle-commander
//set the title
$title_for_layout = $viewing['Dailyop']['name'];



//get the meta keywords for the post
$meta_k = array();

foreach($viewing['Tag'] as $v) $meta_k[] = $v['name'];

$meta_k = implode(",",$meta_k);

$this->set(compact("title_for_layout","meta_k"));

$bg_img = "http://img.theberrics.com/images/".$viewing['DailyopMediaItem'][1]['MediaFile']['file'];

?>
<style>
#battle-commander .d-post-bit {

	background-image:url(<?php echo $bg_img; ?>);

}
</style>
<div id='battle-commander'>
	<?php 
	
		echo $this->element("dailyops/post-bit",array("dop"=>$viewing));
			
	?>
</div>

<div id='thumb-menu-header'>

</div>
<div id='commander-thumb-menu'>
	<?php 
	
		foreach($posts as $post):
	
	
	?>
	
	<div class='post-thumb-div'>
		<div class='post-thumb-over'></div>
		<a href='/<?php echo $post['DailyopSection']['uri']; ?>/<?php echo $post['Dailyop']['uri']; ?>'>
			<img src='http://img.theberrics.com/images/<?php echo $post['DailyopMediaItem'][2]['MediaFile']['file']; ?>' border='0' />
		</a>
	</div>
	<?php 
	
	
		endforeach;
	
	?>
	<div style='clear:both;'></div>
</div>
