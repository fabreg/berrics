<div class='sls-video-post'>
	<?php if($this->params['isAjax']): ?>
	<div style='height:85px;'></div>
	<?php endif; ?>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	<?php if($this->params['isAjax']): ?>
	<script>FB.XFBML.parse();</script>
	<div>
	<a href='javascript:SlsVideo.closeVideo();'> [x] Close Video [x]</a>
	</div>
	<?php endif; ?>
</div>