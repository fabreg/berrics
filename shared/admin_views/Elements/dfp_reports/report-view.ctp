<?php

$shit = $this->Dfp->formatCsvReport($csv,$report['DfpReport']['serialized_filters']);

die(pr($shit));

$orders = unserialize($report['DfpReport']['serialized_filters']);
foreach($orders['order'] as $k=>$v) $orders[$k] = json_decode($v);
pr($orders);


$rows = explode("\n",$csv);
$header = $rows[0];
pr($header);

?>
<script src='/js/jquery.tablesorter.min.js'></script>
<script>
$(document).ready(function() { 

	jQuery.tablesorter.addParser({
		  id: "commaDigit",
		  is: function(s, table) {
		    var c = table.config;
		    return jQuery.tablesorter.isDigit(s.replace(/,/g, ""), c);
		  },
		  format: function(s) {
		    return jQuery.tablesorter.formatFloat(s.replace(/,/g, ""));
		  },
		  type: "numeric"
		});
	$("#report-table").tablesorter({

			headers:{

				1:{
					sorter:'commaDigit'
				},
				2:{
					sorter:'commaDigit'
				}
		
			}
		
		});

	
});
</script>
<style>
.report {

}
.report table {

	border:1px solid #999;
	border-top:none;
	border-right:none;
}

.report table td {

	border:1px solid #999;
	border-bottom:none;
	border-left:none;
	padding:3px;
	font-size:16px;
	text-align:center;
}
.report th {

	text-align:center;
	font-weight:bold;
	background-color:#e9e9e9;
	font-size:16px;
	height:24px;
}

.cr-title {

	

}
.cr-size {

	

}
.order-title {


}
</style>
<div class='report'>
<table cellspacing='0' cellpadding='0' width='100%' border='0' id='report-table'>
	<thead>
	<tr>
		<th>Creative</th>
		<th>Impressions</th>
		<th>Clicks</th>
		<th>CTR</th>
	</tr>
	</thead>
	<tbody>
<?php 
	
	foreach($rows as $row):
		$row = str_getcsv($row);
		if(!array_key_exists($row[3],$orders)) continue;
			try{ 
				
				$cr = DFPAPI::instance()->getCreative($row[4]);
			
				
				
			}
			
			catch(Exception $e) {
				
				$cr = false;
			}
			
			//creative types
		 
				$cell = false;
				$tr  = false;
				if($cr) {
					
					//pr($cr);
					switch($cr['CreativeType']) {
						
						case 'ImageCreative':
							
							$opt = array();
							
							if($cr['size']['width'] == 728) {
								
								$opt['width'] = 364;
								$opt['height'] = 45;
								
							} else if($cr['size']['height'] == 600) {
								
								$opt['width'] = 80;
								$opt['height'] = 300;
							} 
							
							$cell = $this->Html->image($cr['imageUrl'],$opt);
							
						break;
						
						case 'FlashCreative':
							
							$cell = $this->Html->tag("iframe","",array(
								
								"width"=>$cr['size']['width'],
								"height"=>$cr['size']['height'],
								"src"=>$cr['previewUrl'],
								"frameborder"=>"0",
								"scrolling"=>"0"
								
							));
							//pr($cr);
						break;
						default:
							//pr($row);
							$cr = array(
								"CreativeType"=>"VideoCommercial"
							);
						break;
					}
					
				}
			
		
			
?>
	<tr>
		<td width='450' align='center'>
				<div class='cr-title'>
					<?php echo $row[2]; ?>
				</div>

				<?php echo $cell; ?>
				<div class='cr-size'>
					<?php echo $cr['CreativeType']; ?>
					<?php 
						if(isset($cr['size'])):
					?>
					(W:<?php echo $cr['size']['width']; ?> H:<?php echo $cr['size']['height']; ?>)
					<?php 
						endif;
					?>
				</div>
					<div class='order-title'>
					Order: <?php echo $orders[$row[3]]->name; ?>
				</div>
		</td>

	
		<td><?php echo $row[8]; ?></td>
		<td><?php echo $row[7]; ?></td>
		<td><?php echo $row[9]; ?></td>
	</tr>
<?php 

	endforeach;

?>
	</tbody>
</table>
</div>