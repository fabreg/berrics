<style>

#order-status  {

	background-image:url(/img/layout/canteen/order-status-bg.jpg);
	height:668px;
	color:black;
	
}
#order-status .top-spacer {

	height:70px;

}

#order-status .order-info {

	
	width:87%;
	margin:auto;
	
}

#order-status .order-info dl {

	margin:0px;
	padding:0px;
	font-size:20px;
	color:black;
}

#order-status .order-info dt {
	
	height:30px;
	line-height:30px;
	width:158px;
	text-align:right;
}

#order-status .order-info dd {

	height:30px;
	line-height:30px;
	margin-top:-30px;
	margin-left:180px;
	font-family:"Courier New", Courier, monospace;
	border-bottom:1px solid #333;
	text-indent:5px;
}

#order-status .order-notes {

	
	width:95%;
	margin:auto;
	margin-top:10px;
}

#order-status .order-notes table {

	width:100%;

}

#order-status .order-notes th {

	border-bottom:1px solid #333;
	color:black;
}
#order-status .order-notes td {

	padding:8px;
	font-family:"Courier New", Courier, monospace;
	font-size:16px;
	border-bottom:1px solid #333;
	
}

#order-status .order-notes td:nth-child(1) {

	font-size:14px;

}
#order-status .order-notes td:nth-child(3) {

	font-size:14px;

}
#order-status .order-notes .action {

	font-style:italic;
	
	font-family:'Times New Roman';

}

#order-status .order-notes-header {

	background-image:url(/img/layout/canteen/order-notes-header.png);
	background-position:center center;
	background-repeat:no-repeat;
	height:64px;
	
}
#order-status .question-form {

	

}

#order-status .question-form fieldset {

	width:95%;
	margin:auto;

}

#order-status .question-form legend {

	

}


</style>
<div id='order-status'>
	<div class='top-spacer'></div>
	<div class='order-info'>
		<dl>
			<dt>Order ID:</dt>
			<dd><?php echo strtoupper($order['CanteenOrder']['id']); ?></dd>
		</dl>
		<dl>
			<dt>Created:</dt>
			<dd><?php echo $this->Time->niceShort($order['CanteenOrder']['created']); ?></dd>
		</dl>
		<dl>
			<dt>Last Updated:</dt>
			<dd><?php echo $this->Time->niceShort($order['CanteenOrder']['modified']); ?></dd>
		</dl>
		<dl>
			<dt>Order Status:</dt>
			<dd><?php echo strtoupper($order['CanteenOrder']['order_status']); ?></dd>
		</dl>
		<dl>
			<dt>Warehouse Status:</dt>
			<dd><?php echo strtoupper($order['CanteenOrder']['wh_status']); ?></dd>
		</dl>
		<dl>
			<dt>Shipping Status:</dt>
			<dd><?php echo strtoupper($order['CanteenOrder']['shipping_status']); ?></dd>
		</dl>
		<dl>
			<dt>Shipping Carrier:</dt>
			<dd><?php echo strtoupper($order['CanteenOrder']['shipping_carrier']); ?></dd>
		</dl>
		<dl>
			<dt>Tracking Number:</dt>
			<dd><?php echo strtoupper($order['CanteenOrder']['shipping_tracking']); ?></dd>
		</dl>
	</div>
	<div class='order-notes-header'>
	
	</div>
	<div class='order-notes'>
		<table cellspacing='0'>
			<tr>
				<th width='1%' nowrap align='center'>Time</th>
				<th>Who</th>
				<th>Action/Note</th>
			</tr>
			<?php 
				foreach($order['CanteenOrderNote'] as $note):
					if($note['public']!=1) continue;
			?>
			<tr>
				<td width='1%' nowrap align='center'><?php echo $this->Time->niceShort($note['created']); ?></td>
				<td width='1%' nowrap align='center'><?php echo strtoupper($note['User']['first_name']." ".$note['User']['last_name']); ?></td>
				<td align='center'>
				<span class='action'><?php echo $note['action']; ?></span>:<?php echo $note['note']; ?>
				</td>
			</tr>
			<?php 
				endforeach;
			?>
		</table>
	</div>
	<div class='question-form'>
		<fieldset>
			<legend>Ask A Question</legend>
			<?php 
				echo $this->Form->create("CanteenOrderNote",array("url"=>$this->here));
				echo $this->Form->input("note");
				echo $this->Form->input("canteen_order_id",array("value"=>$order['CanteenOrder']['id'],"type"=>"hidden"));
				echo $this->Form->end("Submit Question");
			?>
		</fieldset>
		
	</div>
</div>

<?php 

pr($order);

?>
