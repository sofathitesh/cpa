<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">IP Bans</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  IP Bans
                </span>
              </h1>
            </div>
            <div class="col-md-6">
            </div>
          </div>
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


$action = makesafe($_REQUEST['action']);
 $ip = makesafe($_POST['ip']);
if(isset($_REQUEST['action']))
{
 
  $ids = $_POST['ips'];
 
  if(!empty($ids)){
  if($action == 'delete')
  {

	  foreach($ids as $k => $v)
	  {
	     $v = makesafe($v);
		 if(!empty($v))
		 {
		   
		    if(mysql_num_rows(mysql_query("SELECT * FROM ipbans WHERE ip = '$v'")))
			{
			    if(mysql_query("DELETE FROM ipbans WHERE ip = '$v' "))
				{
				    $success_msg = "IP(s) deleted from banlist.";
				}
			}
		 }
	  }
  }
  
  }
  
  
  
  
  
}elseif(isset($_GET['view']) && !empty($_GET['view']))
  {
  
     include("ipbans/view.php");
	 return;
  
  }
  
if($action == 'add')
  {
     include("ipbans/add.php");
	 return;  
  }  

?>

<br />
<a href="index.php?m=ipbans&action=add" class="btn btn-primary">Add IP To Banlist</a>
<br><br>
<form action="index.php?m=ipbans"  method="post" id="form1">

 <table class="table">
 <thead>
 <tr>

    <th>IP</th>
	<th>DATE</th>
	<th><input type="checkbox" id="checkAll" onclick="CheckAll('form1')" /></th>
</tr>
</thead>
<?php

$self = "index.php?m=ipbans";
$page = 1;
$showPerPage = 15;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(ip) as total FROM ipbans");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No ip is banned yet!";
   echo "<tr><td colspan='3' style=\"background:#ffffff\">$msg</td></tr> </table>";
   return;
}

//so how many pages we have?
$pages = ceil($records/$showPerPage);

//check if page is greater then number of pages 
if($page > $pages)
 {
   header("location: $self?page=$pages");
 }


// print the link to access each page

$nav  = '';


$pre=$page-1;
$nex = $page+1;

//making fist last 
if(($page==1) and ($pages == 1))
{
   $first = "";
  $previous = "";
  $last  = "";
  $next  = "";
 
}else
if($page == 1 and $pages > 1)
{
  $first = "";
  $previous = "";
  $last  = " <a href=$self?page=$pages>Last</a> ";
  $next  = "<a href=$self?page=$nex>Next</a> | ";
}else if($page == $pages and $pages > 1)
{
 
 $first = "<a href=$self?page=1>First</a> | ";
  $previous = "<a href=$self?page=$pre>Previous</a> ";
  $last  = "";
  $next  = "";
 
} else 
{
   $first = "<a href=$self?page=1>First</a> | ";
  $previous = "<a href=$self?page=$pre>Previous</a> - ";
  $last  = "<a href=$self?page=$pages>Last</a> ";
  $next  = "<a href=$self?page=$nex>Next</a> | ";
}

$query = mysql_query("SELECT * FROM ipbans ORDER BY date DESC LIMIT $offset, $showPerPage");
$x = 1;
while($row = mysql_fetch_object($query))
{
     $ip = $row->ip;

	 $date = date("d M, Y",strtotime($row->date));
	 $scope = $row->scope;
     
		if($x%2 == 0)
		{
		    $trColor = "f1f0f0";	
		}else
		{
		    $trColor = "ffffff";	
		}	

	   echo  "<tr style=\"background:#$trColor;\"><td>$ip</td><td><b>$date</b></td><td><a href=\"index.php?m=ipbans&view=$ip\">View</a> <input type=\"checkbox\" style=\"vertical-align:middle\" value=\"$ip\" name=\"ips[]\"  onclick=\"uncheckCheckAllbox(this)\" /></td></tr>"; 

$x++;
	
}



?>
 <input type="hidden" name="action" value="delete" />
 <tr><td colspan="4"><input style="float:right" type="submit" name="submit" value="Delete" /></td></tr>
</table>
</form>