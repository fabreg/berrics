<?php
	
	if(count($paragraphs)>0) {
		
		foreach($paragraphs as $p) {
		
			echo $this->element("article_manager/paragraph",array("paragraph"=>$p));
			
		}
		
		
	} else {
		
		echo $this->Html->link("Add New Paragraph","",array("rel"=>"add-paragraph","below"=>0));
		
	}
	
	
?>
