<?php 
//set the body element to be a one column body

$this->set("body_element","layout/v3/one-column");

//set the page title

$title_for_layout = "The Berrics - Interrogation: ".$post['Dailyop']['name'];

if(!empty($post['Dailyop']['sub_title'])) $title_for_layout .= " - ".$post['Dailyop']['sub_title'];

$this->set(compact("title_for_layout"));
	
?>
<div id="interrogation-view">
	<?php 

		foreach ($post['DailyopTextItem'] as $k => $item) {

			if($k == 0) continue;


			switch($item['text_content_style']) {

				default:
					echo $this->element("interrogation/".$item['text_content_style'],array("item"=>$item));
				break;

			}

			if($k == 1) echo $this->element("dailyops/posts/post-footer",array("dop"=>$post));

		}

	?>
</div>