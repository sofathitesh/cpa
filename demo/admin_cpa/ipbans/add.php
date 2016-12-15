<?php

if(isset($_SESSION['error']) || isset($error))
{
    if(isset($_SESSION['error']) && !isset($error))
	{
	    $error = $_SESSION['error'];
	}
    echo "<div style=\"font-size:12px; color:#FF0000\">".$error."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}
if(isset($_GET['ip']))
{
  $ip = makesafe($_GET['ip']);
}


if(isset($_POST['addIP']))
{

		$ip = makesafe($_POST['ip']);
		$scope = makesafe($_POST['scope']);
		
		
		
		if(empty($ip) || empty($scope))
		{
		    
			$error = "all fields required.";
			
			include("add.php");
			return;			
		}
		


	
	    if(mysql_num_rows(mysql_query("SELECT * FROM ipbans WHERE ip = '$ip'")) && $oldip != $ip) //check if item is already in db with same name.
		{
		    $error = "this ip is already is in banned list."; 
			include("add.php");
			return;
		}

		
		if(mysql_query("INSERT INTO ipbans VALUES('$ip',  '$scope', NOW())"))
		{
			$_SESSION['msg'] = "Ip record added successfully.";
			header("location: index.php?m=ipbans");
			exit;
		}else
		{
			$_SESSION['error'] = "Error occured while adding ip record.";
			header("location: index.php?m=ipbans");
			exit;
		}

}

?>
<form action="index.php?m=ipbans&action=add" method="post">
<input type="hidden" name="scope" value="Website" />
<table class="settings_table" cellspacing="10">
<tr><td>IP Address</td><td><input type="text" name="ip" value="<?=$ip?>"  /></td></tr>
<tr><td colspan="2" style="text-align:right; padding-top:8px"><input type="submit" name="addIP" value="Add IP To BanList" /></td></tr>
</table>
</form>

	
