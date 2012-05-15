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


var InventorySearch = {
		
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
		
		$('body').prepend("<div id='inventory-modal'><div id='inventory-modal-content'></div></div>");
		
		$.get("/canteen_inventory_records/inventory_modal_search",function(d) {  $("#inventory-modal-content").html(d);   });
		
		this.handleResize();
		
		
	},
	handleResize:function() { 
	
		$("#inventory-modal").css({
			
			"height":$(document).height()+"px",
			"width":"100%",
			"background-image":"url(/img/blk-px.png)",
			"position":"absolute",
			"z-index":"1002"
				
		});
		
		$("#inventory-modal-content").css({
			
			"min-height":"80%",
			"width":"80%",
			"background-color":"white",
			"margin":"auto",
			"overflow":"auto",
			"position":"fixed",
			"margin-left":"10%"
			
		});
		
	},
	handleSelect:function(record) {
	
		var fn = window[this.selectedCallBack];
		
		Array.prototype.unshift.call(this.selectedCallBackArgs, record);
		
		
		if(typeof fn === 'function') {
			
			fn.apply(this,this.selectedCallBackArgs);
			
		} else {
		
			alert("Callback if not in scope");
			
		}
		
	},
	closeModal:function() {
		
		$("#inventory-modal").remove();
		
	}
		
		
};



var VideoFileUpload = {
		
		media_file_id:null,
		completedCallback:null,
		callbackArgs:null,
		openUpload:function() { 
				
			this.media_file_id = arguments[0] || null;
		
			Array.prototype.shift.call(arguments);
			
			this.completedCallback = arguments[0] || null;
			
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
							
							
							var str = "Uploading:"+bl+" / "+bt;
							
							
							if(bl >= bt) {
								
								str += "<div style='color:green; font-weight:bold;'>Processing File Please Wait A Moment......<br />The Screen will refresh when completed</div>"
								
							}
							
							$("#progress-div").html(str);
						},
						upload_complete_handler:function() {
						
							
							
						},
						upload_success_handler:function(f,d,r) {
							
							VideoFileUpload.handleCallback(d);
							
						},
						upload_error_handler:function(f,e,m) { 
							
							alert(m);
							
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
			$("#upload-modal").css({
				
				"height":$('body').height()+"px"
				
			});
			
		},
		closeUpload:function() {
			
			$('body,html').css({
				
				"overflow":"auto"
				
			});
			
			$("#upload-modal").remove();
			
		},
		handleCallback:function(file) {
			
			var obj = eval("("+file+")");
			
			
			var fn = window[VideoFileUpload.completedCallback];
			
			Array.prototype.unshift.call(VideoFileUpload.callbackArgs, obj);
			
			if(typeof fn === 'function') {
				
				fn.apply(this,VideoFileUpload.callbackArgs);
				
			} else {
			
				alert("Callback if not in scope");
				
			}
			
		}
		
		
		
};

