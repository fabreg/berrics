<div class='index form'>
	<fieldset>
		<legend>Reply</legend>
		<?php 
			echo $this->Form->create("CanteenOrderNote",array("url"=>$this->here,"id"=>"ajax_order_note_form"));
			echo $this->Form->input("parent_id",array("value"=>$note['CanteenOrderNote']['id'],"type"=>"hidden"));
			echo $this->Form->input("message");
			echo $this->Form->end("Send Note");
		?>
	</fieldset>
	
	<div style='text-align:center; padding:10px;'><a href='javascript:CanteenOrderNote.close();' style='color:black;'> CLOSE WINDOW </a></div>
</div>