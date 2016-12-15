<?php
/*

*/

class Authentication
{

    public function checkAuth() // This function will check if a user is logged in
	{
	    if(isset($_SESSION[urlencode(SITE_NAME).'HSC__HSUNLOG_LoggedUID_Sess_HsC_SJE']))
		{
		
		    //secondary security layer
		 if($_SESSION[urlencode(SITE_NAME).'__HSC_Sess_AnsLae3yer__XSecondary___xS'] !=  (md5(getIP().trim(str_replace(" ","",$_SERVER['HTTP_USER_AGENT'])))))
			{
               return false;   
			}else{
		
            return true; }
		}else
		{
		    return false;
		}
	}
	
	public function getLoggedId()
	{
	    if(isset($_SESSION[urlencode(SITE_NAME).'HSC__HSUNLOG_LoggedUID_Sess_HsC_SJE']))
		{
         
		  if(isset($_SESSION[urlencode(SITE_NAME).'HSC__HSUNLOG_LoggedUID_Sess_HsC_SJE']) && !empty($_SESSION[urlencode(SITE_NAME).'HSC__HSUNLOG_LoggedUID_Sess_HsC_SJE']))
			 {
			     return $_SESSION[urlencode(SITE_NAME).'HSC__HSUNLOG_LoggedUID_Sess_HsC_SJE'];
			 }
		 
		}else
		{
	
		    return false;
		}	 
	}
	
	public function setAuth($uid, $remember = null) //This function will set authentication session and/or cookie if remember
	{

			
		    $_SESSION[urlencode(SITE_NAME).'HSC__HSUNLOG_LoggedUID_Sess_HsC_SJE'] = $uid;
		    $security2 = md5(getIP().trim(str_replace(" ","",$_SERVER['HTTP_USER_AGENT'])));
		    $_SESSION[urlencode(SITE_NAME).'__HSC_Sess_AnsLae3yer__XSecondary___xS'] = $security2;			

		 

	}
	
	public static function logout()
	{

	    unset($_SESSION[urlencode(SITE_NAME).'HSC__HSUNLOG_LoggedUID_Sess_HsC_SJE']);
		session_unset();
		session_destroy();
		return true;
	}
	

}
?>