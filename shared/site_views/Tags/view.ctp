<style>

#tags .heading {

border-bottom:1px solid #666;

}

</style>
<?php 

$title_for_layout = "Tag: ".strtoupper($tag['Tag']['name']);

$this->set(compact("title_for_layout"));

?>
<div id='tags' class='results'>
	<div class='heading'>
		<h1><?php echo strtoupper($tag['Tag']['name']); ?></h1>
	</div>
	<?php echo $this->element("results/posts-div",compact("posts")); ?>
</div>