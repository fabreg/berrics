<?php 

$types = MediaFile::mediaFileTypes();

?>
<script>
$(document).ready(function() { 


	var mc = $('.media-item').length;
	$("#media-badge").html(mc);
	
	$('.media-item select').change(function() { 

		$("#media-form").submit();

	});


	$('button[name=delete_media]').click(function() { 

		removeMediaItem($(this).val());

	});

	$('.media-item-display-weight').change(function() { 

		var form = $("#media-form");

		form.attr("autosave",true);
	
		form.submit();

		form.removeAttr("autosave");

	});

	
});

function removeMediaItem($id) {

	var form = $("#media-form");

	form.append($("<input />").attr({

		"name":"data[DailyopMediaItem][DeleteMediaItem]",
		"value":$id,
		"type":"hidden"
		
	}));

	form.attr("autosave",true);
	
	form.submit();

	form.removeAttr("autosave");
	
}


</script>
<style>

.media-item {

	width:31.9%;
	margin-left:.5%;
	margin-right:.5%;
	float:left;
	margin-bottom:5px;
	border-radius:12px;
	border:1px solid #f0f0f0;
	background-color:#f6f6f8;
}

.media-item .inner {

	padding:5px;

}

/* Large desktop */
@media (min-width: 1200px) { 


}
 
/* Portrait tablet to landscape and desktop */
@media (min-width: 768px) and (max-width: 979px) { 

	.media-item {
	
		width:45.9%;
	
	}

}
 
/* Landscape phone to portrait tablet */
@media (max-width: 767px) {

	.media-item {
	
		width:45.9%;
	
	}
	

}
 
/* Landscape phones and down */
@media (max-width: 480px) { 
	
	.media-item {
	
		width:97.5%;
	
	}


}
</style>
<?php 

$sort = array();

for($i=1;$i<=99;$i++) $sort[$i] = $i;

$url = array(
			"controller"=>"dailyops",
			"action"=>"handle_tab_save"
		);

echo $this->Form->create("Dailyop",array("url"=>$url,"id"=>"media-form"));
echo $this->Form->input("element",array("value"=>"edit-media","type"=>"hidden"));
?>
<h3>Media Items</h3>
<div>
<a href='<?php echo $this->Admin->url(array("action"=>"attach_media",$this->request->data['Dailyop']['id'],"DailyopMediaItem")); ?>' class='btn btn-success'><i class='icon icon-plus icon-white'></i> Attach Media</a>
<a href="<?php echo $this->Admin->url(array("controller"=>"attach_media","action"=>"index","DailyopMediaItem","dailyop_id",$this->data['Dailyop']['id'])); ?>?tab=media" class="btn btn-success">
<i class="icon icon-white icon-edit"></i> New Attach Media
</a>
</div>
<?php if(count($this->request->data['DailyopMediaItem'])<=0): ?>

<?php else: ?>
<div class='row-fluid'>
	<div class='span12'>
			<?php foreach($this->request->data['DailyopMediaItem'] as $k=>$v): ?>
			<div class='media-item'>
				<div class='inner'>
					<div class='row-fluid'>
						<div class='span4'>
							<?php echo $this->Media->mediaThumb(array(
								"MediaFile"=>$v['MediaFile'],
								"h"=>150,
								"w"=>200		
							),array("class"=>"img-polaroid"));?>
						</div>
						<div class='span8'>
							<div>
								<small><strong><?php echo $v['MediaFile']['name']; ?></strong></small>
							</div>
							<div>
								<span class='label label-success'><?php echo strtoupper($types[$v['MediaFile']['media_type']]); ?></span>
							</div>
							
							<?php echo $this->Form->input("DailyopMediaItem.{$k}.display_weight",array("options"=>$sort,'class'=>'media-item-display-weight')); ?>
							<?php echo $this->Form->input("DailyopMediaItem.{$k}.id"); ?>
							<div class='btn-toolbar'>
									<div class='btn-group dropdown'>
										<button class='btn btn-warning btn-small' type='button' data-toggle='dropdown'>Actions <b class='caret'></b></button>
										<ul class='dropdown-menu bottom-up'>
											<li>
												<a href='<?php echo $this->Admin->url(array("action"=>"inspect","controller"=>"media_files",$v['MediaFile']['id'])); ?>' ><i class='icon icon-edit'></i> Edit</a>
											</li>
											<?php 
												if(strtoupper($v['MediaFile']['media_type'])=="BCOVE"):
											?>
											<li>
												<a href="javascript:uploadVideoFile({id:'<?php echo $v['MediaFile']['id']; ?>'});"><i class='icon icon-edit'></i> Update Video File</a>
											</li>
											<li>
												<a href='javascript:uploadVideoImage("<?php echo $v['MediaFile']['id']; ?>");'><i class='icon icon-edit'></i> Update Video Image</a>
											</li>
											<?php 
												endif; 
											?>
										</ul>
									</div>
								<button type='button' class='btn btn-danger btn-small' name='delete_media' value='<?php echo $v['id']; ?>'><i class='icon icon-white icon-remove'></i> Remove</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
	</div>
</div>

<?php endif; ?>

<?php 
echo $this->Form->end();
?>