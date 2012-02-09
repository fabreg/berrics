$(document).ready(function() {
	
	
	//handle the form submit
	$("#voting-box-form").submit(function() { 
		
		//validate the vote
		var winner_select = $(this).find("select[name='data[BatbVote][match_winner_user_id]']");
		var ro_sham_bo_select = $(this).find("select[name='data[BatbVote][rps_winner_user_id]']");
		var letters_select = $(this).find("select[name='data[BatbVote][winner_letters]']");
		
		if($(ro_sham_bo_select).val().length<=0 || $(winner_select).val().length<=0) {
			
			alert("Hey! You forgot something!");
			return false;
			
		}
		
		//we're all good, now allow the user to confirm their vote
		var str = "Confirm your prediction: \n";
		str += "Ro-Sham-Bo: "+$(ro_sham_bo_select).find("option:selected").text()+"\n";
		str += "Winner: "+$(winner_select).find("option:selected").text()+" with "+$(letters_select).find("option:selected").text();
		
		return confirm(str);

		return false;
		
	});
	
});