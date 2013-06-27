<?php 

ClassRegistry::init("MediaFile");

$ll_url = "http://berrics.vo.llnwd.net/o45/";

$poster = $this->Media->mediaThumbSrc(array(

	"MediaFile"=>$MediaFile,
	"w"=>$opts['width']

));

$videoOps = array(

"controls"=>1,
"poster"=>$poster,
"preload"=>"none",
//"autoplay"=>"false",
"class"=>"html-video-player"

);

if(!empty($MediaFile['preroll_label'])) $videoOps['data-preroll'] = urlencode(MediaFile::formatVastUrl($MediaFile['preroll_label']));
if(!empty($MediaFile['postroll_label'])) $videoOps['data-postroll'] = urlencode(MediaFile::formatVastUrl($MediaFile['postroll_label']));


$ops = "";

foreach($videoOps as $k=>$v) {

	$ops .= "{$k}='{$v}' ";

}

?>
<video <?php echo $ops; ?> >
	<?php if (!empty($MediaFile['limelight_file'])): ?>
	<source src="<?php echo $ll_url.$MediaFile['limelight_file']; ?>" type="video/mp4">
	<?php endif; ?>
	<?php if (!empty($MediaFile['limelight_file_ogv'])): ?>
	<source src="<?php echo $ll_url.$MediaFile['limelight_file_ogv']; ?>" type="video/ogv">
	<?php endif; ?>
</video>