<?php

	foreach($items as $item):

?>
	<?php 
	
		echo $this->element("article_manager/media_item",array("item"=>$item));
	
	?>
<?php 

	endforeach;

?>