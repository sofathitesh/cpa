<?php
class Stats
{

    private $uid = '';
	
	function __construct($uid)
	{
	    $uid = trim($uid);
		if(empty($uid) || !preg_match("/^[0-9]*$/",$uid))
		{
		    die("Invalid User ID");
		}
		
		$this->uid = $uid;
	}
	
	public static function getMoney($uid)
	{
	    if(empty($uid) || !preg_match("/^[0-9]*$/",$uid))
		{
		    return false;
		}
		
		$sql = mysql_query("SELECT balance FROM users WHERE uid = $uid LIMIT 1");
		if(mysql_num_rows($sql))
		{
		    $row = mysql_fetch_object($sql);
			return $row->balance;
		}else
		{
		    return false;
		}
	}
	
	
	public static function SetMoney($uid,$money)
	{
	   
	    if(empty($uid) || !preg_match("/^[0-9]*$/",$uid))
		{
		   echo $uid;
		    return false;
		}	
	
	    $sql = mysql_query("UPDATE users SET balance = '$money' WHERE uid = '$uid' LIMIT 1"); 
		if($sql)
		return true;
		else
		return false;
		
	
	}

}
?>