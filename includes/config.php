<?php
define('HOST'               ,	'localhost'	);
define('USER_NAME'          ,	'root'		);
define('PASSWORD'           ,	'test'		);
define('DATABASE_NAME'      ,	'test_api'	);
define("ENCRYPTION_KEY"     , 	"321!@#$%^&*123");
define("BASE_DIRECTORY"     , 	"oauth_server"  );
define("TOKEN_EXPIRY_TIME"  , 10000           );//In Minutes
define("ANSWER_DETAIL_URI"  ,"/answers/detail/{answer_id}/{client_id}/{access_token}");
define("RECENT_ANSWERS_LIMIT",10);
define("MOST_SEARCHED_ANSWERS_LIMIT" , 10); 
define("MODULE_TYPE_ID_ANSWERS",2);//For Answers Module Type is 2	
define("MODULE_TYPE_ID_COMMENTS",1);//For Comments Module Type is 1	
define("UPLOADS_DIRECTORY","uploadFiles");//Files will upload in this folder

if(isset($_SERVER['HTTPS']))
{
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else
{
    $protocol = 'http';
}
$base_url=$protocol . "://" . $_SERVER['HTTP_HOST'] . "/" .BASE_DIRECTORY;
define("BASE_URL"	, 	$base_url);
?>
