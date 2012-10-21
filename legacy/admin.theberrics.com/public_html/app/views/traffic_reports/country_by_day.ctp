<?php


$countries = Arr::countries();
$total_pv = 0;
$total_un = 0;
$total_b = 0;

?>
<script>

$(document).ready(function() { 

	$("#FiltersReportDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
});

</script>
<div class='index'>
	<h2>Country Day Overview</h2>
	<div>
		<div style='float:right; width:25%;'>
			<div class='form' style='width:100%; margin:0px; padding:0px;'>
				<?php 
				
					echo $this->Form->create("Filters",array("url"=>$this->here));
				
				?>
					<table cellspacing='0'>
						<tr>
							<th style='text-align:left;'>Filters</th>
						</tr>
						<tr>
							<td>
								<?php echo $this->Form->input("report_date"); ?>
							</td>
						<tr>
							<td>
								<?php 
								
									echo $this->Form->input("dim_domain_id",array("type"=>"select","options"=>$domainList,"empty"=>"* All Domains","label"=>"Domain Name: "));
								
								?>
							</td>
						</tr>
						<tr>
							<td>
								<?php 
								
									echo $this->Form->input("country_code",array("options"=>$countries,"empty"=>"* All Countries"));
								
								?>
							</td>
						</tr>
					</table>
				<?php 
					
					echo $this->Form->end("Run Filters");
				
				?>
			</div>
		</div>
		<div style='float:left; width:74%;'>
			<table cellspacing='0'>
				<tr>
					<th>
						Region
					</th>
					<th>
						PageViews
					</th>
					<th>
						Uniques
					</th>
					<th>
						Berra Uniques
					</th>
				</tr>
				<?php 
				
					foreach($report as $row):	
				
				?>
				<tr>
					<td>
						<?php 
						
							if(is_null($row['DimLocation']['region_name'])) {
								
								echo "Unknown Location";
								
							} else {
								
								echo $row['DimLocation']['region_name'];
								
							}
						
						?>
					</td>
					<td>
						<?php 
						
							$total_pv += $row[0]['total'];
							
							echo number_format($row[0]['total']);
						
						?>
					</td>
					<td>
						<?php 
						
							$total_un += $row[0]['uniques'];
							
							echo number_format($row[0]['uniques']);
						
						?>
					</td>
					<td>
						<?php 
						
							$total_b += $row[0]['berra'];
							
							echo number_format($row[0]['berra']);
						
						
						?>
					</td>
				</tr>
				<?php 
				
					endforeach;
				
				?>
				<tr style='background-color:green; color:white;'>
					<td align='right'><strong>Totals:</strong></td>
					<td>
						<?php echo number_format($total_pv); ?>
					</td>
					<td>
						<?php echo number_format($total_un); ?>
					</td>
					<td>
						<?php echo number_format($total_b); ?>
					</td>
				</tr>
			</table>
		</div>
		<div style='clear:both;'></div>
	</div>

</div>