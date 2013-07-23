<script>
	jQuery(document).ready(function($) {
		
		$("#asset-form").ajaxForm({


		'success':function(d) {

			document.location.href="/cdn/upload_fb_assets";
			
		},
		uploadProgress: function(event, position, total, percentComplete) {
	       
				$("#submit-button").attr("disabled",true);
				
				if(percentComplete<100) {
					 var percentVal = percentComplete + '%';
					$("#progress").html(percentVal);
			        $("#progress-bar").css({
						width:percentVal
				    });
					
				} else {
				
					$("#progress").html("Processing file....");
					 $("#progress-bar").css({
							width:"100%"
					    });
				}
				
		        
		    }
			

		});

	});
</script>
<div class="page-header">
	<h1>Upload FB Tab Assets</h1>
	<div class="row-fluid">
		<div class="span12">
			<?php echo  $this->Form->create('AssetFile',array(
				"id"=>'ModelForm',
				"url"=>"/cdn/handle_upload",
				"id"=>"asset-form",
				"enctype"=>"multipart/form-data"
			));  ?>
	
			<div class="well well-small">
				<?php echo $this->Form->input("asset-file",array("type"=>"file","help"=>"(Must Be .js or .css)")) ?>
				<div class='row-fluid'>
					<div id="progress">
						
					</div>
					<div class='progress progress-striped active'>
						<div class='bar' id='progress-bar'></div>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<button class="btn btn-primary" id='submit-button' type='submit'>
					Upload Asset
				</button>
			</div>

			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>