<div class='index form'>
<h2>On.Demand Titles</h2>
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
			<th>Cover Image</th>
			<th>Back Cover Image</th>
			<th><?php echo $this->Paginator->sort("active")?></th>
			<th><?php echo $this->Paginator->sort("hd"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("publish_date"); ?></th>
			<th><?php echo $this->Paginator->sort("release_date"); ?></th>
			<th><?php echo $this->Paginator->sort("title"); ?></th>
			<th>-</th>
		</tr>
		<?php 
			foreach($ondemandTitles as $title):
					$t = $title['OndemandTitle']; 
		?>
		<tr>
			<td align='center' width='2%' nowrap><?php echo $t["id"]; ?></td>
			<td  align='center' width='5%' nowrap>-</td>
			<td align='center' width='5%' nowrap>-</td>
			<td  align='center' width='2%' nowrap>
			<?php 
			
				switch($t["active"]) {
				
					case "1":
						echo "<span style='color:green;'>Yes</span>";
					break;
					default:
						echo "<span> style='color:red;'>No</span>";
					break;
					
				} 

			?>
			</td>
			<td align='center' width='2%' nowrap><?php echo $t["hd"]; ?></td>
			<td align='center' width='5%' nowrap><?php echo $this->Time->niceShort($t["created"]); ?></td>
			<td align='center' width='5%' nowrap><?php echo $this->Time->niceShort($t["modified"]); ?></td>
			<td align='center' width='5%' nowrap><?php echo $this->Time->niceShort($t["publish_date"]); ?></td>
			<td align='center' width='5%' nowrap><?php echo $this->Time->niceShort($t["release_date"]); ?></td>
			
			<td><?php echo$t["title"]; ?></td>
			<td>-</td>
		</tr>	
		<?php endforeach; ?>
	</table>
</div>