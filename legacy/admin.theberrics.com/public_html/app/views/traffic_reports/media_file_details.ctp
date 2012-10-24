<?php 

$total = 0;

foreach($report as $r) $total += $r[0]['total'];


$c = Arr::countries();


$this->set("title_for_layout","Video: ".$media_file['MediaFile']['name']." | [".$this->params['named']['date_start']."] - [".$this->params['named']['date_end']."]");

?>
<script type='text/javascript'>
function printSelection(html,title){

	  var content=html
	  var pwin=window.open('','print_content','width=100,height=100');

	  pwin.document.open();
	  pwin.document.write('<html><head><title>'+title+'</title><link href="/css/main.css" type="text/css" rel="stylesheet" /></head><body onload="window.print()" style="background-color:white;"><div class="index">'+content+'</div></body></html>');

	  pwin.document.close();
	 
 	  setTimeout(function(){pwin.close();},1000);

}

$(document).ready(function() { 

		$("#print-button").click(function() { 

			printSelection($("#report-content").html(),$("title").html());

		});
	
});
</script>
<div class='index form'>
	
	<div style='float:left; width:70%;' id='report-content'>
		<div style='padding:15px; font-size:18px;  padding-left:0px;'>
		Video: <span style='font-size:14px;'><?php foreach($media_file as $m) echo $m['MediaFile']['name'].", "; ?></span> <br /> 
		Date Start: <?php echo $this->params['named']['date_start']; ?> <br /> 
		Date End: <?php echo $this->params['named']['date_end']; ?><br />
		<span style='font-style:italic;'>Total: </span><?php echo number_format($total); ?>
	</div>
	
		<table cellspacing='0'>
			<tr>
				<th>Country</th>
				<th>Views</th>
			</tr>
			<?php 
				foreach($report as $v):
			?>
			<tr>
				<td><?php echo $c[$v['DimLocation']['country_code']]; ?></td>
				<td><?php echo number_format($v[0]['total']); ?></td>
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
					<?php echo $this->Form->input("media_file_id",array("value"=>$this->params['named']['media_file_id'],"type"=>"text")); ?>
				</td>
			</tr>
		</table>
		<div class='submit'>
			<input type='button' value='Print' id='print-button' />
		</div>
		<?php 
			echo $this->Form->end("Run Filters");
		?>
		
	</div>
	<div style='clear:both;'></div>
</div>