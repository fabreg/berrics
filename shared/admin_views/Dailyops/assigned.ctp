<style>

.post-div {

	width:31%;
	float:left;
	margin:.5%;
}

@media (min-width: 1200px) {




}
 
/* Portrait tablet to landscape and desktop */
@media (min-width: 768px) and (max-width: 979px) { 

	.post-div {
	
		width:45.9%;
	
	}

}
 
/* Landscape phone to portrait tablet */
@media (max-width: 767px) {  

	.post-div {
	
		width:44.9%;
	
	}

}
 
/* Landscape phones and down */
@media (max-width: 480px) { 

	.post-div {
	
		width:98.9%;
	
	}

}
</style>
<div class='page-header'>
	<h1>
		Assigned Posts <small>(<?php echo count($posts); ?>)</small>
	</h1>
</div>
<div>

</div>
<div class='row-fluid'>

<?php foreach($posts as $post): ?>
<div class='well well-small post-div'>
<?php echo $this->element("dailyops/post",array("post"=>$post)); ?>
</div>
<?php endforeach; ?>

</div>
<?php 
print_r($posts);
?>