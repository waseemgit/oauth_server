<?php
class authorize 
{
	public function clientExists($client_id,$client_secret,$db)
	{
		$sql	=	"SELECT COUNT(*) as total FROM users WHERE client_id = :client_id AND client_secret = :client_secret";			
		$stmt 	= $db->prepare($sql);
		$stmt->bindParam(':client_id'		, $client_id);
		$stmt->bindParam(':client_secret'	, $client_secret);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                
                
		$total		=	$result['total'];
		if($total>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function updateClientCode($client_id,$token,$db)
	{
            $sql    = "INSERT INTO 
                        access_tokens
                        SET access_token = :access_token,
                            client_id    = :client_id,
                            expires      = DATE_ADD( NOW( ) , INTERVAL ".TOKEN_EXPIRY_TIME." DAY_MINUTE )";
                
		
            $stmt 	=  $db->prepare($sql);
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':access_token', $token);		
            return $stmt->execute();
	}
        public function tokenMatched($client_id,$access_token,$db)
	{
            $sql	=	"SELECT COUNT(*) as total FROM access_tokens 
					WHERE client_id = :client_id 
                                        AND
					access_token 	= :access_token
                                        AND
                                        expires > NOW()";	
								
            $stmt 	= $db->prepare($sql);
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':access_token', $access_token);		
            $stmt->execute();
            $result = 	$stmt->fetch(PDO::FETCH_ASSOC);
            $total	=	$result['total'];
            if($total>0)
            {
                    return true;
            }
            else
            {
                    return false;
            }
	}
}
?>
