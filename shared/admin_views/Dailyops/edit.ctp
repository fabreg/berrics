<script>

var post = {};

$(document).ready(function() { 

	$('form').each(function() { 

		if($(this).has('.tab-pane')) {

			initTabForm(this);
				
		}

	});

	
	$('a[data-toggle="tab"]').each(function() { 

		$(this).on('show',function(e) { 

			var id = $(e.relatedTarget).attr("href");

			if(id) {

				$(id).find('form').submit();

			}

		});

	});

	//tab switch
	var tab = <?php echo (isset($_GET['tab'])) ? "'{$_GET['tab']}'":'false'; ?>;

	if(!tab) {

		$('.nav-tabs li:eq(0) a').tab('show');

	} else {

		$(".nav-tabs a[href=#"+tab+"]").tab('show');

	}

	
	
});

function initTabForm(form) {

	var $that = $(form);

	var id = $that.parent().attr("id");

	var tab = $('.nav-tabs a[href=#'+id+']');

	var pane = $("#"+id);

	
	$that.unbind().change(function() { 

		tab.find('span.msg').remove();

		tab.prepend("<span class='msg'>*</span> ");

	});


	$that.ajaxForm({
		beforeSubmit:function() {

			var autosave = $that.attr("autosave");
			
			if(!autosave && tab.find('span.msg').length<=0) return false;

			pane.append("<div class='save-msg'></div>");

			pane.find('.save-msg').css({

				"opacity":.5,
				"background-color":"#fff",
				"top":"0px",
				"left":"0px",
				"position":"absolute",
				"height":pane.height()+"px",
				"width":pane.width()+"px"

			});
			
			tab.find('span.msg').html("Saving....");
			
		},
		success:function(d) {

			$("#"+id).find('form').remove();
			
			$("#"+id).html(d).find("form").each(function() { initTabForm(this); });;

			tab.find('span.msg').remove();
			
			initBootstrap();

			$("#"+id).find("#flashMessage").appendTo("#fm");
			
			$('html, body').animate({
			    scrollTop: 0
			 }, 1000);
			
		}
	});
	
	
}

function setPost (obj) {
	
	post = obj;
	console.log(post);

}




</script>
<style>

.check-well {

	border-radius:12px;
	background-color:#f0f0f0;
	margin-bottom:3px;
	padding:10px;

}

.checked {

	background-color:#a3ffa9;

}

span.msg {

	color:red;
	font-weight:bold;

}

.tab-pane {

	position:relative;

}

.alert {

	max-width:550px;

}

</style>
<div class=''>
	<div class='page-header'>
		<h1>Edit Post <small>ID: <?php echo $this->request->data['Dailyop']['id']; ?></small> <a class='btn btn-primary btn-mini' href='/dailyops'><i class='icon icon-white icon-circle-arrow-left'></i> Back to listing</a></h1>
		<strong>Author:</strong> <?php echo $this->data['User']['first_name']; ?> <?php echo $this->data['User']['last_name']; ?> ( <?php echo $this->Time->niceShort($this->data['Dailyop']['created']); ?> )
		
	</div>
	<div style='padding:10px;'>
		
	</div>
	<div id='fm'>
		
	</div>
	
	<ul class='nav nav-tabs' id='super-tabs'>
		<li><a href='#general'  data-toggle='tab'>General</a></li>
		<li><a href='#text' data-toggle='tab'>Text & Misc.</a></li>
		<li><a href='#meta' data-toggle='tab'>Meta <span class='badge badge-info' id='meta-badge'></span></a></li>
		<li><a href='#media' data-toggle='tab'>Media <span class='badge badge-info' id='media-badge'><?php echo count($this->request->data['DailyopMediaItem']); ?></span></a></li>
		<li><a href='#article' data-toggle='tab'>Article <span class='badge badge-info' id='article-badge'></span></a>
		<li><a href='#assigned' data-toggle='tab'>Assigned Users <span class='badge badge-info' id='users-badge'>0</span></a>
		<li><a href="#errors" data-toggle='tab'>Errors</a></li>
	</ul>

	<div class='tab-content'>
		
		<div class='tab-pane' id='general'>
			<?php 
				echo $this->element("dailyops/edit-general");
			?>
		</div>
		<div class='tab-pane' id='text'>
			<?php 
				echo $this->element("dailyops/edit-text");
			?>
		</div>
		<div class='tab-pane' id='meta'>	
			<?php 
				echo $this->element("dailyops/edit-meta");
			?>
		</div>
		<div class='tab-pane' id='media' style='padding-bottom:80px;'>
			<?php echo $this->element("dailyops/edit-media"); ?>
		</div>
		<div class='tab-pane' id='article' >
			<?php echo $this->element("dailyops/edit-article"); ?>
		</div>
		<div class='tab-pane' id='assigned'>
			<?php echo $this->element("dailyops/edit-users"); ?>
		</div>
	</div>
	

	
</div>