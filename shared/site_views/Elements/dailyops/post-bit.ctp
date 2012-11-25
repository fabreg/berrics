<?php 

	switch($dop['Dailyop']['post_template']) {

		case 'legacy':
		default:
			echo $this->element("dailyops/posts/legacy/post-bit",array("dop"=>$dop));
		break;

	}	

?>