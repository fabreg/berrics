<?php

	$countries = Arr::countries();

?>

<div class='index'>
	<h2>Monthly Country Drill-Down</h2>
	<div>
		<div style='float:right; width:25%;'>
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
								<div>
									<label>Date: </label>
								<?php echo $this->Form->month("report_month",NULL,array("empty"=>false)); ?>
								<?php echo $this->Form->year("report_year",2011,2015,NULL,array("empty"=>false)); ?>
								</div>
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
								
									echo $this->Form->input("country_code",array("options"=>$countries));
								
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
					<th>Region</th>
					<th>PageViews</th>
					<th>Uniques</th>
					<th>Berra Uniques</th>
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
						
							echo number_format($row[0]['total']);
						
						?>
					</td>
					<td>
						<?php 
							
							echo number_format($row[0]['uniques']);
						
						?>
					</td>
					<td>
						<?php 
						
							echo number_format($row[0]['berra']); 
						
						?>
					
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


