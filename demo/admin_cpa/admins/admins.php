<br />

<div class="module_title">Admins Manager</div>  


<?php
//$_GET['view'] = $_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST'];


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



if(isset($_GET['view']) && !empty($_GET['view']))
{

 $adminId = safeGet($_GET['view']);
	$s1 = mysql_query("SELECT * FROM admins WHERE aid = '$adminId' LIMIT 1");
	if(!mysql_num_rows($s1))
	{

        ?><br /><br /><div class="error"><img src="images/cross.gif" alt="" style="float:left" /> <span> Invalid Admin Account</span></div><?php
        return;
	}
	
	
	$row = mysql_fetch_object($s1);
	$user = $row->admin_user;
	$active = $row->active;
	
	if(isset($_POST['updateAdmin']))
	{

	$password = makesafe($_POST['password']);

	$password2 = makesafe($_POST['password2']);
	

		
 if(isset($_POST['changePass'])){
	if(empty($password) || empty($password2)  || $password != $password2)
	{
				if(empty($password))
				{
				    $error = "admin password is empty.";
				}elseif(empty($password2))
				{
				    $error = "confirm password is empty.";
				}elseif($password != $password2)
				{
				    $error = "passwords mismatched.";
				}
				include("editadmin.tpl.php");
				return;
	}
	
	  $password = md5($user.$password.$user);

			
		if(mysql_query("UPDATE admins SET  admin_password = '$password'  WHERE aid = '$adminId'"))
		{
			$msg = "Admin account edited successfully.";
			include("editadmin.tpl.php");
			return;
		}else
		{
			$error = "Error occured while editing admin.";
			include("editadmin.tpl.php");
			return;	   	
		}
					
		
	
	
	}
		

	}
	



	
	include("editadmin.tpl.php");
    return;

}if(isset($_GET['del']) && !empty($_GET['del']))
{
    $aid = makesafe(safeGet($_GET['del']));
    
	
	if($aid == $_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST'])
	{
		$_SESSION['error'] = "You cannot delete admin account that is currently loggedin";
		header("location: index.php?m=admins");
	    return;
		
	}
	
	$s1 = mysql_query("SELECT * FROM admins WHERE aid = '$aid' LIMIT 1");
	if(mysql_num_rows($s1))
	{
		
		
	$row = mysql_fetch_object($s1);
	$user = $row->admin_user;

	if($user == "admin"){
		$_SESSION['error'] = "You cannot delete primary admin account";
		header("location: index.php?m=admins");
	    return;		
	}
	
		
  
        if(mysql_query("DELETE FROM admins WHERE aid = '$aid' LIMIT 1"))
		{

           $_SESSION['msg'] = "Admin Account Deleted Successfully";

		}else
		{
			
           $_SESSION['error'] = "An error occured while deleting admin account";
		}
		

	}	
	
			header("location: index.php?m=admins");
	return;
	
	
}elseif($_GET['add'] == 1)
{

   if(isset($_POST['create']))
   {
     	   
	
		$adminUser = makesafe($_POST['user']);
			   
		$password = makesafe($_POST['password']);
	
		$password2 = makesafe($_POST['password2']);
		
		$s1 = mysql_query("SELECT * FROM admins WHERE admin_user = '$adminUser' LIMIT 1");
		if(mysql_num_rows($s1))
		{
			$error = "admin user already exists.";
			include("add.php");
			return;
		}
		   
		if(empty($adminUser) || empty($password) || empty($password2)  || $password != $password2)
		{
					if(empty($adminUser))
					{
						$error = "admin user is empty.";
					}elseif(empty($password))
					{
						$error = "admin password is empty.";
					}elseif(empty($password2))
					{
						$error = "confirm password is empty.";
					}elseif($password != $password2)
					{
						$error = "passwords mismatched.";
					}
					include("add.php");
					return;
		}	
		
       $password = md5($adminUser.$password.$adminUser);

		if(mysql_query("INSERT INTO admins VALUES(NULL, '$adminUser', '$password', '1', NOW())"))
		{
			$msg = "Admin account created successfully.";
			include("admins_layout.php");
			return;
		}else
		{
			$error = "Error occured while creating admin.";
			include("admins_layout.php");
			return;	   	
		}	   			   
		   
	   
   }

    include("add.php");
	return;
	
	
}else
{
    include("admins_layout.php");	
}









?>

