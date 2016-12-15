<?php
/*

@Description: This class will handle user 
*/


class __User
{
	private $uid; // user id
	private $fields; // other record fields
		
	public function __construct()
	{
		$this->uid = null;
		$this->fields = array('username' => '',	'password' => '', 'salt' => '', 'email_address' => '', 'country' => '','website' => '', 'referrer_id' => '', 'active' => 0, 'ip_address' => '', 'date_registration' => '', 'firstname' => '', 'lastname' => '', 'address' => '', 'city' => '', 'state' => '', 'phone' => '', 'zip' => '', 'gender' => '', 'balance' => '0.00', 'promotional_methods' => '', 'hearBy' => '', 'payment_method' => '', 'payment_details' => '');
	}
		
	public function __get($field)
	{
		if ($field == 'uid')
		{
			return $this->uid;
		}
		else
		{
			return $this->fields[$field];
		}
	}
	
	
	public function __set($field, $value)
	{
		if (array_key_exists($field, $this->fields))
		{
			$this->fields[$field] = $value;
		}
	}
	
	public function setReferrer()
	{
	   if(isset($_SESSION['ref']) && !empty($_SESSION['ref']))
	   {
	       $this->referrer_id = mysql_real_escape_string($_SESSION['ref']);
	   }
	}
	
	
	function generateSalt()
	{
	    $rand = md5(rand(000000,999999));
		$this->salt = substr($rand,0,6);
		
		
	}
	
	// return if username is valid format
	public static function validateUsername($username)
	{
		return preg_match('/^[A-Z0-9]{2,20}$/i', $username);
	}
	
	// return if email address is valid format
	public static function validateEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	// return an object populated based on the record's user id
	public static function getById($uid)
	{
		$user = new __User();
		$query = sprintf('SELECT * FROM users WHERE uid = %d', $uid);
		$result = mysql_query($query, $GLOBALS['DB']);
		if(mysql_num_rows($result))
		{
			$row = mysql_fetch_assoc($result);
			$user->password = $row['password'];
			$user->email_address = $row['email_address'];
			
			//personal info
			$user->firstname = $row['firstname'];
			$user->lastname = $row['lastname'];
			$user->address = $row['address'];
			$user->state = $row['state'];
			$user->city = $row['city'];			
			$user->zip = $row['zip'];
			$user->country = $row['country'];
            $user->phone = $row['phone']; 			
			$user->website = $row['website'];
			//end personal info
			
			$user->active = $row['active'];
			$user->salt = $row['salt'];
			$user->date_registration = $row['date_registration'];
			$user->uid = $uid;
		}
		mysql_free_result($result);
		return $user;
	}
	

	//this will return true if email is already being used
	public static function emailExists($email)
	{	
		$query = sprintf('SELECT * FROM users WHERE email_address = "%s"', $email);
		$result = mysql_query($query, $GLOBALS['DB']);
		if(mysql_num_rows($result) > 0)
		{
			$exists = true;
		}else
		{
		    $exists = false;
		}
		mysql_free_result($result);
		return $exists;
	}
	
	
	public static function isEmailInUse($uid, $email)
	{	
		$query = sprintf('SELECT * FROM users WHERE email_address = "%s" AND uid != "%d"', $email, $uid);
		$result = mysql_query($query, $GLOBALS['DB']);
		if(mysql_num_rows($result) > 0)
		{
			$exists = true;
		}else
		{
		    $exists = false;
		}
		mysql_free_result($result);
		return $exists;
	}	
	

