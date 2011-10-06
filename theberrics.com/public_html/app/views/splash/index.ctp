<?php 

$p = $page['SplashPage'];

$this->set(array(

	"title_for_layout"=>$p['page_title'],
	"meta_k"=>$p['meta_keywords'],
	"meta_d"=>$p['meta_description']

));



?>
<?php 

echo $p['body_content'];

?>
<?php 

	if($_SERVER['GEOIP_ADDR'] == '66.134.86.70'):

?>
<div class='comments' style='width:720px; margin:auto; padding:1px;margin-top:40px;'>
	<div class='facebook'>
		<div>
			<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
				<fb:comments css="http://theberrics.com/css/fbc.css" href='theberrics.com'></fb:comments>
			<script type="text/javascript">FB.init("4bf16033df99101e2722c24a2d165e82", "http://theberrics.com/xd-receiver.html");</script>
		</div>		
	</div>
	<div style='clear:both;'></div>
</div>
<?php 

	endif;

?>