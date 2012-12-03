<?php 

	$lazy = (isset($lazy)) ? $lazy:true;

	switch($dop['Dailyop']['post_template']) {
		case "large":
			echo $this->element("dailyops/posts/featured/post",array("post"=>$dop,"lazy"=>$lazy));
		break;
		case "news":
			echo $this->element("dailyops/posts/news/post",array("post"=>$dop,"lazy"=>$lazy));
		break;
		case 'legacy':
		default:
			echo $this->element("dailyops/posts/legacy/post-bit",array("dop"=>$dop,"lazy"=>$lazy));
		break;

	}	

?>