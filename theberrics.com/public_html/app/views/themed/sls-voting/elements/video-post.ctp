<div class='sls-video-post'>
	<?php if($this->params['isAjax']): ?>
	<div style='height:85px;'></div>
	<?php endif; ?>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	<?php if($this->params['isAjax']): ?>
	<script>FB.XFBML.parse();</script>
	<div style='width:100%; text-align:center; background-color:#000;'>
		<span onclick='SlsVideo.closeVideo();' style='cursor:pointer;'> <img border='0' src='/theme/sls-voting/img/close_video.jpg' /></span>
	</div>
	<?php endif; ?>
</div>