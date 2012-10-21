<script>

$(document).ready(function() { 


	$('.accordion a').attr("rel","noAjax");

	$('.date-picker').each(function() { 

		$(this).datepicker({
			"dateFormat":"yy-mm-dd"
		});

	});


	$('.accordion-body form').ajaxForm({

		"beforeSerialize":function($form) {

			var id = $form.parents('.accordion-body:eq(0)').attr("id");

			$form.prepend($("<input />").attr({

				"type":"hidden",
				"name":"data[Report][type]",
				"value":id

			})).find('button').attr("disabled","disabled").html("Loading....");
			
		},
		success:function(d) {

			$('#url-reports').parent().html(d);
			
		}

	});
	
});

</script>
<style>

</style>
<div class='row-fluid' id='url-reports'>
	<div class='span6'>
		
	<div class="accordion" id="accordion2">
	  <div class="accordion-group">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#url-report">
	        URL Report
	      </a>
	    </div>
	    <div id="url-report" class="accordion-body collapse">
	      <div class="accordion-inner">
	       			<div class='well well-small'>
	       			
	       					This will search for the exact URL specified
	       				
	       			</div>
	       			<?php 
			       		echo $this->Form->create("Report",array("id"=>"url-search-form"));
			       	?>
			       	<div>
			       	<?php 
				       	echo $this->Form->input("title",array("class"=>""));
				     ?>
				     <div class='row-fluid'>
			       		<div class='input-prepend'>
				       		<label>Url to search</label>
				       		<span class='add-on'><small>theberrics.com</small></span>
				       		<?php 
				       			echo $this->Form->text("url",array("class"=>""));
				       		?>
				       	</div>
			       	</div>
				     <?php 
				       	echo $this->Form->input("start_date",array("class"=>"date-picker"));
				       	echo $this->Form->input("end_date",array("class"=>"date-picker"));
			       	?>
			       	</div>
			       <div class='form-actions'>
			       		<button class='btn btn-primary'>Generate Report</button>
			       </div>
			       	<?php 
			       		
			       		echo $this->Form->end();
			       ?>
	       		
	      </div>
	    </div>
	  </div>
	  <div class="accordion-group">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#url-search">
	      	URL Search
	      </a>
	    </div>
	    <div id="url-search" class="accordion-body collapse">
	      <div class="accordion-inner">
	       <div class='well well-small'>
	       			
	       					This will search place a wild card on the end of the URL<br />
	       					Example: theberrics.com/battle-at-the-berrics
	       					<br />
	       					Will find "theberrics.com/battle-at-the-berrics-4/pj-vs-koston" etc.
	       				
	       			</div>
	       			<?php 
			       		echo $this->Form->create("Report",array("id"=>"url-search-form"));
			       	?>
			       	<div>
			       	<?php 
				       	echo $this->Form->input("title",array("class"=>""));
				     ?>
				     <div class='row-fluid'>
			       		<div class='input-prepend'>
				       		<label>Url to search</label>
				       		<span class='add-on'><small>theberrics.com</small></span>
				       		<?php 
				       			echo $this->Form->text("url",array("class"=>""));
				       		?>
				       	</div>
			       	</div>
				     <?php 
				       	echo $this->Form->input("start_date",array("class"=>"date-picker","id"=>uniqid()));
				       	echo $this->Form->input("end_date",array("class"=>"date-picker","id"=>uniqid()));
			       	?>
			       	</div>
			       <div class='form-actions'>
			       		<button class='btn btn-primary'>Generate Report</button>
			       </div>
			       	<?php 
			       		
			       		echo $this->Form->end();
			       ?>
	      </div>
	    </div>
	  </div>
	</div>
		
	</div>
</div>