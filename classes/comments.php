<?php
class comments 
{
	
    public function create($db,$params)
    {
        
        $comment        = $params['comment'];	
        $answer_id	= $params['answer_id'];
        $created_by	= $params['created_by'];
                
        $sql	=  "INSERT INTO comments 
                                SET 
                                    comment       =:comment,
                                    answer_id     =:answer_id,
                                    created_by    =:created_by,
                                    date_created  =NOW()";	

        $stmt 	= $db->prepare($sql);
        $stmt->bindParam(':comment'		, $comment);
        $stmt->bindParam(':answer_id'		, $answer_id);
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
    public function addCommentFiles($comment_id,$params,$db)
    {
        
        $module_type    = MODULE_TYPE_ID_COMMENTS; //For Comments Module Type is 1	
        
        $extention      = $params['extention'];	
        $file_size	= $params['file_size'];
        $file_name	= $params['file_name'];
        $comment_id	= $params['comment_id'];
        
                
                
        $sql	= "INSERT INTO attachments 
                                SET 
                                module_id       =:comment_id,
                                module_type     =:module_type,
                                file_extension  =:file_extension,
                                file_size       =:file_size,
                                file_name       =:file_name,
                                date_created    =NOW()";          

        $stmt 	= $db->prepare($sql);
        $stmt->bindParam(':comment_id'		, $comment_id);
        $stmt->bindParam(':module_type'		, $module_type);       
        $stmt->bindParam(':file_extension'	, $extention);
        $stmt->bindParam(':file_size'		, $file_size);
        $stmt->bindParam(':file_name'		, $file_name);        
        $stmt->execute();

    }
    

}
?>
