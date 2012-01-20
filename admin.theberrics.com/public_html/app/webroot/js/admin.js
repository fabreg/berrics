$(document).ready(function()  { 
	
	
	
	
});



var UserSearch = {
		
	selectedCallBack:null,
	openSearch:function() { 
		
		this.selectedCallBack = arguments[0] || null;
	
		$('body').prepend("<div id='user-modal'><div id='user-modal-content'></div></div>");
		
		$.get("/users/users_modal_search",function(d) {  $("#user-modal-content").html(d);   });
		
		this.handleResize();
		
		
		
	},
	handleResize:function() { 
	
		$("#user-modal").css({
			
			"height":"100%",
			"width":"100%",
			"background-image":"url(/img/blk-px.png)",
			"position":"absolute",
			"z-index":"1002"
				
		});
		
		$("#user-modal-content").css({
			
			"min-height":"80%",
			"width":"80%",
			"background-color":"white",
			"margin":"auto",
			"overflow":"auto"
			
		});
		
	},
	handleSelect:function(user) {
	
		var fn = window[this.selectedCallBack];
		
		if(typeof fn === 'function') {
			
			fn.call(this,user);
			
		} else {
		
			alert("Callback if not in scope");
			
		}
		
	},
	closeModal:function() {
		
		$("#user-modal").remove();
		
	}
		
		
};

