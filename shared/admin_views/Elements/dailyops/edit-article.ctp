<script type="text/javascript">

$(document).ready(function() { 


	var ac = $('.text-item').length;

	$("#article-badge").html(ac);

	$('.remove-text-item').click(function() { 

		removeTextItem($(this).val());

	});

	$('.remove-media').click(function() { 

		removeMedia($(this).val());

	});


	$('.attach-media-button').click(function() { 

		var form = $("#article-form");

		var uri = $(this).attr("href");

		form.attr("autosave","autosave");

		form.ajaxForm(function() { 

			document.location.href=uri;

		});

		form.submit();

		return false;

	});
	
	
});

function removeTextItem($id) {

	var form = $("#article-form");

	form.append($("<input />").attr({

		"type":"hidden",
		"name":"data[DailyopTextItem][RemoveTextItem]",
		"value":$id

	}));

	form.attr("autosave","autosave");
	form.submit();
	form.removeAttr("autosave");
}

function removeMedia($id) {

	var form = $("#article-form");

	form.append($("<input />").attr({

		"type":"hidden",
		"name":"data[DailyopTextItem][RemoveMedia]",
		"value":$id

	}));

	form.attr("autosave","autosave");
	form.submit();
	form.removeAttr("autosave");
	
}



</script>
<?php 

$types = MediaFile::mediaFileTypes();

$sort = array();
for($i=0;$i<=99;$i++) $sort[$i] = $i;

$url = array(
			"action"=>"handle_tab_save"
		);

echo $this->Form->create("Dailyop",array("url"=>$url,"id"=>"article-form"));
echo $this->Form->input("element",array("type"=>"hidden","value"=>"edit-article"));


?>
<?php echo $this->Session->flash(); ?>
<h3>Article Content</h3>
<div class='btn-toolbar'>
	<a href='<?php echo $this->Admin->url(array("action"=>"add_text_item",$this->request->data['Dailyop']['id'])); ?>' class='btn btn-success'><i class='icon icon-plus-sign icon-white'></i> Add New Text Item</a>
</div>
<?php 
foreach($this->request->data['DailyopTextItem'] as $k=>$v):
?>

<div class='row-fluid text-item'>
	
	<div class='well clearfix'>
	<div class='span8' style='margin-bottom:3px;'>
		<?php 
			$this->Form->formSpan = "span12";
			echo $this->Form->input("DailyopTextItem.{$k}.id");
			echo $this->Form->input("DailyopTextItem.{$k}.display_weight",array("options"=>$sort));
			echo $this->Form->input("DailyopTextItem.{$k}.heading");
			echo $this->Form->input("DailyopTextItem.{$k}.text_content");
			
		?>
		<button class='btn btn-primary'>Update Text</button>
		<button class='btn btn-danger remove-text-item' value='<?php echo $v['id']; ?>' type='button' ><i class='icon icon-white icon-minus-sign'></i> Remove</button>
	</div>
	<div class='span4'>
		<div class='row-fluid'>
			<div class='span12'>
				<?php 
					if(!empty($v['MediaFile']['id'])):
				?>
					<div>
						<span class='label label-info'>
							<?php echo strtoupper($types[$v['MediaFile']['media_type']]); ?>
						</span>
					</div>
					<?php echo $this->Media->mediaThumb(

							array(
								"MediaFile"=>$v['MediaFile'],
								"h"=>120		
							)
							
					); ?>
				<?php 
					else:
				?>
				
				<?php 
					endif;
				?>
			</div>
		</div>
		<div class='row-fluid'>
			<div class='span6'>
				<?php echo $this->Form->input("DailyopTextItem.{$k}.thumb_width"); ?>
			</div>
			<div class='span6'>
				<?php echo $this->Form->input("DailyopTextItem.{$k}.thumb_height"); ?>
			</div>
		</div>
		<div class='row-fluid'>
			<div class='span12'>
				<?php echo $this->Form->input("DailyopTextItem.{$k}.placement",array("options"=>DailyopTextItem::placements())); ?>
			</div>
		</div>
		<div class='row-fluid'>
			<div class='span12'>
				<div class=''>
					<button class='btn btn-primary'><i class='icon icon-white icon-edit'></i> Update</button>
					<a href='<?php echo $this->Admin->url(array("action"=>"attach_media",$this->request->data['Dailyop']['id'],"DailyopTextItem",$v['id'])); ?>' class='btn btn-success attach-media-button'><i class='icon icon-white icon-plus-sign'></i> Attach Media</a>
					<?php if(!empty($v['MediaFile']['id'])): ?>
					<button class='btn btn-danger remove-media' value='<?php echo $v['id']; ?>' ><i class='icon icon-white icon-minus-sign'></i> Remove Media</button>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>


<?php 
endforeach;
?>
<?php 
echo $this->Form->end();
?>