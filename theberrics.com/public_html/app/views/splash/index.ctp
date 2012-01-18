<?php 

$p = $page['SplashPage'];

$this->set(array(

	"title_for_layout"=>$p['page_title'],
	"meta_k"=>$p['meta_keywords'],
	"meta_d"=>$p['meta_description']

));

echo $p['body_content'];

?>

<div class='comments' style='width:720px; margin:auto; padding:1px; padding-top:40px;'>
	<div class='facebook'>
		<div>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=128870297181216";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		</div>		
	</div>
	<div style='clear:both;'></div>
</div>