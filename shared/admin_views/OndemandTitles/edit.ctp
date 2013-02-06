<?php 



$item_num = array();

for($i=1;$i<=99;$i++) $item_num[$i] = $i;

?>
<script>

$(document).ready(function() { 

	var h = document.location.hash;

	h = h.replace(/#/,'');

	if(h.length <=0) h = "general";

	$('.nav-tabs a[href=#'+h+']').tab('show'); 


	$( "#OndemandTitlePubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	$("#OndemandTitlePubTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});
	$("#OndemandTitleReleaseDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
});

</script>
<div class="page-header">
	<h1>Edit On-Demand Title </h1>
	<a href="/ondemand_titles" class="btn btn-primary">Back to listing</a>
</div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li ><a href="#general" data-toggle="tab">General Info</a></li>
		<li><a href="#images" data-toggle="tab">Images</a></li>
		<li><a href="#posts" data-toggle="tab">Posts</a></li>
	</ul>
	<?php echo $this->Form->create('OndemandTitle',array(
									"id"=>'OndemandTitleForm',
									"url"=>$this->request->here
								));	 ?>
	<div class="tab-content">
		<div class="tab-pane" id="general">
			<?php echo $this->element("ondemand/edit-general"); ?>
		</div>
		<div class="tab-pane" id="images">
			
		</div>
		<div class="tab-pane" id="posts">
			<?php echo $this->element("ondemand/edit-posts"); ?>
		</div>
	</div>
</div>

<?php echo $this->Form->end(); ?>

<pre><?php print_r($this->request->data); ?></pre>
