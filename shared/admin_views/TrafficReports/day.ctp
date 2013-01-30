<?php 

$country = Arr::reportCountries();

$pv_total = 0;
$unq_total = 0;

?>
<style>

#traffic {

	width:95%;
	margin:auto;

}

#traffic .left {

	width:48%;
	float:left;

}

#traffic .right {

	width:48%;
	float:right;

}


</style>
<script>

$(document).ready(function() { 

	$("#FiltersReportDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
});

</script>
<div class='index'>
	<h2>Report By Day</h2>
	
		<div>
			<div style='width:25%; float:right;'>
				<div class='form' style='width:100%; margin:0px; padding:0px;'>
				<?php 
				
					echo $this->Form->create("Filters",array("url"=>$this->request->here));
				
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
					
					</table>
				<?php 
					
					echo $this->Form->end("Run Filters");
				
				?>
			</div>
				
			</div>
			<div style='width:74%; float:left;'>
			<div id='traffic'>
				<div class='left'>
				
					<table cellspacing='0'>
						<tr>
							<th>
								Hour
							</th>
							<th>
								Page Views
							</th>
							<th>
								Uniques
							</th>
						
						</tr>
						<?php 
						
							foreach($hourly_pv as $row):
						
						?>
						<tr>
							<td>
								<?php 
								
									echo $row['DimDate']['report_hour'];
								
								?>
							</td>
							<td>
								<?php 
									$pv_total += $row[0]['total'];
									echo number_format($row[0]['total']); 
									
								?>
							</td>
							<td>
								<?php 
									$unq_total += $row[0]['uniques'];
									echo number_format($row[0]['uniques']); 
									
								?>
							</td>
						
						</tr>
						<?php 
						
							endforeach;	
						
						?>
										<tr style='background-color:green; font-weight:bold; color:white;'>
							<td>Total:</td>
							<td><?php echo number_format($pv_total); ?></td>
							<td><?php echo number_format($unq_total); ?></td>
						</tr>
					</table>
				</div>
				<div class='right'>
					
					<table cellspacing='0'>
						<tr>
							<th>
								Country
							</th>
							<th>
								PageViews
							</th>
							<th>
								Unqiues
							</th>
							<th>
								Berra Uniques
							</th>
						</tr>
						<?php 
							foreach($country_pv as $row):
						?>
						<tr>
							<td>
								<?php 
								
									if(is_null($row['DimLocation']['country_code'])) {
										
										echo "Unkown";
										
									} else {
										
										$params = array(
										
											"controller"=>"traffic_reports",
											"action"=>"country_by_day",	
											$this->request->data['Filters']['report_date'],
											$row['DimLocation']['country_code']
										);
										
										if(Set::check($this->request->data,"Filters.dim_domain_id")) {
											
											$params['dim_domain_id'] = $this->request->data['Filters']['dim_domain_id'];
											
										}
										
										echo $this->Admin->link($country[$row['DimLocation']['country_code']],$params);
										
									}
								
								?>
							</td>
							<td>
								<?php echo number_format($row[0]['total']); ?>
							</td>
							<td>
								<?php echo number_format($row[0]['uniques']); ?>
							</td>
								<td>
								<?php echo number_format($row[0]['berra_uniques']); ?>
							</td>
						</tr>
						<?php 
						
							endforeach;
						?>
		
					</table>
				</div>
				<div style='clear:both;'></div>
			</div>
			</div>
			<div style='clear:both;'></div>
		</div>
	

	


</div>