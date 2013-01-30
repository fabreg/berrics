<?php 

$Dailyop = ClassRegistry::init("Dailyop");

$content = $Dailyop->publicContentCalendar();

echo $this->element("dailyops/calendar",array("content"=>$content));

?>