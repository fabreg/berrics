<?php
/**************************
*
* 1 AND 1
* SERVER D
* s265767729.onlinehome.us
*
**************************/
@ $db = mysql_connect('10.181.91.233', 'john', '19Berrics82') or die('Could not connect.');
$dbnamez = "UNIFIED";


if (!$db) 

	die("no db");

if(!mysql_select_db($dbnamez,$db))

 	die("No database selected.");

if(!get_magic_quotes_gpc())

{

  $_GET = array_map('mysql_real_escape_string', $_GET); 

  $_POST = array_map('mysql_real_escape_string', $_POST); 

  $_COOKIE = array_map('mysql_real_escape_string', $_COOKIE);

}

else

{  

   $_GET = array_map('stripslashes', $_GET); 

   $_POST = array_map('stripslashes', $_POST); 

   $_COOKIE = array_map('stripslashes', $_COOKIE);

   $_GET = array_map('mysql_real_escape_string', $_GET); 

   $_POST = array_map('mysql_real_escape_string', $_POST); 

   $_COOKIE = array_map('mysql_real_escape_string', $_COOKIE);

}

?>