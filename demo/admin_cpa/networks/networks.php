<?php
if(isset($_GET['delete']))
{

	$id = makesafe($_GET['delete']);
	$nsql = mysql_query("SELECT * FROM networks WHERE id = ".$id);
	if(mysql_num_rows($nsql) > 0){
	
    $nsr = mysql_fetch_object($nsql);
	$network_name  = stripslashes($nsr->name);
	
	  if(mysql_query("DELETE FROM networks WHERE id = ".$id))
	  {
	      @mysql_query("DELETE FROM offers WHERE network = '$network_name'");	 
		  $_SESSION['msg'] = "network deleted successfully.";
		  
	  }else
	  {
		  $_SESSION['error'] = "Problem occured while deleting network.";
	  }
	
	}else
	{
		$_SESSION['error'] = "Invalid network";
	}
	
	header("location: index.php?m=networks");
	exit;

}elseif(isset($_POST['action']) && $_POST['action'] == 'delete')
{

  $ids = $_POST['ids'];
  if(!empty($ids)){

	  foreach($ids as $k => $v)
	  {
	     $id = makesafe($v);
		 if(!empty($id))
		 {	


	
	$nsql = mysql_query("SELECT * FROM networks WHERE id = ".$id);
	if(mysql_num_rows($nsql) > 0){
	
    $nsr = mysql_fetch_object($nsql);
	$network_name  = stripslashes($nsr->name);
	
	
	
	  if(mysql_query("DELETE FROM networks WHERE id = ".$id))
	  {
	      @mysql_query("DELETE FROM offers WHERE network = '$network_name'");	 
		  $_SESSION['msg'] = "network deleted successfully.";
		  
	  }else
	  {
		  $_SESSION['error'] = "Problem occured while deleting network.";
	  }
	  
	  
	}
	
	}
	
	}
	
	}else
	{
		//$_SESSION['error'] = "Invalid network";
	}
	
	header("location: index.php?m=networks");
	exit;

	
}elseif(isset($_GET['add']))
{
    if(isset($_POST['addnetwork']))
	{
	
	    $name = makesafe($_POST['network_name']);
	    $status = makesafe($_POST['status']);

		$name = str_replace("-", " ", $name);
		if(!$status)
		{
		     $status = 0;
		}
		
	
		
		if(empty($name))
		{
		    
			if(empty($name))
			{
				$error = "network name is required.";
			}
		
			include("add.php");
			return;			
		}
		
		
	    if(mysql_num_rows(mysql_query("SELECT * FROM networks WHERE name = '$name'")))
		{
		    $error = "network with given name is already in the database."; 
			include("add.php");
			return;
		}

		
		if(mysql_query("INSERT INTO networks VALUES(NULL, '$name', '$status')"))
		{
		    $_SESSION['msg'] = "network added successfully.";
			header("location: index.php?m=networks");
		}else
		{
		    $error = "Problem while adding network"; 
			include("add.php");
			return;		
		}
												
	
	}else
	{
	    require("add.php");
		return;
	}
}elseif(isset($_GET['view']))
{
   include("view.php");
   return;
}elseif(isset($_GET['m2']) && $_GET['m2'] == 'settings')
{
	require_once("network_settings.php");
	return;
}    


include("networks_layout.php");

?>