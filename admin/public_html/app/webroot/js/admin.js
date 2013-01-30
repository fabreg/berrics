$(document).ready(function()  { 
	
	
	initBootstrap();
	
});

function uploadImages() {
	
	$('body').append("<div class='modal hide' id='upload-images-modal'><div class='alert'>Loading ....</div></div>");
	
	var modal = $("#upload-images-modal");
	
	modal.modal({'backdrop':'static'});
	
	modal.on('show',function() { 
		
		var o = {
				
				"url":"/media_files/upload_images_modal",
				"success":function(d) { 
					
					modal.html(d);
					
				}
				
		};
		
		$.ajax(o);
		
	});
	
	modal.on('hidden',function() { 
		
		modal.remove();
		
	});
	
	modal.modal('show');
	
}

function uploadVideoImage($id) {
	
	$('body').append("<div class='modal  hide' id='video-image-modal'><div class='alert'>Loading .....</div></div>");
	
	var modal = $("#video-image-modal");
	
	modal.modal({'backdrop':'static'});
	
	modal.on('show',function() { 
		
		
		var o = {
				
				"url":"/media_files/video_image_modal/"+$id,
				"success":function(d) {
					
					$("#video-image-modal").html(d);
					
				}
				
		};
		
		
		$.ajax(o);
		
		
	});
	
	modal.on('hidden',function() { 
		
		$('#video-image-modal').remove();
		
	});
	
	modal.modal('show');
	
}

function uploadVideoFile() {
	
	var post_data = false;
	var preventDefault = false;
	
	if(arguments.length>0) {
		
		for(var a in arguments) {
			
			switch(typeof arguments[a]) {
			
			case 'object':
				post_data = arguments[a];
				break;
			case 'boolean':
				preventDefault = arguments[a];
				break;
			}
			
		}
		
	}
	
	$('body').append("<div class='modal  hide' id='video-upload-modal'><div class='alert'>Loading ....</div></div>");
	
	var modal = $("#video-upload-modal");
	
	modal.modal({'backdrop':'static'});
	
	modal.on('show',function() { 
		
		var o ={
				
				"url":"/media_files/upload_video_modal/",
				"success":function(d) { 
					
					$("#video-upload-modal").html(d);
					
				}
				
			};
		
		if(post_data) o.data = post_data;
		
		if(!preventDefault) {
			
			$(document).bind('videoFileUploadComplete',function(e,d) { 
				
				if(!d.MediaFile.id) {
					
					alert('There was an error uploading, refresh and try again');
					return false;
					
				}
				
				document.location.href = '/media_files/inspect/'+d.MediaFile.id;
				
				
			});
			
		}
		
		$.ajax(o);
		
		
	});
	
	modal.on('hidden',function() { 
		
		$(document).unbind('videoFileUploadComplete');
		
		$("#video-upload-modal").remove();
		
	});
	
	modal.modal('show');
	
}

function initBootstrap() {

	$("table:not([class])").addClass('table').addClass('table-striped').addClass('table-bordered').addClass("table-hover");

	$('.index table.table th a.asc').parent().prepend($("<i class='icon-arrow-down' />"));
	
	$('.index table.table th a.desc').parent().prepend($("<i class='icon-arrow-up' />"));

	//$('.index table td.actions').addClass('btn-toolbar');
	
	$('.index table td.actions a:not([class])').each(function(d) { 

		$(this).addClass('btn btn-small');
		
		var txt = $(this).text();

		var icon = false;

		switch(true) {

			case /(edit)/i.test(txt): icon = 'icon-edit icon-white'; $(this).addClass('btn-primary'); 
					break;
			case /(delete)/i.test(txt): icon = 'icon-remove-sign icon-white'; $(this).addClass('btn-danger'); 
				break; //icon-eye-open
			case /(view)/i.test(txt): icon = 'icon-eye-open icon-white'; $(this).addClass('btn-info'); 
				break; //
		}

		if(icon) {

			$(this).prepend("<i class='"+icon+"'></i> ");
			
		}
		

	});


	$('.adminPager li.active').each(function() { 

		$(this).html("<a>"+$(this).text()+"</a>");
		
	});

	
	
	$('div.actions ul').addClass("nav nav-pills");

	$("form .controls").has("input[type=checkbox]").each(function() { 

		var $p = $(this).parent();

		var $l = $p.find("label");

		$p.find('input').each(function() { 

			$(this).attr("class","").appendTo($l);

		});

		$l.addClass("checkbox");

	});

	$("#successMessage:not([class*=alert])").addClass("alert-success alert").append('<button class="close" data-dismiss="alert">×</button>');
	$("#errorMessage:not([class*=alert])").addClass("alert-error alert").append('<button class="close" data-dismiss="alert">×</button>');
	$("#flashMessage:not([class*=alert])").addClass("alert-info alert").append('<button class="close" data-dismiss="alert">×</button>');

}


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


