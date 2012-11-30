<?php 

	$lazy = (isset($lazy)) ? $lazy:true;

	switch($dop['Dailyop']['post_template']) {
		case 'legacy':
		default:
			echo $this->element("dailyops/posts/legacy/post-bit",array("dop"=>$dop,"lazy"=>$lazy));
		break;

	}	

?>