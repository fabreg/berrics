<script>
$(document).ready(function() { 



	
});
</script>
<style>

#super-report {

	padding:5px;
	font-family:'Arial';
}

#super-report .header {


	font-size:36px;
	font-weight:bold;
	padding:8px;
}

#super-report .date-range {

	font-size:18px;
	padding:10px;
}

.data-table {

	width:100%;
	border:1px solid #999;
	border-bottom:none;
	border-left:none;
}

.data-table td {

	padding:5px;
	font-size:18px;
	text-align:center;
	border:1px solid #999;
	border-top:none;
	border-right:none;
	
	
}

.data-table th {

	font-style:italic;
	text-align:Center;
	font-weight:bold;
	padding:5px;
	font-size:22px;
	background-color:#e9e9e9;
	border:1px solid #999;
	border-top:none;
	border-right:none;
	
}

.totals-table {

	border:1px solid #fff;
	border-bottom:none;
	border-right:none;
	font-size:18px;
	color:white;
	background-color:black;
	margin-bottom:15px;
}

.totals-table th {

	border:1px solid #fff;
	border-left:none;
	border-top:none;
	padding:10px;
	font-weight:bold;
}

.totals-table td {

	border:1px solid #fff;
	border-left:none;
	border-top:none;
	padding:10px;
	text-align:right;

}


.notes {

	padding:10px;

}


</style>
<?php 

$data = $this->Dfp->formatCsvReport($csv,$report['DfpReport']['serialized_filters']);


//die(pr($data));

$gt = array();

?>
<div id='super-report'>
	<div class='header'>
		<?php echo $report['DfpReport']['name']; ?>
	</div>
	<div class='notes'>
		<p>
			<?php echo $report['DfpReport']['notes']; ?>
		</p>
	</div>
	<div class='date-range'>
		Range: <?php echo date("F jS Y",strtotime($report['DfpReport']['date_start'])); ?> - <?php echo date("F jS Y",strtotime($report['DfpReport']['date_end'])); ?> 
	</div>
	<div class='totals'>
		<table cellspacing='0' class='totals-table'>
			<tr>
					<th>
						-
					</th>
					<th>
						Impressions
					</th>
					<th>
						Clicks
					</th>
					<th>
						Click-Thru-Rate
					</th>
				</tr>
			<?php 
				foreach($data['Totals'] as $k=>$t):
					$gt['impressions'] += $t['impressions'];
					$gt['clicks'] += $t['clicks'];
			?>
				<tr>
					<td>
						<?php 
						
						switch($k) {
							
							case "ImageCreative":
								echo "Banner";
							break;
							case "FlashCreative":
								echo "Flash Banner";
							break;
							case "VideoCommercial":
								echo "Pre-Roll";
							break;
							default:
								echo $r['Creative']['CreativeType'];
							break;
							
						}
						
						?>
					</td>
					<td>
						<?php echo number_format($t['impressions']); ?>
					</td>
					<td>
						<?php echo number_format($t['clicks']); ?>
					</td>
					<td>
						<?php echo number_format(($t['clicks']/$t['impressions'])*100,2); ?>%
					</td>
				</tr>
			<?php 
				endforeach;
			?>
				<tr>
					<td><strong>Total:</strong></td>
					<td><?php echo number_format($gt['impressions']); ?></td>
					<td><?php echo number_format($gt['clicks']); ?></td>
					<td> <?php echo number_format(($gt['clicks']/$gt['impressions'])*100,2); ?>%</td>
				</tr>
		</table>
	</div>
	<table cellspacing='0' class='data-table'>
		<tr>
			<th>Creative</th>
			<th>Type</th>
			<th>Size</th>
			<th>Impressions</th>
			<th>Clicks</th>
			<th>Click-Thru-Rate</th>
		</tr>
		<?php 
		
			foreach($data as $k=>$r): if(!isset($r[2])) continue;
		
		?>
		<tr>
			<td width='1%'>
			
			<div><?php echo $r[2]; ?></div>
			<div>
				<?php 
				
				
					switch($r['Creative']['CreativeType']) {
						
						case "ImageCreative":
							switch($r[1]) {
								
								case "160 x 600":
									$opt = array("width"=>"40","height"=>200);
								break;
								case "300 x 250":
									$opt = array("width"=>"150","height"=>125);
								break;
								case "728 x 90":
									$opt = array("width"=>364,"height"=>45);
								break;
								case "624 x 90":
									$opt = array("width"=>312,"height"=>45);
								break;
								default:
									$opt = array();
								break;
							}
							echo $this->Html->image($r['Creative']['imageUrl'],$opt);
						break;
						case "FlashCreative":
							echo $this->Html->tag("iframe","",array(
								
								"width"=>$r['Creative']['size']['width'],
								"height"=>$r['Creative']['size']['height'],
								"src"=>$r['Creative']['previewUrl'],
								"frameborder"=>"0",
								"scrolling"=>"0"
								
							));
						break;
						case "VideoCommercial":
							//echo  "Video Commercial";
						break;	
					
					}
				
				
				?>
			</div>
			</td>
			<td><?php  
						switch($r['Creative']['CreativeType']) {
							
							case "ImageCreative":
								echo "Banner";
							break;
							case "FlashCreative":
								echo "Flash Banner";
							break;
							case "VideoCommercial":
								echo "Pre-Roll";
							break;
							default:
								echo $r['Creative']['CreativeType'];
							break;
							
						}
						
				?></td>
			<td><?php 
			
				if($r['named']['Creative Size'] == "8 x 8") {
					
					echo "-";
					
				} else {
					
					echo $r[1]; 
					
				}
			
			
			?></td>
			<td><?php echo $r['named']['Impressions']; ?></td>
			<td><?php echo $r['named']['Clicks']; ?></td>
			<td><?php echo $r['named']['CTR']; ?></td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>
	<?php 
	
		//pr($report);
	
	?>
	<?php 
	
		
		
		//pr($data);
	
	?>
</div>