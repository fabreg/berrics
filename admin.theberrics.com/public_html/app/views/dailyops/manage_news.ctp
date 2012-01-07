<?php 

$misc = Arr::dailyopsMiscCategories();

$weight = array();

for($i=1;$i<=100;$i++) $weight[$i] = $i;

?>
<script>

$(document).ready(function() {


	$( "#DailyopPublishDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#DailyopDisplayWeight").each(function() { 

		$(this).change(function() { 
			
			var num = $(this).attr("form_number");

			$("#form"+num).submit();
			
		});

	});
	
});

</script>
<div class='index form'>
	<h2>News</h2>
	<fieldset>
		<legend>Filter</legend>
		<?php 
		
			echo $this->Form->create("Dailyop",array("url"=>array("action"=>"search_news")));
			echo $this->Form->input("misc_category",array("options"=>$misc,"empty"=>true));
			echo $this->Form->input("publish_date",array("type"=>"text"));
			echo $this->Form->end("Filter");
		?>
	</fieldset>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("publish_date"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th><?php echo $this->Paginator->sort("User"); ?></th>
			<th><?php echo $this->Paginator->sort("misc_category"); ?></th>
			<th><?php echo $this->Paginator->sort("display_weight"); ?></th>
			<th><?php echo $this->Paginator->sort("best_of"); ?></th>
			<th>-</th>
		</tr>
		<?php 
			foreach($posts as $key=>$p):
		?>
		<tr>
			<td><?php echo $p['Dailyop']['id']; ?></td>
			<td  align='center'>
				<?php 
				
					switch($p['Dailyop']['active']) {
						
						case 1:
							echo "<span style='color:green;'>Yes</span>";
						break;
						default:
							echo "<span style='color:red;'>No</span>";
						break;
						
					}
				
				?>
			</td>
			<td><?php echo $this->Time->niceShort($p['Dailyop']['modified']); ?></td>
			<td><?php echo $this->Time->niceShort($p['Dailyop']['publish_date']); ?></td>
			<td><?php echo $p['Dailyop']['name']; ?></td>
			<td><?php echo $p['User']['first_name']; ?> <?php echo $p['User']['last_name']; ?></td>
			<td><?php echo $misc[$p['Dailyop']['misc_category']]; ?></td>
			<td align='center'><?php 
			
				echo $this->Form->create("Dailyop",array("url"=>array("action"=>"updateDisplayWeight"),"id"=>"form".$key));
				echo $this->Form->input("display_weight",array("options"=>$weight,"value"=>$p['Dailyop']['display_weight'],"label"=>false,"div"=>false,"form_number"=>$key));
				echo $this->Form->input("id",array("value"=>$p['Dailyop']['id']));
				echo $this->Form->input("postback",array("value"=>base64_encode($this->here),"type"=>"hidden"));
				echo $this->Form->submit("Go",array("div"=>false));
				echo $this->Form->end();
			
			?></td>

			<td>
				<?php 
				
					echo $this->Form->create("Dailyop",array("url"=>array("action"=>"updateBestOfWeight"),"id"=>"form".$key));
					echo $this->Form->input("best_of",array("type"=>"checkbox","checked"=>$p['Dailyop']['best_of'],"label"=>false,"div"=>false));
					echo $this->Form->input("best_of_weight",array("options"=>$weight,"label"=>false,"div"=>false,"value"=>$p['Dailyop']['best_of_weight']));
					
					echo $this->Form->input("id",array("value"=>$p['Dailyop']['id']));
					echo $this->Form->input("postback",array("value"=>base64_encode($this->here),"type"=>"hidden"));
					echo $this->Form->submit("GO",array("div"=>false));
					echo $this->Form->end();
				
				?>
			</td>
			<td class='actions'>
				<a href='/dailyops/edit/<?php echo $p['Dailyop']['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
				<a href='http://dev.theberrics.com/news/<?php echo $p['Dailyop']['uri']; ?>' target='_blank'>Preview</a>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>
</div>