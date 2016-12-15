<?php
if (eregi("view.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("view.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}
if(!isset($_GET['view']))
{
    echo "Invalid network Id";
	return;
}




if(isset($_POST['update']))
{

		
  $id = makesafe($_POST['id']);
		$name = makesafe($_POST['network_name']);
		$oldname = makesafe($_POST['oldname']);
  $status = makesafe($_POST['status']);
		
		

		
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
			include("view.tpl.php");
			return;			
		}
		


	
	 if(mysql_num_rows(mysql_query("SELECT * FROM networks WHERE name = '$name'")) && $oldname != $name) //check if item is already in db with same name.
		{
		    $error = "network with given name is already in the database."; 
			include("view.tpl.php");
			return;
		}

		
		if(mysql_query("UPDATE networks SET name =  '$name',   active = '$status' WHERE id = $id LIMIT 1"))
		{
			$_SESSION['msg'] = "network updated successfully.";
			header("location: index.php?m=networks&view=$id");
			exit;
		}else
		{
			$_SESSION['error'] = "Error occured while updating network.";
			header("location: index.php?m=networks&view=$id");
			exit;
		}
	
	

    return;
}
$id = makesafe($_GET['view']);
$sql = mysql_query("SELECT * FROM networks WHERE id = $id");
if(!mysql_num_rows($sql))
{
    echo "Invalid network";
	return;
}

$row = mysql_fetch_object($sql);
$name = stripslashes($row->name);


include("view.tpl.php");

?>