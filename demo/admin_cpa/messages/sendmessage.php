<?php
if(isset($_POST['receivers']))
{
    	$usrs = $_POST['receivers'];
					foreach($usrs as $u)
					{
						        if($u != 'admin' && $u != 'all'){
								if(!getUserIdByUsername($u))
								{
											$error_inv = "Invalid Receiver";
											echo $error_inv;
											return;  
								}
								
								}

					    $receivers[] =  makesafe($u);	
									
					}
					
					
					
}else
{


/*if(!isset($_GET['receiver']))
{
   $error_inv = "Invalid Receiver";
   echo $error_inv;
   return;  
}*/

$receiver = makesafe($_GET['receiver']);




}
if(isset($_GET['subj']))
{
$subj = $_GET['subj'];
$subj = str_replace("RE: ","",$subj);
$subj = "RE: ".$subj;
}



if(isset($_POST['send']))
{

	$receiver = makesafe($_POST['receiver']);
 $receivers = $_POST['receivers']; 	
	$sender = 'admin';
	
	
	
	if(empty($receiver))
	{
		    echo "<b>Receiver is required.</b>";
      include("messages/compose.php");						
						return;
	}	
	
	if(empty($_POST['subject']) || empty($_POST['message']))
	{
   if(empty($_POST['subject']))
		{
		    echo "<b>Subject is required.</b>";
      include("messages/compose.php");						
						return;
		}elseif(empty($_POST['message']))
		{
			
		    echo "<b>Message is required.</b>";
  	   include("messages/compose.php");						
						return;
		}
			
			
	}
	
 

	
	

	
	if(!empty($receiver)){
		
		
		
	
	if(empty($_POST['subject']) || empty($_POST['message']) || empty($receiver))
	{
	    if(empty($receiver))
		{
		    $error_message = "Receiver is required.";
		}elseif(empty($_POST['subject']))
		{
		    $error_message = "Subject is required.";
		}elseif(empty($_POST['message']))
		{
		    $error_message = "Message is required.";
		}
		
	    
	   echo "<b>".$error_message."</b>"; 
	   include("messages/compose.php");
	   return;		
		
	
	}
	
	
	
	if($receiver != 'all'){
	$sql_user_check = mysql_query("SELECT * FROM users WHERE email_address = '$receiver' AND active = 1");
	if(!mysql_num_rows($sql_user_check))
	{
	   echo '<b>Invalid or Inactive receiver</b>';
	   include("messages/compose.php");
	   return; 	  
	}

		  $email = '';
		  $subject = trim($_POST['subject']);
		  $message = nl2br(trim($_POST['message']));																
												
		  $rm = mysql_fetch_object($sql_user_check);
		  $email = stripslashes($rm->email_address);

		  $fullname = ucfirst(stripslashes($rm->firstname))." ".ucfirst(stripslashes($rm->lastname));
		  

		  $message = str_replace('{USER_EMAIL}', $email, $message);	
          $message = str_replace('{FULLNAME}', $fullname, $message);																															
										
		  $subject = str_replace('{USER_EMAIL}', $email, $subject);					
          $subject = str_replace('{FULLNAME}', $fullname, $subject);				
		  $sep = sha1(date('r', time())).rand(0000,9999);		
				$headers  = 	 "From: \"".SITE_NAME."\" <".NOTIFICATION_EMAIL.">\r\n";
$headers .= "MIME-Version: 1.0\r\nContent-Type: multipart/alternative; boundary=\"PHP-mixed-$sep\"\r\n";								
				$headers .= "X-Mailer: PHP/". phpversion()."\r\n";			
										
$messageEmail = "--PHP-mixed-$sep
Content-type: text/html; charset=iso-8859-1
Content-Transfer-Encoding: 7bit

$message

--PHP-mixed-$sep--
";										
														
			

	if(mysql_query("INSERT INTO messages VALUES(NULL, 'admin', '$receiver', '".makesafe($subject)."', '".makesafe($message)."', NOW(), 0)"))
	{
	   
				$sent = 1;
				@mail($email, $subject, $messageEmail,  $headers);
	   
	}

	
	if($sent == 1)
	{
            echo '<b>message has been sent.</b>';	
			return;
	}else
	{
            echo '<b>An error occured while sending message.</b>';	
			return;
	}
	
	
		
	}	
	
	}else
	{
	    $ucount = 0;
		foreach($receivers as $receiver)
        {		
  
  
		  if($receiver != 'all'){
		  $sql_user_check = mysql_query("SELECT * FROM users WHERE email_address = '$receiver' AND active = 1");
		  if(!mysql_num_rows($sql_user_check))
		  {
					  echo '<b>Invalid or Inactive receiver</b>';
					  include("messages/compose.php");
					  return; 	  
		  }
  $subject = trim($_POST['subject']);
  			$message = nl2br(trim($_POST['message']));																							
  

  $email = '';
  $rm = mysql_fetch_object($sql_user_check);
  $email = stripslashes($rm->email_address);

  $fullname = ucfirst(stripslashes($rm->firstname))." ".ucfirst(stripslashes($rm->lastname));

  

  $message = str_replace('{USER_EMAIL}', $email, $message);	
  $message = str_replace('{FULLNAME}', $fullname, $message);																															
			  


  $subject = str_replace('{USER_EMAIL}', $email, $subject);					
  $subject = str_replace('{FULLNAME}', $fullname, $subject);		
  $sep = sha1(date('r', time())).rand(0000,9999);			
  $headers  = 	 "From: \"".SITE_NAME."\" <".NOTIFICATION_EMAIL.">\r\n";
  $headers .= "MIME-Version: 1.0\r\nContent-Type: multipart/alternative; boundary=\"PHP-mixed-$sep\"\r\n";								
  $headers .= "X-Mailer: PHP/". phpversion()."\r\n";			
			  
  $messageEmail = "--PHP-mixed-$sep
  Content-type: text/html; charset=iso-8859-1
  Content-Transfer-Encoding: 7bit
  
  $message
  
  --PHP-mixed-$sep--
  ";																
		  
					  
		  
		  if(mysql_query("INSERT INTO messages VALUES(NULL, 'admin', '$receiver', '".makesafe($subject)."', '".makesafe($message)."', NOW(), 0)"))
		  {
					  @mail($email, $subject, $messageEmail,  $headers);
					  $sent = 1;
					  
		  }
		 
		  
  
		  
		  
			  
		  }		
		  
		  
      }
					
			if($sent == 1)
			{
					echo '<b>message has been sent to selected users('.$ucount.').</b>';	
					return;
			}else
			{
					echo '<b>An error occured while sending message.</b>';	
					return;
				
			}					
					
					
	   	
	}

	






 if($receiver == 'all')
 {
	
	    $sql = mysql_query("SELECT * FROM users WHERE active = 1");
		if(mysql_num_rows($sql))
		{
		   while($row = mysql_fetch_array($sql))
		   {
		   

			$email = '';		
			$subject = trim($_POST['subject']);
			$message = nl2br(trim($_POST['message']));												
						 
			$email = $row['email_address'];

			$fullname = ucfirst(stripslashes($row['firstname']))." ".ucfirst(stripslashes($row['lastname']));
			
			

			$message = str_replace('{USER_EMAIL}', $email, $message);	
			$message = str_replace('{FULLNAME}', $fullname, $message);																															
										
  

			$subject = str_replace('{USER_EMAIL}', $email, $subject);					
			$subject = str_replace('{FULLNAME}', $fullname, $subject);																					
										  
														
			$sep = sha1(date('r', time())).rand(0000,9999);	
			$headers  = 	 "From: \"".SITE_NAME."\" <".NOTIFICATION_EMAIL.">\r\n";
			$headers .= "MIME-Version: 1.0\r\nContent-Type: multipart/alternative; boundary=\"PHP-mixed-$sep\"\r\n";								
			$headers .= "X-Mailer: PHP/". phpversion()."\r\n";			
										
$messageEmail = "--PHP-mixed-$sep
Content-type: text/html; charset=iso-8859-1
Content-Transfer-Encoding: 7bit

$message

--PHP-mixed-$sep--
";											
								
								
								
								if(mysql_query("INSERT INTO messages VALUES(NULL, 'admin', '".$row['email_address']."', '".makesafe($subject)."', '".makesafe($message)."', NOW(), 0)"))
								{
												$sent = 1;   
												@mail($email, $subject, $messageEmail,  $headers);
												
								}else
								{
												$sent = 0;
									}
									
								
		   
		   }
		
		}
		
		if($sent == 1)
		{
		    echo "<b>Message sent to all users</b>";
			return;
		}
	
	}



	
	
}else
{
	   $_POST['message'] = 'Hello {FULLNAME}';
	   include("messages/compose.php");
}

?>
