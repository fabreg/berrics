<div class='index form'>
	<div style='float:left; width:70%;'>
		<table cellspacing='0'>
			<tr>
				<th>Media File</th>
				<th>Total</th>
			</tr>
			<?php 
			
				foreach($report as $v):
			
			?>
			<tr>
				<td>
					<?php
						$file = Set::extract("/MediaFile[id={$v['FactMediaView']['media_file_id']}]",$media_files);
						//pr($file);
						//echo $v['FactMediaView']['media_file_id']; 
						$file_name = $file[0]['MediaFile']['name']; 	
					?>
					<a href='/traffic_reports/media_file_details/media_file_id:<?php echo $v['FactMediaView']['media_file_id']; ?>/date_start:<?php echo $this->params['named']['date_start']; ?>/date_end:<?php echo $this->params['named']['date_end']; ?>'><?php echo $file_name; ?></a>
					<br />
					<span style='font-style:italic; font-size:10px;'><?php echo date("Y-m-d",strtotime($file[0]['MediaFile']['created'])); ?></span>
				</td>
				<td>
					<?php echo number_format($v[0]['total']); ?>
				</td>
			</tr>
			<?php 
			
				endforeach;
			
			?>
		</table>
	</div>
	<div style='float:right; width:29%;'>
		<?php echo $this->Form->create("FactMediaView",array("url"=>$this->here)); ?>
		<table cellspacing='0'>
			<tr>
				<th>Filters</th>
			</tr>
			<tr>
				<td>
					<?php echo $this->Form->input("date_start",array("value"=>$this->params['named']['date_start'])); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $this->Form->input("date_end",array("value"=>$this->params['named']['date_end'])); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $this->Form->input("limit",array("value"=>$this->params['named']['limit'])); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $this->Form->input("media_file_id",array("value"=>$this->params['named']['media_file_id'],"type"=>"text")); ?>
				</td>
			</tr>
		</table>
		
		<?php 
			echo $this->Form->end("Run Filters");
		?>
	</div>
	<div style='clear:both;'></div>
</div>
<?php 

pr($report);

?>