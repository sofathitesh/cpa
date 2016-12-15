<?php
if (eregi("offers.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("offers.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}

		mysql_query("SET character_set_results=utf8");
		mysql_query("SET character_set_client=utf8");
        mysql_query("SET character_set_connection=utf8");


 $action = makesafe($_REQUEST['action']);
if($action == 'delete') 
{
 
  $ids = $_POST['ids'];
	  foreach($ids as $k => $v)
	  {
	     $v = makesafe($v);
		 if(!empty($v))
		 {
				  $oid = $v;
		   
		    if(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE id =".$oid." AND uid != 0")))
			{
				
						
						
							if(mysql_query("DELETE FROM offers WHERE id = ".$oid." AND uid != 0"))
							{

							}else
							{
								$_SESSION['error'] = "Problem occured while deleting offer.";
							}
					

					
	
									
			  
			}

		 }
	  }
			
		header("location: index.php?m=u_offers");
	     exit;

  	

}elseif(isset($_GET['view']))
{

    include("view.php");
	return;
}elseif(isset($_POST['removeAll']) && $_POST['removeNow'] == 'yes')
{
	

	
	if(mysql_query("DELETE FROM offers WHERE uid != 0"))
	{
		header("location: index.php?m=u_offers");      		
	}
}


include("offers_layout.php");

?>