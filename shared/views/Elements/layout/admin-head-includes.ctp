<?php
echo $this->Html->meta('icon');

echo $this->Html->css(array(
		'bootstrap',
		'main-v3',
		'bootstrap-responsive',
		'top-nav',
		'ui-lightness/jquery-ui-1.8.10.custom.css',
		'ui-lightness/jquery-ui-timepicker.css',
		"token-input.css",
		"token-input-mac.css"

));
echo $this->Html->script(array(
		"https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js",
		"https://connect.facebook.net/en_US/all.js",
		"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
		"jquery.form",
		"jquery.ui.timepicker-0.0.8.js",
		"jquery.tokeninput.js",
		"top-nav",
		"/jw/jwplayer.js",
		"swfupload/swfupload.js",
		'bootstrap',
		"admin"
));