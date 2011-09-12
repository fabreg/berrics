<?php 
//make a select array for the sort order
$sort = array();

for($i=0;$i<=99;$i++) {

	$sort[$i]=$i;

}

$img_dir = array(

	"top"=>"TOP",
	"left"=>"LEFT",
	"right"=>"RIGHT",
	"bottom"=>"BOTTOM"
);


?>
<div class='dailyop-text-item index'>
	
	<table cellspacing='0'>
		<tr>
			<th colspan='2' align='left'>Text Item (<?php echo $key+1; ?>)</th>
		</tr>
		<tr>
			<td valign='top'>
				<?php 
					echo $this->Form->input("DailyopTextItem.{$key}.heading");
					echo $this->Form->input("DailyopTextItem.{$key}.text_content"); 
				?>
			</td>
			<td valign='top' width='40%'>
				<?php 
					echo $this->Form->input("DailyopTextItem.{$key}.id");
					echo $this->Form->input("DailyopTextItem.{$key}.display_weight",array("options"=>$sort));
					echo $this->Form->submit("Update");
					echo $this->Form->submit("Attach Media Item",array("name"=>"data[AttachMedia][{$item['id']}]"));
					echo $this->Form->submit("Delete",array("name"=>"data[DeleteTextItem][{$item['id']}]"));
				?>
				<?php 
					if(count($item['MediaFile'])>0):
				?>
				<div style='clear:both;'>
					<div style='float:left;'>
					<?php 
					
						echo $this->Media->mediaThumb(array(
						
							"MediaFile"=>$item['MediaFile'],
							"w"=>150
						
						));
					
					?>
					</div>
					<div>
						Type: <?php echo $item['MediaFile']['media_type']; ?>
					</div>
					<div>
						<?php echo $item['MediaFile']['name']; ?>
					</div>
					<div style='clear:both;'></div>
				</div>
				<?php 
					echo $this->Form->input("DailyopTextItem.{$key}.thumb_width");
					echo $this->Form->input("DailyopTextItem.{$key}.thumb_height");
					echo $this->Form->input("DailyopTextItem.{$key}.placement",array("options"=>$img_dir,"label"=>"Placement (Only images can be placed in-line with text)"));
					echo $this->Form->submit("Update");
					echo $this->Form->submit("Remove Media Item",array("name"=>"data[RemoveMediaItem][{$item['id']}]"));
				?>
				<?php 
					endif;
				?>
			</td>
		</tr>
	</table>

	
</div>