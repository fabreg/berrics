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
			echo $this->Form->input("uri");
			echo $this->Form->input("established_year",array("options"=>$years));
			echo $this->Form->input("parking_situation",array("options"=>UnifiedStore::parkingSituation(),"empty"=>true));
			
		?>
		
	</div>
	<div class="span6">
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