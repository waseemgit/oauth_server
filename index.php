<?php
ini_set('display_errors',TRUE);
error_reporting(E_ALL);
include('includes/config.php'); 
include('autoload.php'); 
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader(); 
$app = new \Slim\Slim(); 



$app->post('/authorize',  function() use ($app) 
{	try
	{	
            
            $client_id      =   $app->request()->params('client_id');	
            $client_secret  =   $app->request()->params('client_secret');
            
            $objGeneral     =   new general();	
            $encrypted      = 	$objGeneral->encrypt(microtime(), ENCRYPTION_KEY);
            $token          =	md5($encrypted);

            if($client_id   ==	'')
            {
                    $arr = array('error' => 'Client ID is missing');
                    echo $objGeneral->json($arr);
                    exit;
            }

            if($client_secret	==	'')
            {
                    $arr = array('error' => 'Client Secret missing');
                    echo $objGeneral->json($arr);
                    exit;
            }
            
            $db		=	db::getInstance();
            $objAuthorize	=	new authorize();

            if($objAuthorize->clientExists($client_id,$client_secret,$db))// authorized
            {
                    if(!$objAuthorize->updateClientCode($client_id,$token,$db))
                    {
                            $arr = array('error' => 'Query Error');
                            echo $objGeneral->json($arr);
                            exit;
                    }
                    $arr=array('access_token'=>$token);
                    echo  $objGeneral->json($arr);
                    exit;

            }
            else// Not authorized
            {
                    $arr=array('error'=>'Not authorized');
                    echo  $objGeneral->json($arr);
                    exit;

            }
	
	}
	catch(PDOException $e) 
	{
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});


$app->get('/answers/recent/:client_id/:access_token',  function($client_id,$access_token) use ($app) 
{
	try
	{	$objGeneral	=	new general();	
		if($client_id	==	'')
		{   
                    	
                    $arr = array('error' => 'Client ID is missing');
                    echo $objGeneral->json($arr);
                    exit;
		}
		
		if($access_token	==	'')
		{
                    
                    $arr = array('error' => 'Token missing');
                    echo $objGeneral->json($arr);
                    exit;
		}

		/****/
                $db		=	db::getInstance();
		$objAuthorize	=	new authorize();
		if(!$objAuthorize->tokenMatched($client_id,$access_token,$db))
                {
                    $arr=array('error'=>'Forbidden');
                    echo  $objGeneral->json($arr);
                    exit;
                }                
                /****/
                
                $objAnswers=new answers();
                echo  $objGeneral->json($objAnswers->getRecentAnswers($db,$client_id,$access_token));
                exit;
                
	
	}
	catch(PDOException $e) 
	{
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});

$app->get('/answers/search/:search_string/:client_id/:access_token',  function($search_string,$client_id,$access_token) use ($app) 
{
	try
	{	$objGeneral	=	new general();	        

		if($client_id	==	'')
		{   
                    	
                    $arr = array('error' => 'Client ID is missing');
                    echo $objGeneral->json($arr);
                    exit;
		}
		
		if($access_token	==	'')
		{
                    
                    $arr = array('error' => 'Token missing');
                    echo $objGeneral->json($arr);
                    exit;
		}

                if($search_string	==	'')
		{   
                    	
                    $arr = array('error' => 'Search String is missing');
                    echo $objGeneral->json($arr);
                    exit;
		}
		/****/
                $db		=	db::getInstance();
		$objAuthorize	=	new authorize();
		if(!$objAuthorize->tokenMatched($client_id,$access_token,$db))
                {
                    $arr=array('error'=>'Forbidden');
                    echo $objGeneral->json($arr);
                    exit;
                }                
                /****/
                
                $objAnswers=new answers();
                echo $objGeneral->json($objAnswers->searchAnswers($db,$search_string,$client_id,$access_token));
                exit;
                
	
	}
	catch(PDOException $e) 
	{
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});


$app->get('/answers/:client_id/:access_token',  function($client_id,$access_token) use ($app) 
{
	try
	{		
                $objGeneral	=	new general();	
		if($client_id	==	'')
		{
			$arr = array('error' => 'Client ID is missing');
			echo $objGeneral->json($arr);
			exit;
		}
		
		if($access_token	==	'')
		{
			$arr = array('error' => 'Token missing');
			echo $objGeneral->json($arr);
			exit;
		}

		/****/
                $db		=	db::getInstance();
		$objAuthorize	=	new authorize();
		if(!$objAuthorize->tokenMatched($client_id,$access_token,$db))
                {
                    $arr=array('error'=>'Forbidden');
                    echo $objGeneral->json($arr);
                    exit;
                }                
                /****/
                
                $objAnswers = new answers();
                echo  $objGeneral->json($objAnswers->getAllAnswers($db));
                exit;
                
	
	}
	catch(PDOException $e) 
	{
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});


$app->get('/answers/detail/:answer_id/:client_id/:access_token',  function($answer_id,$client_id,$access_token) use ($app) 
{	
    try
	{		
                $objGeneral	=	new general();	
		if($client_id	==	'')
		{
			$arr = array('error' => 'Client ID is missing');
			echo $objGeneral->json($arr);
			exit;
		}
		
		if($access_token	==	'')
		{
			$arr = array('error' => 'Token missing');
			echo $objGeneral->json($arr);
			exit;
		}
                if($answer_id	==	'')
		{
			$arr = array('error' => 'Answer ID is missing');
			echo $objGeneral->json($arr);
			exit;
		}
		/****/
                $db		=	db::getInstance();
		$objAuthorize	=	new authorize();
		if(!$objAuthorize->tokenMatched($client_id,$access_token,$db))
                {
                    $arr=array('error'=>'Forbidden');
                    echo $objGeneral->json($arr);
                    exit;
                }                
                /****/
                
                $objAnswers = new answers();
                echo  $objGeneral->json($objAnswers->getAnswerDetail($db,$answer_id,$client_id,$access_token));
                exit;
                
	
	}
	catch(PDOException $e) 
	{
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});



$app->put('/answers/update_search_count/:answer_id/:client_id/:access_token',  function($answer_id,$client_id,$access_token) use ($app) 
{	
    try
	{		
                $objGeneral	=	new general();			
                
                if($client_id	==	'')
		{
			$arr = array('error' => 'Client ID is missing');
			echo $objGeneral->json($arr);
			exit;
		}
		
		if($access_token	==	'')
		{
			$arr = array('error' => 'Token missing');
			echo $objGeneral->json($arr);
			exit;
		}
                if($answer_id	==	'')
		{
			$arr = array('error' => 'Answer ID is missing');
			echo $objGeneral->json($arr);
			exit;
		}

		/****/
                $db		=	db::getInstance();
		$objAuthorize	=	new authorize();
		if(!$objAuthorize->tokenMatched($client_id,$access_token,$db))
                {
                    $arr=array('error'=>'Forbidden');
                    echo $objGeneral->json($arr);
                    exit;
                }                
                /****/
                
                $objAnswers = new answers();
                if($objAnswers->updateSearchCount($db,$answer_id))
                {
                    $arr=array('msg'=>'success');
                    echo $objGeneral->json($arr);
                    exit;
                }
                else 
                {
                    $arr=array('msg'=>'query_error');
                    echo $objGeneral->json($arr);
                    exit;
                }
                               
	
	}
	catch(PDOException $e) 
	{
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});

$app->get('/answers/most_searched/:client_id/:access_token',  function($client_id,$access_token) use ($app) 
{
	try
	{	$objGeneral	=	new general();	
		if($client_id	==	'')
		{   
                    	
                    $arr = array('error' => 'Client ID is missing');
                    echo $objGeneral->json($arr);
                    exit;
		}
		
		if($access_token	==	'')
		{
                    
                    $arr = array('error' => 'Token missing');
                    echo $objGeneral->json($arr);
                    exit;
		}

		/****/
                $db		=	db::getInstance();
		$objAuthorize	=	new authorize();
		if(!$objAuthorize->tokenMatched($client_id,$access_token,$db))
                {
                    $arr=array('error'=>'Forbidden');
                    echo  $objGeneral->json($arr);
                    exit;
                }                
                /****/
                
                $objAnswers=new answers();
                echo  $objGeneral->json($objAnswers->getMostSearchedAnswers($db,$client_id,$access_token));
                exit;
                
	
	}
	catch(PDOException $e) 
	{
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});



$app->post('/answers/create',  function() use ($app) 
{	
	// add exception  
	try
	{                      	
		$client_id	= $app->request()->params('client_id');											
		$access_token	= $app->request()->params('access_token');
                $params         = array(
                                            'title'         =>  $app->request()->params('title'),
                                            'description'   =>  $app->request()->params('description'),
                                            'created_by'    =>  $app->request()->params('created_by')                    
                                        );
                
                
                $objGeneral	= new general(); 
                
                if($client_id	==	'')
		{
			$arr = array('error' => 'Client ID is missing');
			echo $objGeneral->json($arr);
			exit;
		}
		
		if($access_token	==	'')
		{
			$arr = array('error' => 'Token missing');
			echo $objGeneral->json($arr);
			exit;
		}
                if($params['title']	==	'')
		{
			$arr = array('error' => 'Title is missing');
			echo $objGeneral->json($arr);
			exit;
		}                
                if($params['description']	==	'')
		{
			$arr = array('error' => 'Description is missing');
			echo $objGeneral->json($arr);
			exit;
		}
                if($params['created_by']	==	'')
		{
			$arr = array('error' => 'created_by is missing');
			echo $objGeneral->json($arr);
			exit;
		}
                
                /****/
                
                $db		=   db::getInstance();
		$objAuthorize	=   new authorize();
                
		if(!$objAuthorize->tokenMatched($client_id,$access_token,$db))
                {
                    $arr=array('error'=>'Forbidden');
                    echo  $objGeneral->json($arr);
                    exit;
                }                
                /****/
			
                $objAnswer=new answers();
                $answer_id =   $objAnswer->create($db,$params);
                
                
                if(isset($_FILES))
                {
                    for($i=0; $i<count($_FILES['file']['name']); $i++) 
                    {
                        $encrypted      = 	$objGeneral->encrypt(microtime(), ENCRYPTION_KEY);
                        $random_string  =	md5($encrypted);

                        $extention   =   pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                        $file_size   =   $_FILES['file']['size'][$i];//Bytes
                        $file_name   =   $random_string.".".$extention;
                        $tmpFilePath =   $_FILES['file']['tmp_name'][$i];
                        $params_file =   array();
                        $params_file =   array(
                                                'answer_id'   =>  $answer_id,
                                                'extention'   =>  $extention,
                                                'file_size'   =>  $file_size,
                                                'file_name'   =>  $file_name                    
                                            );
                        if ($tmpFilePath != "")
                        {
                            $newFilePath = UPLOADS_DIRECTORY."/" . $file_name;                        
                            if(move_uploaded_file($tmpFilePath, $newFilePath)) 
                            {
                                $objAnswer->addAnswerFiles($answer_id,$params_file,$db);
                            }
                        }
                    }
                }
               
                $arr    =   array(
                                    'msg'       =>  'success',
                                    'answer_id' =>  $answer_id
                                );
                echo  $objGeneral->json($arr);
                exit;
               
		
	}
	catch(PDOException $e) 
	{
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});		

$app->post('/comments/create',  function() use ($app) 
{	
	// add exception  
	try
	{                      	
		$client_id	= $app->request()->params('client_id');											
		$access_token	= $app->request()->params('access_token');
                $params         = array(
                                            'comment'     =>  $app->request()->params('comment'),
                                            'answer_id'   =>  $app->request()->params('answer_id'),
                                            'created_by'  =>  $app->request()->params('created_by')                    
                                        );
                
                $objGeneral	= new general(); 
                
                if($client_id	==	'')
		{
			$arr = array('error' => 'Client ID is missing');
			echo $objGeneral->json($arr);
			exit;
		}
		
		if($access_token	==	'')
		{
			$arr = array('error' => 'Token missing');
			echo $objGeneral->json($arr);
			exit;
		}
                if($params['comment']	==	'')
		{
			$arr = array('error' => 'Comment is missing');
			echo $objGeneral->json($arr);
			exit;
		}                
                if($params['answer_id']	==	'')
		{
			$arr = array('error' => 'answer_id is missing');
			echo $objGeneral->json($arr);
			exit;
		}
                if($params['created_by']	==	'')
		{
			$arr = array('error' => 'created_by is missing');
			echo $objGeneral->json($arr);
			exit;
		}
                
                /****/
                
                $db		=   db::getInstance();
		$objAuthorize	=   new authorize();
                
		if(!$objAuthorize->tokenMatched($client_id,$access_token,$db))
                {
                    $arr=array('error'=>'Forbidden');
                    echo  $objGeneral->json($arr);
                    exit;
                }                
                /****/
			
                $objComments    =   new comments();
                $comment_id     =   $objComments->create($db,$params);
                
                
                if(isset($_FILES))
                {
                    for($i=0; $i<count($_FILES['file']['name']); $i++) 
                    {
                        $encrypted      = 	$objGeneral->encrypt(microtime(), ENCRYPTION_KEY);
                        $random_string  =	md5($encrypted);

                        $extention   =   pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
                        $file_size   =   $_FILES['file']['size'][$i];//Bytes
                        $file_name   =   $random_string.".".$extention;
                        $tmpFilePath =   $_FILES['file']['tmp_name'][$i];
                        $params_file =   array();
                        $params_file =   array(
                                                'comment_id'  =>  $comment_id,
                                                'extention'   =>  $extention,
                                                'file_size'   =>  $file_size,
                                                'file_name'   =>  $file_name                    
                                            );
                        if ($tmpFilePath != "")
                        {
                            $newFilePath = UPLOADS_DIRECTORY."/" . $file_name;                        
                            if(move_uploaded_file($tmpFilePath, $newFilePath)) 
                            {
                                $objComments->addCommentFiles($comment_id,$params_file,$db);
                            }
                        }
                    }
                }
               
                $arr    =   array(
                                    'msg'       =>  'success',
                                    'comment_id' =>  $comment_id
                                );
                echo  $objGeneral->json($arr);
                exit;
               
		
	}
	catch(PDOException $e) 
	{
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});
$app->run();
