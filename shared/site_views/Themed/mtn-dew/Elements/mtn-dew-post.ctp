<style>
	#post {

		width:728px;
		margin:auto;

	}
	#post .post .post-top h1 a,
	#post .post .post-top h2 a {

		color:#fff;

	}
	#post .post {

		background-color:#000;
		padding:5px;
		border:1px solid #9dcc59;
	}

	#post .post .text-content p {

		color:#fff;

	}
</style>
<div id="post">
 	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
</div>