<style type='text/css'>
#gateway-report dd {

	
	font-size:16px;
	background-color:#e9e9e9;
	padding:5px;
	text-indent:10px;
}

#gateway-report dt {

	
	font-size:18px;
	font-weight:bold;
	padding:5px;
	background-color:#999;
	
	
}

#gateway-report dl {

	padding:0px;
	margin:0px;
	
}

</style>
<?php 

$total_charge = 0;
$total_refund = 0;

?>
<div id='gateway-report'>
	<h2><?php echo $account['GatewayAccount']['name']; ?> (<?php echo $account['GatewayAccount']['currency_id']; ?>)</h2>
	<div style='font-style:italic; padding:5px;'>
	Range: <?php echo $this->data['GatewayAccount']['date_start']; ?> / <?php echo $this->data['GatewayAccount']['date_end']; ?>
	</div>
	<div style='float:right; width:47%;'>
		<dl>
			<?php foreach($report as $r): 
				switch(strtoupper($r['GatewayTransaction']['method'])) {
					
					case "CAPTURE":
						$total_charge += $r[0]['total'];
					break;
					case "CHARGE":
						$total_charge += $r[0]['total'];
					break;
					case "REFUND":
						$total_refund += $r[0]['total'];
					break;
					
				}
			?>
			<dt><?php echo strtoupper($r['GatewayTransaction']['method']); ?> (<?php echo $r[0]['count']; ?>)</dt>
			<dd><?php echo number_format($r[0]['total'],2); ?></dd>
			<?php endforeach; ?>
		</dl>
	</div>
	<div style='float:left; width:47%;'>
		<dl>
			<dt>
			Total In:
			</dt>
			<dd><?php echo number_format($total_charge,2); ?></dd>
			<dt>Total Out:</dt>
			<dd><?php echo number_format($total_refund,2); ?></dd>
			<dt>Total Flow:</dt>
			<dd><?php echo number_format(($total_charge-$total_refund),2); ?></dd>
		</dl>
	</div>
	<div style='clear:both;'></div>

</div>
<?php 

pr($report_count);

?>