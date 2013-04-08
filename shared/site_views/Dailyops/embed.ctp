<style>

body {

	background-image:none;
	background-color: white;
}

.post-embed .post {

	border:none;
	max-width:728px;
	max-height: 500px;
}
#report-queue-btn {

	display: none;

}
</style>
<div class='post-embed'>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>	
</div>