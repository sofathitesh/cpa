<?php
if(isset($_GET['delete']))
{

	$id = makesafe($_GET['delete']);
	
	if(mysql_num_rows(mysql_query("SELECT * FROM banned_offers WHERE id = ".$id)) > 0){
	
	  if(mysql_query("DELETE FROM banned_offers WHERE id = ".$id))
	  {
		  $_SESSION['msg'] = "Offer deleted from banned list successfully.";
		  
	  }else
	  {
		  $_SESSION['error'] = "Problem occured while deleting offer from banned list.";
	  }
	
	}else
	{
		$_SESSION['error'] = "Invalid Offer";
	}
	
	header("location: index.php?m=banned_offers");
	exit;

}else if(isset($_POST['action']) && $_POST['action'] == 'delete')
{
 
  $ids = $_POST['ids'];
  if(!empty($ids)){

	  foreach($ids as $k => $v)
	  {
	     $v = makesafe($v);
		 if(!empty($v))
		 {
		   

			    if(mysql_query("DELETE FROM banned_offers WHERE id = $v LIMIT 1"))
				{
				     $_SESSION['msg'] = "Offer has been deleted from banned list.";
				}
			
		 }
	  }

  	header("location: index.php?m=banned_offers");
	exit;
	
	
  }
  
  
}elseif(isset($_GET['add']))
{
    if(isset($_POST['addOffer']))
	{
	
	    $camp_id = makesafe($_POST['camp_id']);
	    $network = makesafe($_POST['network']);
	
		
		
		if(empty($camp_id) || empty($network))
		{
		    $error = "enter offer campaign id and select network.";
			include("add_layout.php");
			return;			
		}
		
		
		/*if(!getOfferByCampaign($camp_id, $network))
		{
		    $error = "Invalid offer.";
			include("add_layout.php");
			return;			
			
		}
*/
        
		
	    if(mysql_num_rows(mysql_query("SELECT * FROM banned_offers WHERE camp_id = '$camp_id' AND network = '$network'")))
		{
		    $error = "This offer is already in banned list."; 
			include("add_layout.php");
			return;
		}
		
		
		if(mysql_query("INSERT INTO banned_offers VALUES(NULL, '$camp_id', '$network', NOW())"))
		{
		    $_SESSION['msg'] = "Offer added to banned list successfully.";
			header("location: index.php?m=banned_offers");
		}
												
	
	}else
	{
	    include("add_layout.php");
		return;
	}
}elseif(isset($_GET['view']))
{
    include("view.php");
	return;
}


include("offers_layout.php");

?>