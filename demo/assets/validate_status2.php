<?php
ob_start();
session_start();
error_reporting(0);
require_once("../includes/dbconfig.php");
require_once("includes/functions.php");
require_once("includes/settings.php");

$ssid =  makesafe($_REQUEST['sess']);

if(empty($ssid))
$ssid = $_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD'];

$_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD'] = $ssid;



if(isset($_GET['g']))
{
	

	$gid = makesafe($_GET['g']);

	$sessId =  makesafe(safeGet($_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD']));
//	$gid = makesafe(safeGet($_POST['g']));
	
	
	$sql = mysql_query("SELECT id, complete FROM gw_sessions WHERE session_id = '$sessId' AND gid = '$gid'");
	

	if(mysql_num_rows($sql))
	{
	    $r = mysql_fetch_object($sql);
		$complete = $r->complete;
		if($complete == '1')
		{
		 
		 
			$sql1 = mysql_query("SELECT * FROM gateways WHERE gid = '".makesafe($gid)."' LIMIT 1");
			
			if(mysql_num_rows($sql1))
			{
			
				$r1 = mysql_fetch_object($sql1);
				$unlock_period = $r1->unlock_period;		    
				$period_type = $r1->period_type;
				$redirect_url = stripslashes($r1->redirect_url);
				$isFileLocker = stripslashes($r1->unlock_file);
				$file_id = stripslashes($r1->file_id);
				$uid = $r1->uid;
				
                if(!empty($unlock_period) && $unlock_period >= 1 && !empty($period_type) && !preg_match('/[^0-9]/', $unlock_period))
				{

					//Set Unlock Period Now
					
					switch($period_type)
					{
					
					    case 'seconds':
						default:
						$period = time()+$unlock_period;
						break;
						
						case 'minutes':
						$period = time()+$unlock_period*60;
						break;
						
						case 'hours':
						$period = time()+$unlock_period*3600;
						break;
						
						case 'days':
						$period = time()+$unlock_period*(3600*24);
						break;
						
					}
					 
					setcookie('__du_gw_cl_sessID__XCLD_'.$gid,$sessId, $period);		
					
				}
				
			}
		 
		 

         //file unlock

         if($isFileLocker == 1 )
		 {
			 if(!empty($file_id))
			 {
				 


					$token = $sessId;
					$fileCode = getFileCodeById($file_id);
					$filename = getFilenameById($file_id);
					$encodedname = getFileEncodedNameById($file_id);

					$file = '../HST_USR_UPLOADED_FILES__DIR/hst_uploaded_files/'.$encodedname;
					if (!file_exists($file)) {
					    echo $_GET['callback']."(".json_encode(array('success' => 1, 'msg' => 'x_dupcOlE_lOckEr_Unlock_x_exl_gidUnLocked', 'url' => '0', 'alertMsg' => 'Sorry file not found on our server')).")";	 
						return;	
					}
					
					 //insert download log
					 //@mysql_query("INSERT INTO downloads_log VALUES(NULL, '$fileCode', '".SITE_URL."file/$fileCode', 'GW File Unlocked', '".getIP()."', NOW(), '$uid', '$country', '0', NULL)");
					 
					 echo $_GET['callback']."(".json_encode(array('success' => 1, 'msg' => 'x_dupcOlE_lOckEr_Unlock_x_exl_gidUnLocked', 'unlockFile' => '1', 'url' => '0', 'fileUrl' => SITE_URL.'assets/getfile.php?g='.$gid)).")";	 
					  exit;
					 
				 
			 }
		 }
		 
		 //File unlock end
		  
		 if(!empty($redirect_url) && validURL($redirect_url))
		 {
		 echo $_GET['callback']."(".json_encode(array('success' => 1, 'msg' => 'x_dupcOlE_lOckEr_Unlock_x_exl_gidUnLocked', 'url' => $redirect_url)).")";	 
		}else
		{
		  echo $_GET['callback']."(".json_encode(array('success' => 1, 'msg' => 'x_dupcOlE_lOckEr_Unlock_x_exl_gidUnLocked', 'url' => '0')).")";
		}
		   return;
		}else
		{

		   echo $_GET['callback']."(".json_encode(array('error' => 1, 'error_msg' => 'not found')).")";
		   return;


		}
	}else
	{
	    echo $_GET['callback']."(".json_encode(array('error' => 1, 'error_msg' => 'not found')).")";
		   return;
		
	}
	
}else
{
    		   echo $_GET['callback']."(".json_encode(array('error' => 1, 'error_msg' => 'variables not passed')).")";

}
return;
?>

