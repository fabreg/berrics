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


var VideoFileUpload = {
		
		media_file_id:null,
		completedCallback:null,
		callbackArgs:null,
		openUpload:function() { 
				
			this.media_file_id = arguments[0] || null;
		
			Array.prototype.shift.call(arguments);
			
			this.completedCallback = arguments[1] || null;
			
			Array.prototype.shift.call(arguments);
			
			if(arguments.length>1) {
				
				this.callbackArgs = arguments;
				
			} else {
			
				this.callbackArgs = new Array();
				
			}
			
			$('body').append("<div id='upload-modal'><div id='upload-modal-content'></div></div>");
			
			$.get("/media_files/ajax_media_file_upload/"+this.media_file_id,function(d) { 
				
				$("#upload-modal-content").html(d); 
			
				//bootstrap swf upload
				var opt = {
						
						flash_url:"/swfupload/swfupload.swf",
						button_placeholder_id:"video-upload-button",
						button_image_url:"/img/video-file-upload-button.png",
						button_height:50,
						button_width:200,
						button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
						upload_url:"/media_files/handle_ajax_media_file_upload/"+xid+"/"+VideoFileUpload.media_file_id,
						file_types:"*.mp4;*.mov;*.mpg;*.mpeg",
						file_types_description: "Update us with a video",
						file_queue_limit:1,
						file_queued_handler:function(f) {
							
							this.startUpload();
						
						},
						
						file_queue_error_handler:function(f,e,m) {
							
							//alert(m);
							
						},
						upload_start_handler:function(f) {
							
							
							
						},
						upload_progress_handler:function(f,bl,bt) {
							
							$("#progress-div").html("Uploading:"+bl+" / "+bt);
							
						},
						upload_complete_handler:function() {
						
							var s = '';
							for(var a in arguments[0].post) {
							
								s += a+":"+arguments[0].post[a];
								s += "\n"
								
							}
							
							alert(s);
							
						},
						upload_success_handler:function(f,d,r) {
							
							
							
						},
						debug:true
						
					};
				new SWFUpload(opt);
				
			});
			
			this.handleResize();
				
		},
		handleResize:function() {
			
			$('body,html').css({
				
				"overflow":"hidden"
				
			});
			
			
		},
		closeUpload:function() {
			
			$('body,html').css({
				
				"overflow":"auto"
				
			});
			
			$("#upload-modal").remove();
			
		}
		
		
		
};



