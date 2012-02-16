$(document).ready(function()  { 
	
	
	
	
});



var UserSearch = {
		
	selectedCallBack:null,
	selectedCallBackArgs:new Array(),
	openSearch:function() { 
		
		this.selectedCallBack = arguments[0] || null;
	
		if(arguments.length>1) {
			
			Array.prototype.shift.call(arguments);
			
			this.selectedCallBackArgs = arguments;
			
		} else {
		
			this.selectedCallBackArgs = new Array();
			
		}
		
		$('body').prepend("<div id='user-modal'><div id='user-modal-content'></div></div>");
		
		$.get("/users/users_modal_search",function(d) {  $("#user-modal-content").html(d);   });
		
		this.handleResize();
		
		
		
	},
	handleResize:function() { 
	
		$("#user-modal").css({
			
			"height":$(document).height()+"px",
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
			"overflow":"auto",
			"position":"fixed",
			"margin-left":"10%"
			
		});
		
	},
	handleSelect:function(user) {
	
		var fn = window[this.selectedCallBack];
		
		Array.prototype.unshift.call(this.selectedCallBackArgs, user);
		
		
		if(typeof fn === 'function') {
			
			fn.apply(this,this.selectedCallBackArgs);
			
		} else {
		
			alert("Callback if not in scope");
			
		}
		
	},
	closeModal:function() {
		
		$("#user-modal").remove();
		
	}
		
		
};

