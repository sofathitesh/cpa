<?php

if(isset($_GET['delete']))
{

	$id = makesafe($_GET['delete']);
	
	if(mysql_num_rows(mysql_query("SELECT * FROM gateways WHERE gid = ".$id)) > 0){
		    
			$frm = mysql_fetch_object(mysql_query("SELECT * FROM gateways WHERE gid = ".$id));
			if(mysql_query("DELETE FROM gateways WHERE gid = ".$id))
			{
				
				  @mysql_query("DELETE FROM gw_sessions WHERE gid = '$id'");

				  $_SESSION['msg'] = "Gateway(s) deleted successfully.";
				
			}else
			{
				$_SESSION['error'] = "Problem occured while deleting gateway(s).";
			}
	
	}else
	{
		$_SESSION['error'] = "Invalid Gateway(s)";
	}
	
	header("location: index.php?m=gateways");
	exit;

}elseif(isset($_POST['action']) && $_POST['action'] == 'delete')
{
	
      $ids = $_POST['ids'];
	  foreach($ids as $k => $v)
	  {
		  $v = makesafe($v);
		  if(!empty($v))
		  {
			$id = $v;
			if(mysql_num_rows(mysql_query("SELECT * FROM gateways WHERE gid = ".$id)) > 0){
					if(mysql_query("DELETE FROM gateways WHERE gid = ".$id))
					{
       				      @mysql_query("DELETE FROM gw_sessions WHERE gid = '$id'");
						  $_SESSION['msg'] = "Gateway(s) deleted successfully.";
						
					}else
					{
						$_SESSION['error'] = "Problem occured while deleting gateway(s).";
					}
			
			}else
			{
				$_SESSION['error'] = "Invalid Gateway(s)";
			}
		  
		  }
	  }
			
			header("location: index.php?m=gateways");
	        exit;	
	
}


include("gateways_layout.php");

?>