<?php
class answers 
{
	
    public function create($db,$params)
    {
        
        $title          = $params['title'];	
        $description	= $params['description'];
        $created_by	= $params['created_by'];
                
        $sql	=  "INSERT INTO answers 
                                SET 
                                    title           =:title,
                                    description     =:description,
                                    created_by      =:created_by,
                                    date_created    =NOW()";	

        $stmt 	= $db->prepare($sql);
        $stmt->bindParam(':title'		, $title);
        $stmt->bindParam(':description'		, $description);
        $stmt->bindParam(':created_by'		, $created_by);
        
        if($stmt->execute())
        {
            return $db->lastInsertId();
        }
        else
        {
            echo 'Query Error';exit;
        }
            
        

    }
    public function getAllAnswers($db)
    {
        
        $sql	=  "SELECT  a.title,
                            a.created_by,
                            a.date_created AS created_at,
                            (
                                SELECT COUNT(*) FROM comments WHERE answer_id=a.id
                            ) AS total_comments   
                        FROM answers a ORDER BY a.date_created DESC";	

        $stmt 	= $db->prepare($sql);
        $stmt->execute();
        $arr_answers=array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $arr_answers[]=$row;
        }
        return $arr_answers;
        

    }
    
    public function getRecentAnswers($db,$client_id,$access_token)
    {
        
        $sql	=  "SELECT  a.id,
                            a.title,
                            a.description                            
                        FROM answers a ORDER BY a.date_created DESC LIMIT ".RECENT_ANSWERS_LIMIT;	

        $stmt 	= $db->prepare($sql);
        $stmt->execute();
        $arr_answers=array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $uri=$this->getAnswerDetailURI($row['id'],$client_id,$access_token);
            $arr_answers[]=array(
                                    'title'         =>  $row['title'],
                                    'description'   =>  $row['description'],
                                    'uri'           =>  $uri,
                                );
            
        }
        return $arr_answers;
        

    }
    public function getMostSearchedAnswers($db,$client_id,$access_token)
    {
        
        $sql	=  "SELECT  a.id,
                            a.title,
                            a.description                            
                        FROM answers a ORDER BY a.search_count DESC LIMIT ".MOST_SEARCHED_ANSWERS_LIMIT;	

        $stmt 	= $db->prepare($sql);
        $stmt->execute();
        $arr_answers=array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $uri=$this->getAnswerDetailURI($row['id'],$client_id,$access_token);
            $arr_answers[]=array(
                                    'title'         =>  $row['title'],
                                    'description'   =>  $row['description'],
                                    'uri'           =>  $uri,
                                );
            
        }
        return $arr_answers;
        

    }
    
    public function searchAnswers($db,$search_string,$client_id,$access_token)
    {
        
         $sql	=  "SELECT  a.id,
                            a.title,
                            a.description
                        FROM answers a 
                        WHERE a.title LIKE '".$search_string."%'";	

        $stmt 	= $db->prepare($sql);
        $stmt->execute();
        $arr_answers    =   array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $uri=$this->getAnswerDetailURI($row['id'],$client_id,$access_token);
            $arr_answers[]=array(
                                    'answer_id'     =>  $row['id'],
                                    'title'         =>  $row['title'],
                                    'description'   =>  $row['description'],
                                    'uri'           =>  $uri,
                                );
        }
        return $arr_answers;
    }
    
    
    public function getAnswerComments($answer_id,$db)
    {
        $sql	=	"SELECT c.id as comment_id,
                                c.comment as text,
                                su.name as created_by,
                                c.date_created 
                        FROM answers a
                        LEFT JOIN comments c ON a.id=c.answer_id
                        LEFT JOIN system_users su ON su.id=c.created_by
                        WHERE a.id=:answer_id";	
        
        $stmt 	= $db->prepare($sql);
        $stmt->bindParam(':answer_id'		, $answer_id);
        $stmt->execute();
        
        $arr    =   array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            
            $arr[]=array(
                            'text'        =>  $row['text'],
                            'createdBy'   =>  $row['created_by'],
                            'createdAt'   =>  $row['date_created'],
                            'files' => $this->getCommentFiles($row['comment_id'], $db)
                        );
        }
        return $arr;
        

    }
    public function getAnswerFiles($answer_id,$db)
    {
        $module_type = MODULE_TYPE_ID_ANSWERS; //For Answers Module Type is 2	
        $sql	= "SELECT at.file_name FROM answers a
                        LEFT JOIN attachments at ON (at.module_id=a.id AND at.module_type=:module_type)
                        WHERE a.id=:answer_id";	

        $stmt 	= $db->prepare($sql);
        $stmt->bindParam(':module_type'		, $module_type);
        $stmt->bindParam(':answer_id'		, $answer_id);
        $stmt->execute();
        $arr    =   array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $uri=$this->filesURI($row['file_name']);
            $arr[]=array(
                                    'fileName'  =>  $row['file_name'],
                                    'fileURI'   =>  $uri
                                );
        }
        return $arr;

    }
    public function addAnswerFiles($answer_id,$params,$db)
    {
        
        $module_type    = MODULE_TYPE_ID_ANSWERS; //For Answers Module Type is 2	
        
        $extention      = $params['extention'];	
        $file_size	= $params['file_size'];
        $file_name	= $params['file_name'];
        $answer_id	= $params['answer_id'];
        
                
                
        $sql	= "INSERT INTO attachments 
                                SET 
                                module_id       =:answer_id,
                                module_type     =:module_type,
                                file_extension  =:file_extension,
                                file_size       =:file_size,
                                file_name       =:file_name,
                                date_created    =NOW()";          

        $stmt 	= $db->prepare($sql);
        $stmt->bindParam(':answer_id'		, $answer_id);
        $stmt->bindParam(':module_type'		, $module_type);       
        $stmt->bindParam(':file_extension'	, $extention);
        $stmt->bindParam(':file_size'		, $file_size);
        $stmt->bindParam(':file_name'		, $file_name);        
        $stmt->execute();

    }
    
    function getCommentFiles($comment_id,$db)
    {
        $module_type = MODULE_TYPE_ID_COMMENTS; //For Comments Module Type is 1	
        $sql	= "SELECT at.file_name FROM comments c
                        LEFT JOIN attachments at ON (at.module_id=c.id AND at.module_type=:module_type)
                        WHERE c.id=:comment_id";	

        $stmt 	= $db->prepare($sql);
        $stmt->bindParam(':module_type'		, $module_type);
        $stmt->bindParam(':comment_id'		, $comment_id);
        $stmt->execute();
        $arr    =   array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $uri=$this->filesURI($row['file_name']);
            $arr[]=array(
                                    'fileName'  =>  $row['file_name'],
                                    'fileURI'   =>  $uri
                                );
        }
        return $arr;

    }
    
    public function getAnswerDetail($db,$answer_id,$client_id,$access_token)
    {
        
         $sql	=  "SELECT  a.id as answer_id,
                            a.title,
                            a.description,
                            a.date_created,
                            su.name as created_by
                        FROM answers a 
                        LEFT JOIN system_users su ON su.id=a.created_by
                        WHERE a.id =:answer_id";	

        $stmt 	= $db->prepare($sql);
        $stmt->bindParam(':answer_id'		, $answer_id);
        $stmt->execute();
        $arr_answers    =   array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $arr_answers[]=array(
                                    'title'     =>  $row['title'],
                                    'content'   =>  $row['description'],
                                    'createdBy' =>  $row['created_by'],
                                    'createdAt' =>  $row['date_created'],
                                    'files'     =>  $this->getAnswerFiles($row['answer_id'], $db),
                                    'comments'  => $this->getAnswerComments($row['answer_id'], $db)
                                );
        }
        return $arr_answers;
    }
    
    public function updateSearchCount($db,$answer_id)
    {
        
         $sql	=  "UPDATE answers SET search_count=search_count+1
                        WHERE id =:answer_id";	

        $stmt 	= $db->prepare($sql);
        $stmt->bindParam(':answer_id'		, $answer_id);
        return $stmt->execute();
    }
    
    public function getAnswerDetailURI($answer_id,$client_id,$access_token)
    {
        $uri=  str_replace('{answer_id}'    , $answer_id    , ANSWER_DETAIL_URI);
        $uri=  str_replace('{client_id}'    , $client_id    , $uri);
        $uri=  str_replace('{access_token}' , $access_token , $uri); 
        $uri=   BASE_URL.$uri;
        return $uri;
    }
    public function filesURI($file_name)
    {
        $uri    =   BASE_URL.'/'.UPLOADS_DIRECTORY.'/'.$file_name;
        return $uri;
    }

}
?>