var VideoStillUpload = {
		

		media_file_id:null,
		completedCallback:null,
		callbackArgs:null,
		openUpload:function() { 
				
			this.media_file_id = arguments[0] || null;
		
			Array.prototype.shift.call(arguments);
			
			this.completedCallback = arguments[0] || null;
			
			Array.prototype.shift.call(arguments);
			
			if(arguments.length>1) {
				
				this.callbackArgs = arguments;
				
			} else {
			
				this.callbackArgs = new Array();
				
			}
			
			$('body').append("<div id='upload-modal'><div id='upload-modal-content'></div></div>");
			
			$.get("/media_files/ajax_video_still_upload/"+this.media_file_id,function(d) { 
				
				$("#upload-modal-content").html(d); 
			
				//bootstrap swf upload
				var opt = {
						
						flash_url:"/swfupload/swfupload.swf",
						button_placeholder_id:"video-upload-button",
						button_image_url:"/img/video-file-upload-button.png",
						button_height:50,
						button_width:200,
						button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
						upload_url:"/media_files/handle_ajax_video_still_upload/"+xid+"/"+VideoStillUpload.media_file_id,
						file_types:"*.jpg;*.jpeg;*.gif;*.png",
						file_types_description: "Upload image",
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
							
							
							var str = "Uploading:"+bl+" / "+bt;
							
							
							if(bl >= bt) {
								
								str += "<div style='color:green; font-weight:bold;'>Processing File Please Wait A Moment......<br />The Screen will refresh when completed</div>"
								
							}
							
							$("#progress-div").html(str);
						},
						upload_complete_handler:function() {
						
							
							
						},
						upload_success_handler:function(f,d,r) {
							
							VideoStillUpload.handleCallback(d);
							
						},
						upload_error_handler:function(f,e,m) { 
							
							alert(m);
							
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
			
			$("#upload-modal").css({
				
				"height":$('body').height()+"px"
				
			});
			
		},
		closeUpload:function() {
			
			$('body,html').css({
				
				"overflow":"auto"
				
			});
			
			$("#upload-modal").remove();
			
		},
		handleCallback:function(file) {
			
			var obj = eval("("+file+")");
			
			var fn = window[VideoStillUpload.completedCallback];
			
			Array.prototype.unshift.call(VideoStillUpload.callbackArgs, obj);
			
			if(typeof fn === 'function') {
				
				fn.apply(this,VideoStillUpload.callbackArgs);
				
			} else {
			
				alert("Callback if not in scope");
				
			}
			
		}

};


var ImageFileUpload = {
		
		media_file_id:null,
		completedCallback:null,
		callbackArgs:null,
		openUpload:function() { 
				
			this.media_file_id = arguments[0] || null;
		
			Array.prototype.shift.call(arguments);
			
			this.completedCallback = arguments[0] || null;
			
			Array.prototype.shift.call(arguments);
			
			if(arguments.length>1) {
				
				this.callbackArgs = arguments;
				
			} else {
			
				this.callbackArgs = new Array();
				
			}
			
			$('body').append("<div id='upload-modal'><div id='upload-modal-content'></div></div>");
			
			$.get("/media_files/ajax_image_upload/"+this.media_file_id,function(d) { 
				
				$("#upload-modal-content").html(d); 
			
				//bootstrap swf upload
				var opt = {
						
						flash_url:"/swfupload/swfupload.swf",
						button_placeholder_id:"video-upload-button",
						button_image_url:"/img/video-file-upload-button.png",
						button_height:50,
						button_width:200,
						button_window_mode : SWFUpload.WINDOW_MODE.TRANSPARENT,
						upload_url:"/media_files/handle_ajax_image_upload/"+xid+"/"+ImageFileUpload.media_file_id,
						file_types:"*.jpg;*.jpeg;*.gif;*.png",
						file_types_description: "Upload image",
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
							
							
							var str = "Uploading:"+bl+" / "+bt;
							
							
							if(bl >= bt) {
								
								str += "<div style='color:green; font-weight:bold;'>Processing File Please Wait A Moment......<br />The Screen will refresh when completed</div>"
								
							}
							
							$("#progress-div").html(str);
						},
						upload_complete_handler:function() {
						
							
							
						},
						upload_success_handler:function(f,d,r) {
							
							ImageFileUpload.handleCallback(d);
							
						},
						upload_error_handler:function(f,e,m) { 
							
							alert(m);
							
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
			
			$("#upload-modal").css({
				
				"height":$('body').height()+"px"
				
			});
			
		},
		closeUpload:function() {
			
			$('body,html').css({
				
				"overflow":"auto"
				
			});
			
			$("#upload-modal").remove();
			
		},
		handleCallback:function(file) {
			
			var obj = eval("("+file+")");
			
			var fn = window[ImageFileUpload.completedCallback];
			
			Array.prototype.unshift.call(ImageFileUpload.callbackArgs, obj);
			
			if(typeof fn === 'function') {
				
				fn.apply(this,ImageFileUpload.callbackArgs);
				
			} else {
			
				alert("Callback if not in scope");
				
			}
			
		}
		
		
};

var CanteenOrderNote = {
		
		
		
		canteen_note_id:null,
		completedCallback:null,
		callbackArgs:null,
		reply:function() { 
				
			this.canteen_note_id = arguments[0] || null;
		
			Array.prototype.shift.call(arguments);
			
			this.completedCallback = arguments[0] || null;
			
			Array.prototype.shift.call(arguments);
			
			if(arguments.length>1) {
				
				this.callbackArgs = arguments;
				
			} else {
			
				this.callbackArgs = new Array();
				
			}
			
			
			$('body').append("<div id='upload-modal'><div id='upload-modal-content'></div></div>");
			
			$.get("/canteen_orders/ajax_note_reply/"+this.canteen_note_id,function(d) { 
				
				$("#upload-modal-content").html(d); 
				
				$("#ajax_order_note_form").ajaxForm({
					
					"success":function(d) {
						$('body').append(d);
						CanteenOrderNote.handleCallback();
					
					}
					
				});
			
			});
			
			this.handleResize();
				
		},
		handleResize:function() {
			
			$('body,html').css({
				
				"overflow":"hidden"
				
			});
			
			$("#upload-modal").css({
				
				"height":$('body').height()+"px"
				
			});
			
		},
		close:function() {
			
			$('body,html').css({
				
				"overflow":"auto"
				
			});
			
			$("#upload-modal").remove();
			
		},
		handleCallback:function() {
			
			var obj = {};
			
			var fn = window[CanteenOrderNote.completedCallback];
			
			Array.prototype.unshift.call(CanteenOrderNote.callbackArgs, obj);
			
			if(typeof fn === 'function') {
				
				fn.apply(this,CanteenOrderNote.callbackArgs);
				
			} else {
			
				alert("Callback not in scope");
				
			}
			
		}
		
		
};


