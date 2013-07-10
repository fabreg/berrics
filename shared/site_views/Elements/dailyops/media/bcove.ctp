<?php


	//check to see if we have the bcURL
	
	$bc_url = $MediaFile['brightcove_url'];
	
	if(empty($bc_url)) {
		
		//we gotta do an API call to brightcove to ge the URL
		
		$bc = BCAPI::instance();
		
		$bc_data = $bc->bc->find("videobyid",array("video_id"=>$MediaFile['brightcove_id']));
		
		$bc_url = $bc_data->FLVURL;
		
		//die(pr($bc_data));
		
	}
	

	echo $bc_url;
?>

<div id="vid-container-<?php echo $MediaFile['id']; ?>">Loading the player ...</div>

<script type="text/javascript">
    jwplayer("vid-container-<?php echo $MediaFile['id']; ?>").setup({
	"controlbar":"bottom",   
        file: "<?php echo $bc_url; ?>",
        height: <?php echo $MediaFile['height']; ?>,
        width: <?php echo $MediaFile['width']; ?>,
        'players': [
					{type: 'flash', src: '/jw/player.swf'},
                    {type: 'html5'},
                    {type: 'download'}
                ],
        events: {
            onComplete: function() {
                document.getElementById("status").innerHTML = "That's all folks!";
            }
        },
        "image":"http://img01.theberrics.com/video/stills/<?php echo $MediaFile['file_video_still']; ?>",
        "provider":"http",
        "allowFullscreen":false,
        "usefullscreen":false
    });
</script>