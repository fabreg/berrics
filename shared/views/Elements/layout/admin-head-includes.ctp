<?php
echo $this->Html->meta('icon');

echo $this->Html->css(array(
		
		'main-v3',
		'//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css',
		'font-awesome.min',
		
		'top-nav',
		'//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/ui-lightness/jquery-ui.css',
		'ui-lightness/jquery-ui-timepicker.css',
		"token-input.css",
		"token-input-mac.css"

));
echo $this->Html->script(array(
		"//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js",
		"//connect.facebook.net/en_US/all.js",
		"//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js",
		"jquery.form",
		"jquery.ui.timepicker-0.0.8.js",
		"jquery.tokeninput.js",
		"top-nav",
		"/jw/jwplayer.js",
		"swfupload/swfupload.js",
		//'bootstrap',
		'//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js',
		"admin"
));

?>
<script type="text/javascript">
	//$(document).on('touchstart.dropdown', '.dropdown-menu', function(e) { e.stopPropagation(); });
</script>