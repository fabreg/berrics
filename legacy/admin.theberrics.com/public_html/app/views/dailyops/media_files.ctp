<?php

foreach($mediaFiles as $file) {
	
	echo $this->element("dailyops/media_item",array("file"=>$file));
	
}

?>