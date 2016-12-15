<?php

if(!isset($_GET['view']))
{
    echo "Invalid IP Record Id";
	return;
}




if(isset($_POST['update']))
{

		
        
		$ip = makesafe($_POST['ip']);
		$scope = makesafe($_POST['scope']);
		
		$oldip = makesafe($_POST['oldip']);
		
		if(empty($ip) || empty($scope))
		{
		    
			$error = "all fields required.";
			
			include("view.tpl.php");
			return;			
		}
		


	
	    if(mysql_num_rows(mysql_query("SELECT * FROM ipbans WHERE ip = '$ip'")) && $oldip != $ip) //check if item is already in db with same name.
		{
		    $error = "this ip is already is in banned list."; 
			include("view.tpl.php");
			return;
		}

		
		if(mysql_query("UPDATE ipbans SET ip =  '$ip',  `scope` = '$scope' WHERE ip = '$oldip' LIMIT 1"))
		{
			$_SESSION['msg'] = "Ip record updated successfully.";
			header("location: index.php?m=ipbans&view=$ip");
			exit;
		}else
		{
			$_SESSION['error'] = "Error occured while updating ip record.";
			header("location: index.php?m=ipbans&view=$ip");
			exit;
		}
	
	

    return;
}
$ip = makesafe($_GET['view']);
$sql = mysql_query("SELECT * FROM ipbans WHERE ip = '$ip'");
if(!mysql_num_rows($sql))
{
    echo "Invalid IP Record";
	return;
}

$row = mysql_fetch_object($sql);
$ip = stripslashes($row->ip);
$scope = stripslashes($row->scope);


include("view.tpl.php");

?>