<?php 

$c = Arr::countries();

?>
<div class='index form'>
	<div>
		<h2>Media Daily Breakdown - <?php echo date("F dS Y",strtotime($this->params['pass'][0]));?></h2>
	</div>
	<div style='float:left; width:33%;'>
		<h3>Hourly</h3>
		<table cellspacing='0'>
			<tr>
				<th>Hour</th>
				<th>Views</th>
			</tr>
			<?php 
				$total = 0;
				foreach($hours as $h):
			?>
			<tr>
				<td>
					<?php echo $h['DimDate']['report_hour']; ?>
				</td>
				<td>
					<?php 
					
					$total += $h[0]['total'];
					echo number_format($h[0]['total']);
					
					?>
				</td>
			</tr>
			<?php 
				endforeach;
			?>
			<tr>
				<td align='right'>
					Total
				</td>
				<td>
					<?php echo number_format($total); ?>
				</td>
			</tr>
			<?php 
			//pr($hours);
			?>
		</table>
	</div>
	<div style='float:left; width:33%;'>
		<h3>Countries</h3>
		<table cellspacing='0'>
			<tr>
				<th>Country</th>
				<th>Views</th>
			</tr>
			<?php 
			$total = 0;
				foreach($country as $v):
			?>
			<tr>
				<td>
					<?php echo $c[$v['DimLocation']['country_code']]; ?>
				</td>
				<td>
					<?php 
					$total += $v[0]['total'];
					echo number_format($v[0]['total']);
					?>
				</td>
			</tr>
			<?php 
				endforeach;
			?>
			<tr>
				<td align='right'>
					Total
				</td>
				<td><?php echo number_format($total); ?></td>
			</tr>
		</table>
		<?php 
		//pr($country);
		?>
	</div>
		
	<div style='float:left; width:33%;'>
	
		<fieldset>
			<legend>Filters</legend>
			<div>
				<?php 
					echo $this->Form->create("MediaReportDaily",array("url"=>$this->here));
					echo $this->Form->input("report_date",array("value"=>$this->params['pass'][0]));
					echo $this->Form->end("Run Report");
				?>
			</div>
		</fieldset>
	
	</div>
	<div style='clear:both'></div>
</div>