	// Create Account
	public function createAccount()
	{
		
	        
			$this->phone = '00000000';	
		    $this->generateSalt(); //generating salt for password encryption. Salt will never need to be updated by user or admin. this is one time generation.
			$query = sprintf("INSERT INTO users (password, salt, email_address, referrer_id,  active, ip_address, date_registration, firstname, lastname, country, website, address, city, state, zip, promotional_methods, hearBy, payment_method, payment_method_details) VALUES ('%s', '%s', '%s', '%d',  '%d', '%s', NOW(), '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s','%s', '%s')", md5($this->salt.$this->password), $this->salt, $this->email_address, $this->referrer_id, 0, $this->ip_address, $this->firstname, $this->lastname, $this->country, $this->website, $this->address, $this->city, $this->state, $this->zip, $this->promotional_methods, $this->hearBy, $this->payment_method, $this->payment_details);

            
			if (mysql_query($query, $GLOBALS['DB']))
			{
				$this->uid = mysql_insert_id($GLOBALS['DB']);
				unset($_SESSION['ref']);


				$token = substr(md5(uniqid()), 1, 11);
				$query = sprintf('INSERT INTO pending_users (email, TOKEN) VALUES ("%s", "%s")',  $this->email_address, $token);
				if(!mysql_query($query, $GLOBALS['DB']))
				{
				    return false;	
				}
				
				unset($_SESSION['ref']);

                $mail = new Email($this->email_address, 'Activation', 'Thank you for signup at '.SITE_NAME.'. Please verify your account by clicking on the below link <br /> <a href="'.SITE_URL.'reg_verify.php?email='.$this->email_address.'&token='.$token.'">'.SITE_URL.'reg_verify.php?email='.$this->email_address.'&token='.$token.'</a><br />', 1);
				
				
				
				if($mail->sendMail())
				return true;
				else
				{
					if(mysql_query("DELETE FROM users WHERE uid = '".makesafe($this->uid)."' LIMIT 1")) 
					@mysql_query("DELETE FROM pending_users WHERE email = '".makesafe($this->email_address)."'");
					
				    return false;
				}
	
				
				
			}
			else
			{    



				return false;
			}
		
	}
	
	
	
	
	
	
	// clear the user's pending status and set the record as active
	public function setActive($email, $token)
	{
		$query = sprintf('SELECT token FROM pending_users WHERE email = "%s" AND token = "%s"',  mysql_real_escape_string($email, $GLOBALS['DB']), mysql_real_escape_string($token, $GLOBALS['DB']));
		$result = mysql_query($query, $GLOBALS['DB']);
		if (!mysql_num_rows($result))
		{
		mysql_free_result($result);
		return false;
		}
		else
		{
			mysql_free_result($result);
			$query = sprintf('DELETE FROM pending_users WHERE email = "%s" AND token = "%s"',  mysql_real_escape_string($email, $GLOBALS['DB']), mysql_real_escape_string($token, $GLOBALS['DB']));
			if (!mysql_query($query, $GLOBALS['DB']))
			{
				return false;
			}
			else
			{
                 if(mysql_query("UPDATE users SET active = 1 WHERE uid = '".makesafe($this->uid)."' LIMIT 1"))
				 {
					return true; 
				 }else
				 {
				    return false;	 
				 }
			}
		}
	}	
	

	
	public static function EncryptPass($email, $password) // This function will return an encrypted password if account details are correct .. 
	{
	   
	   $query = sprintf('SELECT salt FROM users WHERE email_address = "%s" AND active = 1 LIMIT 1', 	mysql_real_escape_string($email, $GLOBALS['DB']));
	   $sql = mysql_query($query);
	   if(mysql_num_rows($sql)>0)
	   {
	     $row = mysql_fetch_array($sql);
		 $salt = $row['salt'];
    	 $encrypted = md5($salt.$password); 
		 return $encrypted; 
	   }else
	   {
	       return false;
	   }

	}
	
