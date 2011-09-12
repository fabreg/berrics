<?php 

$verbs = array(

	"approved"=>"APPROVED",
	"processing"=>"PROCESSING",
	"pending"=>"PENDING"

);


$types = array(

	"wh_status"=>"Warehouse Status",
	"shipping_status"=>"Shipping Status",
	"order_status"=>"Order Status"	

);


?>
<style>
#batch-options {

	width:98%;
	margin:auto;
	margin-bottom:10px;
}

#batch-options a {
	
	padding:5px;
	padding-right:9px;
	padding-left:9px;
	font-weight:bold;
	-webkit-border-radius: 12px;
	-moz-border-radius: 12px;
	border-radius: 12px;
	background: #bfd255; /* Old browsers */
	background: -moz-linear-gradient(top, #bfd255 0%, #8eb92a 50%, #72aa00 51%, #9ecb2d 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#bfd255), color-stop(50%,#8eb92a), color-stop(51%,#72aa00), color-stop(100%,#9ecb2d)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* Opera11.10+ */
	background: -ms-linear-gradient(top, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* IE10+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bfd255', endColorstr='#9ecb2d',GradientType=0 ); /* IE6-9 */
	background: linear-gradient(top, #bfd255 0%,#8eb92a 50%,#72aa00 51%,#9ecb2d 100%); /* W3C */
	color:white;
	text-shadow: 1px 1px 1px #7a7a7a;
	filter: dropshadow(color=#7a7a7a, offx=1, offy=1);
	text-decoration:none;
	margin:10px;
	display:block;
}

#batch-options .option-div { 

	float:left;
	margin-right:10px;
	padding:10px;
}

#batch-options label {

	width:110px;
	text-align:right;
	display:block;
	float:left;
	padding-right:8px;
}

#batch-options div.input, #batch-options div.select, #batch-options div.submit {

	margin-top:2px;
	margin-bottom:2px;

}


#batch-options div.submit {

	text-align:right

}




</style>
<div class='index'>
	<h2>Canteen Batch: <?php echo $batch['CanteenBatch']['name']; ?> | User: <?php echo $batch['User']['first_name']; ?> <?php echo $batch['User']['last_name']; ?></h2>
	<div id='batch-options'>
		<fieldset>
			<legend>Batch Options</legend>
				
		<div class='option-div' style='width:290px;'>
			<table cellspacing='0'>
				<tr>
					<th>Update Order Status</th>
				</tr>
				<tr>
					<td>
					<?php 
						
						echo $this->Form->create("CanteenBatch",array("url"=>"/canteen_batches/update_status/"));
						echo $this->Form->input("id");
						echo $this->Form->input("status",array("options"=>$types));
						echo $this->Form->input("verb",array("options"=>$verbs));
						echo $this->Form->input("add_order_note",array("type"=>"checkbox","checked"=>true));
						echo $this->Form->input("make_note_public",array("type"=>"checkbox","checked"=>true));
						echo $this->Form->end("Update");
					
					?>
					</td>
				</tr>
			</table>
			
		</div>
		<div class='option-div' style='width:200px;'>
			<table cellspacing='0'>
				<tr>
					<th>Printing</th>
				</tr>
				<tr>
					<td align='center'>
						<a href='/canteen_batches/print_invoices/<?php echo $batch['CanteenBatch']['id']; ?>' target='_blank'>Print Invoices</a>
					</td>
				</tr>
			</table>
		</div>
		<div style='clear:both;'></div>
		</fieldset>
	
	</div>
	<?php 
	
		echo $this->element("canteen_orders/index-table");
		
	?>
</div>