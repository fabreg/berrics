<?php
header();
$this->ICal->create("The DailyOps","Upcoming Posts","US/Los_Angeles");
/*
$v = new vcalendar(array(

	"unique_id"=>"theberrics.com"

));

$v->setProperty( 'X-WR-CALNAME'
               , 'The DailyOps' );          // set some X-properties, name, content.. .
$v->setProperty( 'X-WR-CALDESC'
               , 'Content Calendar' );
$v->setProperty( 'X-WR-TIMEZONE'
               , 'US/Los_Angeles' );
*/
foreach($posts as $post) {
	
	$d = $post['Dailyop'];
	
	$name = $d['name'];
	
	$status = ":^)";
	
	if(!empty($post['Validate']['msg'])) {
		
		$status = strip_tags($post['Validate']['msg']);
		
	}
	
	if(!empty($d['sub_title'])) {
		
		$name .= " - ".$d['sub_title'];
		
	}
	/*
	$e = & $v->newComponent( 'vevent' );           // initiate a new EVENT
	$e->setProperty( 'categories'
	               , $post['DailyopSection']['name'] );                   // catagorize
	$e->setProperty( 'dtstart'
	               ,  2011, 06, 24, 19, 30, 00 );  // 24 dec 2006 19.30
	$e->setProperty( 'duration'
	               , 0, 0, 3 );                    // 3 hours
	$e->setProperty( 'description'
	               , $name );    // describe the event
	$e->setProperty( 'location'
	               , 'Home' );       
	
	*/
	
	$this->ICal->addEvent(
	
		$d['publish_date'],
		$d['publish_date'],
		$name,
		$status
	
	);
	
	
}


//$v->returnCalendar();
$this->ICal->render();
die();
?>