$(document).ready(function() { 
	
	var pimg = new Image();
	
	pimg.src='/img/layout/check-bg-selected.png';
	
	//handle the winner checks
	$("#match-winner-row .checkbox").click(function() {
		
		var featured_num = $(this).attr("featured_num");
		
		var user_id = $(this).attr("user_id");
		
		var player = $(this).attr("player");
		
		var other_player = 2;
		
		if(player==2) {
			
			other_player = 1;
		}
		
		//clear out the checks
		$(this).parent().parent().find('.checkbox').removeClass('checkbox-selected');
	
		//mark the clicked box as selected
		$(this).addClass('checkbox-selected');
		
		$("#BatbVoteMatchWinnerUserId-"+featured_num).val(user_id);
		
		//show the select for the winner
		$("table[featured_num="+featured_num+"] td[player="+player+"] .sk8").hide();
		$("table[featured_num="+featured_num+"] td[player="+player+"] .sk8-select").show().find("select").attr("disabled",false);
		
		//show the other
		$("table[featured_num="+featured_num+"] td[player="+other_player+"] .sk8").show();
		$("table[featured_num="+featured_num+"] td[player="+other_player+"] .sk8-select").hide().find("select").attr("disabled",true);
		
		checkData();
		
	});
	
	//hangle the rps checks
	$("#rps-winner-row .checkbox").click(function() {
		
		var featured_num = $(this).attr("featured_num");
		
		var user_id = $(this).attr("user_id");
		
		
		//clear out the checks
		$(this).parent().parent().find('.checkbox').removeClass('checkbox-selected');
	
		//mark the clicked box as selected
		$(this).addClass('checkbox-selected');
		
		$("#BatbVoteRpsWinnerUserId-"+featured_num).val($(this).attr("user_id"));
		
		checkData();
		
	});
		
	
	$(".submit input").val("MAKE YOUR PREDICTIONS ABOVE").attr("disabled",true);

	
});

function checkData() {
	
	var winner1 = $("#BatbVoteMatchWinnerUserId-1").val();
	var winner2 = $("#BatbVoteMatchWinnerUserId-2").val();
	
	var rps1 = $("#BatbVoteRpsWinnerUserId-1").val();
	var rps2 = $("#BatbVoteRpsWinnerUserId-2").val();

	if(winner1.length>1 && winner2.length>1 && rps1.length>1 && rps2.length>1) {
		
		
		$(".submit input").val("SUBMIT YOUR PREDICTIONS").attr("disabled",false);
		
		
	}
	
	
}