<?php 

if(isset($post)) {

	$title_for_layout = "The Berrics - ".$post['Dailyop']['name']." - ".$post['Dailyop']['sub_title'];

} else {

	$title_for_layout = "The Berrics - BONES NEW GROUND";

}

$this->set(compact("title_for_layout"));

?>
<div id="bones-new-ground">
	<div class="row-fluid header">
		<div class="span3">
			<img src="/theme/bones-new-ground/img/bones-logo.png" alt="" />
		</div>
		<div class="span6">
			<img src="/theme/bones-new-ground/img/new-ground-logo.png" alt="" />
		</div>
		<div class="span3">
			<img src="/theme/bones-new-ground/img/berrics-logo.png" alt="" />
		</div>
	</div>
	<div class="post-view">
		<?php if (isset($post)): ?>
			  	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)) ?>
		<?php endif; ?>
	</div>
	<div class="chapters clearfix">
		<?php foreach ($title['Dailyop'] as $k => $v): ?>
			<div class="chapter-thumb">
				<a href="/bones-new-ground/<?php echo $v['uri']; ?>?autoplay">
					<img src="http://img.theberrics.com/images/<?php echo $v['DailyopMediaItem'][1]['MediaFile']['file']; ?>" alt="" border='0' />
				</a>
			</div>
		<?php endforeach ?>
	</div>
</div>