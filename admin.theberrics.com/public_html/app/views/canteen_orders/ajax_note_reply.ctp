<div class='index form'>
	<fieldset>
		<legend>Message</legend>
		<div>
			<div><strong>Date: </strong><?php echo $this->Time->niceShort($note['CanteenOrderNote']['created']); ?></div>
			<div><strong>Message: </strong></div>
			<div><?php echo nl2br($note['CanteenOrderNote']['message']); ?></div>
			<div style='clear:both;'></div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Reply</legend>
		<?php 
			echo $this->Form->create("CanteenOrderNote",array("url"=>$this->here,"id"=>"ajax_order_note_form"));
			echo $this->Form->input("canteen_order_id",array("value"=>$note['CanteenOrderNote']['canteen_order_id'],"type"=>"hidden"));
			echo $this->Form->input("parent_id",array("type"=>"hidden","value"=>$note['CanteenOrderNote']['id']));
			echo $this->Form->input("note_status",array("type"=>"hidden","value"=>""));
			echo $this->Form->input("note_type",array("type"=>"hidden","value"=>"answer"));
			echo $this->Form->input("message");
			echo $this->Form->input("send_email",array("type"=>"checkbox","label"=>"Send Customer Email Update?","value"=>1,"checked"=>"1"));
			echo $this->Form->end("Send Note");
		?>
	</fieldset>
	
	<div style='text-align:center; padding:10px;'><a href='javascript:CanteenOrderNote.close();' style='color:black;'> CLOSE WINDOW </a></div>
</div>