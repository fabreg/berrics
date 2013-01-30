<div class='index form'>
	<div>
		<h2>Media Monthly Overview</h2>
	<div>
	<div style='float:left; width:70%;'>
		<table cellspacing='0'>
			<tr>
				<th>Date</th>
				<th>Views</th>
				<th> - </th>
			</tr>
			<?php 
				foreach($report as $r):
			?>
			<tr>
				<td>
					<a href='/traffic_reports/media_daily/<?php echo date("Y-m-d",strtotime($r['DimDate']['report_date'])); ?>'><?php echo date("Y-m-d",strtotime($r['DimDate']['report_date'])); ?></a>
				</td>
				<td>
					<?php 
						
						$total += $r[0]['total'];	
					
						echo number_format($r[0]['total']); 
						
					?>
				</td>
				<td class='actions'>
					<a href='http://theberrics.com/<?php echo date("Y/m/d",strtotime($r['DimDate']['report_date'])); ?>' target='_blank'>View DailyOps</a> 
				</td>
			</tr>
			<?php 
				endforeach;
			?>
			<tr>
				
				<td align='right'> Total </td>
				<td><?php echo number_format($total); ?></td>
				<td> - </td>
			</tr>
		</table>
		<?php 
		
			pr($report);
		
		?>
	</div>
	<div style='float:right; width:29%;'>
		<fieldset>
			<legend>Filters</legend>
			<?php 
		
			echo $this->Form->create("MediaViewFilters",array("url"=>$this->request->here));
			echo $this->Form->input("date_start",array("value"=>$this->request->params['named']['date_start']));
			echo $this->Form->input("date_end",array("value"=>$this->request->params['named']['date_end']));
			echo $this->Form->end("Run Report");
		?>
		</fieldset>
		
	</div>
	<div style='clear:both;'></div>
</div>