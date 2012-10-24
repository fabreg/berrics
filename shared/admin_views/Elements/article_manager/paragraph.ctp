<?php 

$p = $paragraph['ArticleParagraph'];
$id = $p['id'];
$sorting = array(

	"left"=>"Left",
	"right"=>"Right"

);

$htag = array(

	"h2"=>"h2",
	"h3"=>"h3",
	"h4"=>"h4",
	"h5"=>"h5",
	"h6"=>"h6"	

);
?>
<div class='paragraph-bit'>

	<div style='float:left; width:80%;'><?php echo $this->Form->input("heading",array("value"=>$p['heading'],"label"=>"Heading ".$p['sort_weight'],"name"=>"data[paragraph][{$id}][heading]")); ?></div>
	<div style='float:right; width:19%;'>
		<?php 
			echo $this->Form->input("heading_tag",array("options"=>$htag,"value"=>$p['heading_tag'],"name"=>"data[paragraph][{$id}][heading_tag]"));
		?>
	</div>
	<div style='clear:both;'></div>
	<div style='width:80%; float:left;'>
	
	<?php echo $this->Form->input("paragraph ".$p['sort_weight'],array("value"=>$p['text_content'],"type"=>"textarea","name"=>"data[paragraph][{$id}][text_content]","style"=>"width:640px","id"=>"paragraph_".$id)); ?>
	<div style='padding:5px;'>
		<span onclick='wrapText("paragraph_<?php echo $id; ?>","anchor");' class='ui-button' >Insert Anchor</span>
		<span onclick='wrapText("paragraph_<?php echo $id; ?>","strong");' class='ui-button' >Bold</span>
		<span onclick='wrapText("paragraph_<?php echo $id; ?>","em");' class='ui-button' >Italicize</span>
	</div>
	<div>Embed a Vimeo or Youtbe Video OR a Soundcloud Track</div>
	<div class='video-links'>
		<?php 
		
			echo $this->Form->input("vimeo_url",array("name"=>"data[paragraph][{$id}][vimeo_url]","value"=>$p['vimeo_url']));
			echo $this->Form->input("youtube_url",array("name"=>"data[paragraph][{$id}][youtube_url]","value"=>$p['youtube_url']));
			echo $this->Form->input("soundcloud_url",array("name"=>"data[paragraph][{$id}][soundcloud_url]","value"=>$p['soundcloud_url']));
			
		?>
	</div>
	<?php echo $this->Form->input("id",array("type"=>"hidden","value"=>$id,"name"=>"data[paragraph][{$id}][id]")); ?>
	<?php echo $this->Form->input("id",array("type"=>"hidden","value"=>$p['sort_weight'],"name"=>"data[paragraph][{$id}][sort_weight]")); ?>
	</div>
	<div style='width:19%; float:right;' class='media-file'>
		<span class='attach-media-link'><?php echo $this->Admin->attachMediaLink("ArticleParagraph","article_paragraph_id",$p['id'],"/article_manager/edit/".$p['article_id']); ?> </span>
		<?php 
		
		
			if(count($paragraph['MediaFile'])>0) {
				
				
				echo $this->Media->mediaThumb(array(
				
					"MediaFile"=>$paragraph['MediaFile'],
					"w"=>125,
					"h"=>100
				
				));
				
				echo $this->Form->input("media_align",array("type"=>"select","options"=>$sorting,"value"=>$p['media_align'],"paragraph_id"=>$p['id'],"class"=>"update-media-align"));
				echo $this->Form->input("media_height",array("type"=>"text","value"=>$p['media_height'],"name"=>"data[paragraph][{$id}][media_height]"));
				echo $this->Form->input("media_width",array("type"=>"text","value"=>$p['media_width'],"name"=>"data[paragraph][{$id}][media_width]"));
				echo $this->Form->input("Zoom Crop",array("type"=>"checkbox","value"=>$p['media_zc'],"name"=>"data[paragraph][{$id}][media_zc]"));
				echo $this->Admin->link("Remove Item",array(),array("rel"=>"remove-media-item","paragraph_id"=>$p['id']));
			}
		
		?>
	</div>
	<div style='clear:both; font-size:70%;'>
		<?php 
		
			echo $this->Admin->link("Update All Paragraphs","",array("class"=>"update-all-paragraphs"));	
		
		?>
		 | <?php echo $this->Admin->link("Add New Paragraph Below","",array("rel"=>"add-paragraph","below"=>$p['sort_weight'])); ?>
		 | <?php echo $this->Admin->link("Delete Paragraph","",array("rel"=>"delete-paragraph","paragraph_id"=>$p['id'])); ?> 
		 | <?php echo $this->Admin->link("Move Up","",array("rel"=>"move-up","paragraph_id"=>$p['id'])); ?> 
		 | <?php echo $this->Admin->link("Move Down","",array(),"",array("rel"=>"move-down","paragraph_id"=>$p['id'])); ?>
		 
</div>
	<div style='clear:both;'></div>
</div>