	public static function doAuth($email, $password) //This will login the user, return false on fail, encrypted password should be pass in parameter, uid on success
	{
       
	   $query = sprintf('SELECT uid FROM users WHERE email_address = "%s" AND password = "%s" AND active = 1 LIMIT 1', 	mysql_real_escape_string($email, $GLOBALS['DB']), mysql_real_escape_string($password, $GLOBALS['DB']));
	   $sql = mysql_query($query);
	   if(mysql_num_rows($sql)>0)
	   {
	     $row = mysql_fetch_array($sql);
		    return $row['uid'];
	     
	   }else
	   {  
	      
	       return false;
	   }
	    
	
	}
	
	
	public static function isLocked($email) //This will login the user, return false on fail, encrypted password should be pass in parameter, uid on success
	{
       
	   $query = sprintf('SELECT uid FROM users WHERE email_address = "%s" AND active = 1 AND isLocked = 1 LIMIT 1', 	mysql_real_escape_string($email, $GLOBALS['DB']));
	   $sql = mysql_query($query);
	   if(mysql_num_rows($sql)>0)
	   {
	     $row = mysql_fetch_array($sql);
		 return true;
	     
	   }else
	   {  
	      
	       return false;
	   }
	    
	
	}	
	
	
	public static function isBan($email) //This will login the user, return false on fail, encrypted password should be pass in parameter, uid on success
	{
       
	   $query = sprintf('SELECT uid FROM users WHERE email_address = "%s" AND active = 1 AND isBan = 1 LIMIT 1', 	mysql_real_escape_string($email, $GLOBALS['DB']));
	   $sql = mysql_query($query);
	   if(mysql_num_rows($sql)>0)
	   {
	     $row = mysql_fetch_array($sql);
		 return true;
	     
	   }else
	   {  
	      
	       return false;
	   }
	    
	
	}		
	
	
	
	public static function lockAccount($email) //This will login the user, return false on fail, encrypted password should be pass in parameter, uid on success
	{
       
	   $query = sprintf('UPDATE users SET isLocked = 1 WHERE email_address = "%s" LIMIT 1', 	mysql_real_escape_string($email, $GLOBALS['DB']));
	   $sql = mysql_query($query);
	   if(mysql_num_rows($sql)>0)
	   {
	     $row = mysql_fetch_array($sql);
		 return true;
	     
	   }else
	   {  
	      
	       return false;
	   }
	    
	
	}	
	
	public static function unlockAccount($email) //This will login the user, return false on fail, encrypted password should be pass in parameter, uid on success
	{
       
	   $query = sprintf('UPDATE users SET isLocked = 0 WHERE email_address = "%s" LIMIT 1', 	mysql_real_escape_string($email, $GLOBALS['DB']));
	   $sql = mysql_query($query);
	   if(mysql_num_rows($sql)>0)
	   {
	     $row = mysql_fetch_array($sql);
		 return true;
	     
	   }else
	   {  
	      
	       return false;
	   }
	    
	
	}			
	
	
	
	public static function getIdByEmail($email)
	{
		$id = 0;
		$query = sprintf('SELECT uid FROM users WHERE email_address = "%s"', 	mysql_real_escape_string($email, $GLOBALS['DB']));
		$result = mysql_query($query, $GLOBALS['DB']);
		if (mysql_num_rows($result))
		{
			$row = mysql_fetch_assoc($result);
			$id = $row['uid'];
		}
			mysql_free_result($result);
			return $id;			

	}		





	
	
	public static function adminUserLogin($email)
	{
       
   
	   
	   $query = sprintf('SELECT uid FROM users WHERE email_address = "%s" AND active = 1 LIMIT 1', 	mysql_real_escape_string($email, $GLOBALS['DB']));
	   $sql = mysql_query($query);
	   if(mysql_num_rows($sql)>0)
	   {
	     $row = mysql_fetch_array($sql);
		    return $row['uid'];
	     
	   }else
	   {  
	      
	       return false;
	   }
	    
	
	}	
	
	
	
	public function verifyEmailAccount($uid)
	{
        $query = "UPDATE users SET email_verified = 1 WHERE uid = '$uid'";
		$result = mysql_query($query, $GLOBALS['DB']);
		if (!mysql_num_rows($result))
		{
		mysql_free_result($result);
		return false;
		}
		else
		{
		
		    return true;	
			
			
		}
	}		
	
	public function checkPending($email, $token)
	{
		$query = sprintf('SELECT token FROM pending_users WHERE email = "%s" AND token = "%s"',  mysql_real_escape_string($email, $GLOBALS['DB']), mysql_real_escape_string($token, $GLOBALS['DB']));
		$result = mysql_query($query, $GLOBALS['DB']);
		if (!mysql_num_rows($result))
		{
		mysql_free_result($result);
		return false;
		}
		else
		{
		
		    return true;	
			
			
		}
	}		
		
	
	
}



	

?>
