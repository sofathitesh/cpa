<?php

if(isset($_GET['delete']))
{
  
	$id = makesafe($_GET['delete']);
	if(mysql_num_rows(mysql_query("SELECT * FROM cashouts WHERE id = ".$id)) > 0){
	
	  if(mysql_query("DELETE FROM cashouts WHERE id = ".$id))
	  {
		  
		  $_SESSION['msg'] = "Cashout Request deleted successfully.";
		  
	  }else
	  {
		  $_SESSION['error'] = "Problem occured while deleting cashout request.";
	  }
	
	}else
	{
		$_SESSION['error'] = "Invalid Cashout Request.";
	}
	
	header("location: index.php?m=cashouts");
	exit;

}elseif(isset($_POST['delete_x']))
{
	
      $ids = $_POST['ids'];
	  foreach($ids as $k => $v)
	  {
		  $v = makesafe($v);
		  if(!empty($v))
		  {
			 $id = $v;
		    	if(mysql_num_rows(mysql_query("SELECT * FROM cashouts WHERE id = ".$id)) > 0){
			
			  if(mysql_query("DELETE FROM cashouts WHERE id = ".$id))
			  {
				  
				  $_SESSION['msg'] = "Cashout Request deleted successfully.";
				  
			  }else
			  {
				  $_SESSION['error'] = "Problem occured while deleting cashout request.";
			  }
			
			}else
			{
				$_SESSION['error'] = "Invalid Cashout Request.";
			}

		

		  
		  }
}
			
			header("location: index.php?m=cashouts");
	        exit;	
	
}elseif(isset($_POST['update_complete']))
{


	
      $ids = $_POST['ids'];
	  foreach($ids as $k => $v)
	  {
		  $v = makesafe($v);
		  if(!empty($v))
		  {
			 $id = $v;
		    	if(mysql_num_rows(mysql_query("SELECT * FROM cashouts WHERE id = ".$id)) > 0){
			
			  if(mysql_query("UPDATE cashouts SET status = 'Complete', `payment_date` = NOW()  WHERE status != 'Cancelled' AND id = ".$id))
			  {
				  
				  $_SESSION['msg'] = "Cashout Request updated successfully.";
				  
			  }else
			  {
				  $_SESSION['error'] = "Problem occured while updating cashout request.";
			  }
			
			}else
			{
				$_SESSION['error'] = "Invalid Cashout Request.";
			}

		

		  
		  }
}
			
			header("location: index.php?m=cashouts");
	        exit;	
	


	
}elseif(isset($_GET['view']))
{
   include("view.php");
   return;
}elseif(isset($_POST['Paypal_Pay']))
{
	
   include("paypal_masspay/pay.php");
   return;
}       


include("cashouts_layout.php");

?>