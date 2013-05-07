<?php 

//setup truncation defaults
if(!isset($max_title)) $max_title = 24;
if(!isset($max_sub_title)) $max_sub_title = 36;
if(!isset($max_text)) $max_text = 65;


?>
<table class="post-table" cellspacing="0">
	<tbody class="content">
		<?php foreach ($posts as $k => $post): ?>
			<?php 
				$data = compact("post","max_text","max_title","max_sub_title");
				switch (strtolower($post['Dailyop']['post_template'])) {
					case 'news':
					case 'interrogation':
					case 'news-large':
						echo $this->element("dailyops/post-table/news-tr",$data);
						break;
					
					default:
						echo $this->element("dailyops/post-table/post-tr",$data);
						break;
				}

			 ?>
		<?php endforeach ?>
	</tbody>
</table>