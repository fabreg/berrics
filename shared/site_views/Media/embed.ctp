<?php



?>
var out = '';
out += '<object width="<?php echo $width; ?>" height="<?php echo $height; ?>" id="flash_185415333" type="application/x-shockwave-flash" data="http://theberrics.com/swf/BerricsPlayer.swf?time=0.29067293530575955">';
out += '<param value="media_file_id=<?php echo $media['MediaFile']['id']; ?>&amp;pre_roll=0&amp;post_roll=0&amp;videoAspectRatio=1" name="flashVars">';
out += '<param value="opaque" name="wmode"><param value="#000000" name="bgcolor">';
out += '<param value="true" name="allowfullscreen">';
out += '<param value="http://theberrics.com/swf/BerricsPlayer.swf?time='+Math.random()+'" name="movie">';
out += '</object>';
document.write(out);