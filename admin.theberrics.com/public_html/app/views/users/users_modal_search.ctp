<script>

$(document).ready(function() { 

	$("#user-modal-search-form").ajaxForm({

		success:function(d) { 

			$("#search-results").html(d);

		},
		beforeSubmit:function() { 
			$("#search-results").html("Searcing Users.....");
		}
		
	});

	
});

</script>
<div class='form'>
	<div style='text-align:right; padding:10px;'><a href='javascript:UserSearch.closeModal();' style='color:black;'>[X] Close</a></div>
	<fieldset>
		<legend>Search Users</legend>
		<?php 
			echo $this->Form->create("User",array("id"=>"user-modal-search-form","url"=>"/users/users_modal_search_results"));
			echo $this->Form->input("first_name");
			echo $this->Form->input("last_name");
			echo $this->Form->end("Search");
		?>
	</fieldset>
</div>
<div class='index' id='search-results' style=''>
	
</div>