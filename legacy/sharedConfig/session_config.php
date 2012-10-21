<?php  
/** 
 * Setup the variables needed for initializing the Session model. 
 * This is a straight copy from cake_session.php. 
 */ 
$modelName = Configure::read('Session.model'); 
$database = Configure::read('Session.database'); 
$table = Configure::read('Session.table'); 

if (empty($database)) { 
    $database = 'default'; 
} 

$settings = array( 
    'class' => 'Session', 
    'alias' => 'Session', 
    'table' => 'cake_sessions', 
    'ds' => $database 
); 
if (!empty($modelName)) { 
    $settings['class'] = $modelName; 
} 
if (!empty($table)) { 
    $settings['table'] = $table; 
} 
/** 
 * Load the Session Model. 
 */  
ClassRegistry::init($settings); 

/** 
 * Setup any custom ini settings needed. 
 */ 
if (empty($_SESSION)) { 
    if ($iniSet) { 
        ini_set('session.use_trans_sid', 0); 
        ini_set('url_rewriter.tags', ''); 
        ini_set('session.save_handler', 'user'); 
        ini_set('session.serialize_handler', 'php'); 
        ini_set('session.use_cookies', 1); 
        ini_set('session.name', Configure::read('Session.cookie')); 
        ini_set('session.cookie_lifetime', ((60*60)*12)); 
        ini_set('session.cookie_path', $this->path); 
        ini_set('session.auto_start', 0); 
        ini_set('session.referer_check', null); 
    } 
} 

/** 
 * Tell PHP what functions to run for the various session methods. 
 * This is a straight copy from cake_session.php. 
 */                  
session_set_save_handler( 
    array('CakeSession', '__open'), 
    array('CakeSession', '__close'), 
    array('CakeSession', '__read'), 
    array('CakeSession', '__write'), 
    array('CakeSession', '__destroy'), 
    array('CakeSession', '__gc') 
); 

/** 
 * The trick: tell Cake that we're actually using database session handling 
 * from this point on. 
 */  
Configure::write('Session.save', 'database'); 
?> 