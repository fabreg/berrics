<?php 

	$lazy = (isset($lazy)) ? $lazy:true;

	switch($dop['Dailyop']['post_template']) {
		case "large":
			echo $this->element("dailyops/posts/featured/post",array("post"=>$dop,"lazy"=>$lazy));
		break;
		case "slim":
			echo $this->element("dailyops/posts/slim/post",array("post"=>$dop,"lazy"=>$lazy));
		break;
		case "news":
			echo $this->element("dailyops/posts/news/post",array("post"=>$dop,"lazy"=>$lazy));
		break;
		case "news-large":
			echo $this->element("dailyops/posts/news-large/post",array("post"=>$dop,"lazy"=>$lazy));
		break;
		case "interrogation":
			echo $this->element("dailyops/posts/interrogation/post",array("post"=>$dop,"lazy"=>$lazy));
		break;
		case 'legacy':
		default:
			echo $this->element("dailyops/posts/legacy/post-bit",array("dop"=>$dop,"lazy"=>$lazy));
		break;

	}	

?>