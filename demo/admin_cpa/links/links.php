<?php

if(isset($_GET['delete']))
{

	$id = makesafe($_GET['delete']);
	
	if(mysql_num_rows(mysql_query("SELECT * FROM links WHERE  id = ".$id)) > 0){
		    
			$frm = mysql_fetch_object(mysql_query("SELECT * FROM links WHERE  id = ".$id));
			if(mysql_query("DELETE FROM links WHERE id = ".$id))
			{

				  $_SESSION['msg'] = "Link(s) deleted successfully.";
				
			}else
			{
				$_SESSION['error'] = "Problem occured while deleting link(s).";
			}
	
	}else
	{
		$_SESSION['error'] = "Invalid Link(s)";
	}
	
	header("location: index.php?m=links");
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
			if(mysql_num_rows(mysql_query("SELECT * FROM links WHERE  id = ".$id)) > 0){
			$frm = mysql_fetch_object(mysql_query("SELECT * FROM links WHERE  id = ".$id));				
					if(mysql_query("DELETE FROM links WHERE id = ".$id))
					{

						  $_SESSION['msg'] = "Link(s) deleted successfully.";
						
					}else
					{
						$_SESSION['error'] = "Problem occured while deleting link(s).";
					}
			
			}else
			{
				$_SESSION['error'] = "Invalid Link(s)";
			}
		  
		  }
	  }
			
			header("location: index.php?m=links");
	        exit;	
	
}elseif(isset($_GET['view']))
{
   include("view.php");
   return;
}


include("links_layout.php");

?>