<?php



if(preg_match('/(\/img\/|\/pho\/)/',$_SERVER['REQUEST_URI'])) {
	
	header('Location: http://img.theberrics.com/images'.$_SERVER['REQUEST_URI']);
	exit();
	
}

if($_GET['url'] == "/") {
	
	App::import("Lib","SplashRoute",array("file"=>"routes/SplashRoute.php"));
	
	Router::connect(
		"/",
		array("controller"=>"splash","action"=>"index"),
		array(
			"routeClass"=>"SplashRoute"
		)
	);
	
}

Router::connect("/t-shirts",array("controller"=>"apparel","action"=>"index"));

Router::connect("/preview/*",array("controller"=>"splash","action"=>"preview"));

//grab legacy links
/////DAILY OPS POST
Router::connect("/dailyopspost.php",array("controller"=>"dailyops","action"=>"legacy"));

//the canteen
if(preg_match('/^(\/canteen)/i',$_SERVER['REQUEST_URI'])) {
	
	Router::connect("/canteen/:uri",
					array("controller"=>"canteen_category","action"=>"index"),
					array(
						"uri"=>"[a-z\-_0-9]{3,}.html"
					)
	);
	
	Router::connect("/canteen/item/:uri",
					array(
						"controller"=>"canteen_product",
						"action"=>"view"
					),
					array(
						"uri"=>"[a-zA-Z0-9\-_]{4,}.html"
					)
	);
	
	Router::connect("/canteen/product/:action",array("controller"=>"canteen_product","action"=>null));
	//cart

	
	
	//promo
	Router::connect("/canteen/promo",array("controller"=>"canteen_promo","action"=>"index"));
	
}

//turn on live temporarily
Router::connect("/canteen/cart/:action/*",array("controller"=>"canteen_cart"));
Router::connect("/canteen/cart",array("controller"=>"canteen_cart"));


//tags
if(preg_match('/\/tags/',$_SERVER['REQUEST_URI'])) {
	
	Router::connect("/tags/paginate_posts/*",array("controller"=>"tags","action"=>"paginate_posts"));
	
	
	Router::connect("/tags/:letter",array(
	
		"controller"=>"tags",
		"action"=>"cloud"
	
	),array(
	
		"letter"=>"[a-z0-9]{1}"
	
	));
	
	
	//tag drill down
	Router::connect("/tags/:slug/*",array(
	
		"controller"=>"tags",
		"action"=>"index"
		
	),array(
	
	
		"slug"=>"[a-z\-_0-9]{2,}"
	
	
	));
	
	Router::connect("/tags/*",array(
	
		"controller"=>"tags",
		"action"=>"cloud_index"
	
	));
	
}

//profiles
if(preg_match('/\/profiles/',$_SERVER['REQUEST_URI'])) {
	
	//App::import("Lib","ProfilesRoute",array("file"=>"routes/ProfilesRoute.php"));
	
	Router::connect("/profiles",array("controller"=>"profiles","action"=>"index"));
	
	Router::connect("/profiles/:uri",
		array(
			"controller"=>"profiles",
			"action"=>"view"
		));
	
	Router::connect("/profiles/:action/:uri",
		array(
			"controller"=>"profiles"
		)
	);
	
	
}

//accounts
if(preg_match('/\/account/',$_SERVER['REQUEST_URI'])) {
	
	Router::connect("/account/canteen/status/*",array("controller"=>"account","action"=>"canteen_order_status"));
	
}


//the dailyops route. This route will define which controller "/dailyops" will use
App::import("Lib","HomeRoute",array("file"=>"routes/HomeRoute.php"));
//the day
Router::connect(
    '/:year/:month/:day',
    array('controller'=>'dailyops','action' => 'index'),
    array(
        'year' => '[12][0-9]{3}',
        'month' => '0[1-9]|1[012]',
        'day' => '0[1-9]|[12][0-9]|3[01]',
    	"routeClass"=>"HomeRoute"
    )
);

Router::connect(
    '/dailyops',
    array('controller'=>'dailyops','action' => 'index'),
    array(
        
    	"routeClass"=>"HomeRoute"
    )
);

//Dailyops Sections
App::import("Lib","DailyopsRoute",array("file"=>"routes/DailyopsRoute.php"));
Router::connect("/:section/:uri/*",
	array("controller"=>"dailyops","action"=>"section","uri"=>null),
	array(
	
		"routeClass"=>"DailyopsRoute",
		"section"=>"[a-z0-9\-]{3,}",
		"uri"=>"[a-zA-Z0-9\.\-_]{5,}"
		
	)
);

Router::connect(
		"/:file",
		array("controller"=>"static_files","action"=>"view"),
		array(
		
		
			"file"=>"[a-zA-Z0-9\-_]{5,}.html"
		
		)
);