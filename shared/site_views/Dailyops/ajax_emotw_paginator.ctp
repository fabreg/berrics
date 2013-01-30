<?php

$img = '';

if(isset($item[0]['MediaFile']['id'])) {
	
	$img = '';
	$img_bottom = '';
	
	$file = $item[0]['MediaFile'];
	
	$img_file = $item[0]['MediaFile']['file_name'];
	
	$options = array();
	$attr = array();
	
	$options['MediaFile'] = $file;
	
	switch($item[0]['DailyopTextItem']['placement']) {
		
		case "top":
		case "bottom":
			$options['w'] = "650";
			$attr['style'] = "clear:both; margin:auto;";
			break;
		case "left":
		case "right":
				if(!empty($item[0]['DailyopTextItem']['thumb_width'])) $options['w'] = $item[0]['DailyopTextItem']['thumb_width'];
				if(!empty($item[0]['DailyopTextItem']['thumb_height'])) $options['h'] = $item[0]['DailyopTextItem']['thumb_heigh'];
				$attr['class'] = "placement-".$item[0]['DailyopTextItem']['placement'];
				$attr['style'] = "float:".$item[0]['DailyopTextItem']['placement'];
			break;
		
	}
	
	$img = $this->Media->mediaThumb($options,$attr);
	
	if(in_array($item[0]['DailyopTextItem']['placement'],array("bottom"))) {
		
		$img_bottom = "<div style='text-align:center;'>".$img."</div>";
		$img = "";
		
	}
	
	if($item[0]['DailyopTextItem']['placement'] == "top") {
		
		$img = "<div style='text-align:center;'>{$img}</div>";
		
	}
	
}

?>
<div class='emotw-div'>
	<div class='emotw-email'>
		<div class='emotw-container'>
			<div class='emotw-container-top'>
				<div class='emotw-content'>
					<h1><?php echo $item[0]['DailyopTextItem']['heading']; ?></h1>
					<h2>From: <?php echo $item[0]['DailyopTextItem']['from']; ?></h2>
					<div class='p-content'>
						<?php echo $img; ?>
						<?php echo nl2br($item[0]['DailyopTextItem']['text_content']); ?>
						<?php echo $img_bottom; ?>
						<hr />
						Reply:
						<hr />
						<?php echo nl2br($item[0]['DailyopTextItem']['reply']); ?>
					</div>
					
				</div>
				
			</div>
			<div style='clear:both;'></div>
		</div>
		<div class='emotw-bottom'>
			
		</div>
	</div>
	<div class='paging-links'>
	<?php 
		if($this->Paginator->hasPrev()):
	?>
		<span class='paging-link prev-link' page='<?php echo ($this->request->params['paging']['DailyopTextItem']['prevPage']-$this->request->params['paging']['DailyopTextItem']['defaults']['step']) ?>' dailyop_id='<?php echo $item[0]['DailyopTextItem']['dailyop_id']; ?>'>PREVIOUS</span>
	<?php 
		endif;
	?>
	

	<?php 
		if($this->Paginator->hasNext()):
	?>
		<span class='paging-link next-link' page='<?php echo ($this->request->params['paging']['DailyopTextItem']['nextPage']+$this->request->params['paging']['DailyopTextItem']['defaults']['step']) ?>' dailyop_id='<?php echo $item[0]['DailyopTextItem']['dailyop_id']; ?>'>NEXT</span>
	<?php 
		endif;
	?>
	<div class='paging-info'><?php echo $this->request->params['paging']['DailyopTextItem']['page']; ?> of <?php echo $this->request->params['paging']['DailyopTextItem']['pageCount']; ?></div>
	</div>
</div>