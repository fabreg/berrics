<script>

$(document).ready(function() { 

	$( "#ArticlePubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#ArticlePubTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});

	
});

</script>
<div class='form'>
	<fieldset>
		<legend>Create New Article</legend>
		<?php 
		
			echo $this->Form->create("Article",array("url"=>$this->request->here));
			echo $this->Form->input("active");
			echo $this->Form->input("title");
			echo $this->Form->input("pub_date",array("type"=>"text","label"=>"Publish Date","value"=>date("Y-m-d",strtotime("+20 days"))));
			echo $this->Form->input("pub_time",array("type"=>"text","label"=>"Publish Time","value"=>"0:00"));
			echo $this->Form->input("article_type_id");
			echo $this->Form->input("AberricaCategory",array("options"=>$aberricaCategories,"multiple"=>true,"label"=>"Aberrica Category"));
			echo $this->Form->input("user_id",array("value"=>$this->Session->read("Auth.User.id"),"type"=>"hidden"));
			echo $this->Form->end("Create New Article");
			
		?>
	</fieldset>
</div>