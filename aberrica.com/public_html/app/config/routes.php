<?php 

//article routes
/*
Router::connect(
    '/:controller/:year/:month/:day/:uri',
    array('action' => 'index', "uri"=>null),
    array(
        'year' => '[12][0-9]{3}',
        'month' => '0[1-9]|1[012]',
        'day' => '0[1-9]|[12][0-9]|3[01]',
    	"uri"=>'[a-z\-\.][\.][a-z\.\-]'
    )
);
*/

##################
# HOME CONTROLLER
##################

Router::connect("/",array("controller"=>"articles","action"=>"day"));


#################
# ARTICLE MAGIC
#################
//a post
Router::connect(
    '/:year/:month/:day/:uri',
    array('controller'=>'articles','action' => 'view'),
    array(
        'year' => '[12][0-9]{3}',
        'month' => '0[1-9]|1[012]',
        'day' => '0[1-9]|[12][0-9]|3[01]',
    	'uri'=>'[A-Za-z0-9\-\.]{1,}'
    )
);


//the day
Router::connect(
    '/:year/:month/:day',
    array('controller'=>'articles','action' => 'day'),
    array(
        'year' => '[12][0-9]{3}',
        'month' => '0[1-9]|1[012]',
        'day' => '0[1-9]|[12][0-9]|3[01]'
    )
);

//the month
Router::connect(
    '/:year/:month',
    array('controller'=>'articles','action' => 'month'),
    array(
        'year' => '[12][0-9]{3}',
        'month' => '0[1-9]|1[012]'
    )
);

###################
# Category Magic
###################

Router::connect(
		"/category/:uri",
		array("controller"=>"category","action"=>"index"),
		array(
		
			"uri"=>'[a-zA-Z0-9\-\.]{1,}'
		
		)
);




?>