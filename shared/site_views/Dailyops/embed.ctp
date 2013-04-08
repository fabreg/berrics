<style>

body {

	background-image:none;
	background-color: white;
}

.post-embed {

	max-width:730px;
	max-height: 500px;
}

.post-embed .post {

	border:none;

}
#report-queue-btn {

	display: none;

}
</style>
<div class='post-embed'>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>	
</div>