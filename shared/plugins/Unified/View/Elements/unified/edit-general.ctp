<?php 

$storeStatus = UnifiedStore::storeStatus();

$years = array();

for($i=1970;$i<=date("Y");$i++) $years[$i] = $i;

?>
<script>
jQuery(document).ready(function($) {
	

});

function checkDupeUnifiedUri() {

	

}
</script>
<div class="row-fluid">
	<div class="span6">
		<?php 
			echo $this->Form->input("id");
			if(CakeSession::read("is_admin") == 1) {

				echo $this->Form->input("store_status",array("options"=>$storeStatus));

			}
			echo $this->Form->input("shop_name");
			echo $this->Form->input('shop_bio');
			echo $this->Form->input("timezone",array("options"=>$timezones));
			echo $this->Form->input("shop_email");
			echo $this->Form->input("website_url",array("help"=>"<small>(USE: http://)</small>"));
			echo $this->Form->input("uri",array("help"=>"<small>(IE: theberrics.com/unified/{URI})</small>"));
			echo $this->Form->input("established_year",array("options"=>$years));
			echo $this->Form->input("parking_situation",array("options"=>UnifiedStore::parkingSituation(),"empty"=>true));
			
		?>
		
	</div>
	<div class="span6">
		<h3>Image Logo</h3>
		<div class="row-fluid">
			<div class="span4">
				<?php if (!empty($this->request->data['UnifiedStore']['image_logo'])): ?>
					  <img src="//img.theberrics.com/i.php?src=/unified-logos/<?php echo $this->request->data['UnifiedStore']['image_logo']; ?>&w=75" alt="">
					  <div><a href='//img.theberrics.com/unified-logos/<?php echo $this->request->data['UnifiedStore']['image_logo']; ?>' target='_blank'>View Full Size</a></div>
				<?php else: ?>
						<span class="label label-important">
							No Image Icon Uploaded
						</span>
				<?php endif; ?>
			</div>
			<div class="span8">
				<?php echo $this->Form->input("image_logo_file",array("type"=>"file")); ?>
			</div>
		</div>
		<h3>Social Networking</h3>
		<?php 

			$this->Form->formSpan = "span9";
			echo $this->Form->input("facebook_url",array("prepend"=>"http://facebook.com/"));
			$this->Form->formSpan = "span11";
			echo $this->Form->input("twitter_handle",array("prepend"=>"@"));
			echo $this->Form->input("instagram_handle",array("prepend"=>"@"));
			$this->Form->formSpan = "span12";

		 ?>
		<div class="well well-small">
			<h3>Associate Tags</h3>
			<?php echo $this->Form->input("tags",array("help"=>"<small>( Comma seperate multiple tags )</small>")); ?>
			<div class="form-actions">
				<button class="btn btn-primary btn-mini" name='data[submit-btn]' value='add-tags' ><i class="icon icon-plus-sign"></i> Add Tags</button>
			</div>
		</div>
		<h3>Tags</h3>
		<div class="">
			<?php if (count($this->request->data['Tag'])>0): ?>
				<?php echo $this->Admin->quickTagEdit($this->request->data['Tag'],true); ?>
			<?php endif ?>
		</div>

	</div>
</div>