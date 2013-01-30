
<?php 

$total_pv = 0;
$total_unq = 0;
$total_bunq = 0;


$countries = Arr::countries();

?>

<script>

var params = {};

<?php 



?>

$(document).ready(function() { 


	$('form').submit(function() { 

		openReportModal();
		
		
	});
	
	
	
	
});


function openReportModal() {

	$('body').prepend("<div id='modal-satin'></div><div id='modal-wrapper'><div id='modal-content'></div></div>");

	$('#modal-wrapper').css({

		"position":"fixed",
		"z-index":5002
		
	});

	$("#modal-satin").css({
		"position":"fixed",
		"background-color":"#000000",
		"opacity":.8,
		"z-index":5001
	});

	$("#modal-content").css({

		"width":"400px",
		"height":"350px",
		"margin":"auto",
		"text-align":"center",
		"color":"white",
		"font-size":"150%"
	}).html("Loading Report");

	resizeReportModal();

	$(window).bind('resize',function() {

		resizeReportModal();

	});
	
}

function resizeReportModal() {

	var w = $(window).width();
	var h = $(window).height();
	var content_h = $("#modal-content").height();

	$('#modal-satin,#modal-wrapper').css({

		"width":w+"px",
		"height":h+"px"

	});

	$("#modal-content").css({

		"margin-top":"50px"
		
	});	
	
}




</script>
<style>



</style>
<div class='index'>
	<h2>Monthly Traffic Report</h2>
	
	<div>
		<div style='width:30%; float:right;'>
		
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
		<div style='width:69%; float:left;'>
				<table cellspacing='0'>
				<tr>
					<th width='25%'>
						Date
					</th>
					<th width='25%'>
						Page Views
					</th>
					<th width='25%'>
						Uniques
					</th>
					<th width='25%'>
						Uniques Per Hour <span style='font-style:italic; font-size:10px;'>(AKA: Berra Uniques)</span>
					</th>
				</tr>
				<?php 
					
					foreach($report as $row):
				
				?>
				<tr>
					<td>
						<?php 
					
							$date = date("m-d-Y",strtotime($row['DimDate']['report_date'])); 
							//echo $this->Admin->link($date,array("controller"=>"traffic_reports","action"=>"day",date("Y-m-d",strtotime($row['DimDate']['report_date']))));
							echo $this->Admin->monthlyReportLink(array(
								
								"date"=>date("Y-m-d",strtotime($row['DimDate']['report_date'])),
								"data"=>$this->request->data,
								"label"=>date("F d, Y",strtotime($row['DimDate']['report_date']))
							
							));
						?>
					</td>
					<td>
						<?php 
						
							$total_pv += $row[0]['page_views'];
							echo number_format($row[0]['page_views']); 
							
						?>
					</td>
					<td>
						<?php 
						
							$total_unq += $row[0]['uniques'];			
							echo number_format($row[0]['uniques']); 
							
						?>
					</td>
					<td>
						<?php 
						
							$total_bunq += $row[0]['berra_uniques'];
							echo number_format($row[0]['berra_uniques']);
						
						?>
					</td>
				</tr>
				<?php 
				
					endforeach;
				
				?>
				<tr style='background-color:green; color:white;'>
					<td><strong>Totals:</strong></td>
					<td><?php echo number_format($total_pv); ?></td>
					<td><?php echo number_format($total_unq); ?></td>
					<td><?php echo number_format($total_bunq); ?></td>
				</tr>
			</table>
		</div>
		<div style='clear:both;'></div>
	</div>
	
</div>
<?php 

pr($report);

?>