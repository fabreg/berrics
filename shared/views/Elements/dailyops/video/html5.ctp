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
"preload"=>0
//"autoplay"=>"false"

);

if(!empty($MediaFile['preroll_label'])) $videoOps['preroll'] = urlencode(MediaFile::formatVastUrl($MediaFile['preroll_label']));


$ops = "";

foreach($videoOps as $k=>$v) {

	$ops .= "{$k}='{$v}' ";

}

?>
<video <?php echo $ops; ?> >
	<?php if (!empty($MediaFile['limelight_file'])): ?>
	<source src="<?php echo $ll_url.$MediaFile['limelight_file']; ?>" type="video/mp4">
	<?php endif; ?>
</video>