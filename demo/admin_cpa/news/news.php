<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">News</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  News
                </span>
              </h1>
            </div>
            <div class="col-md-6">
            </div>
          </div>
          <div class="block">
          <div class="block-content-outer">
                  <div class="block-content-inner">
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
if(isset($_REQUEST['action']))
{
 
  $ids = $_POST['ids'];
 
  if(!empty($ids)){
  if($action == 'delete')
  {

	  foreach($ids as $k => $v)
	  {
	     $v = makesafe($v);
		 if(!empty($v))
		 {
		   
		    if(mysql_num_rows(mysql_query("SELECT * FROM news WHERE id = '$v'")))
			{
			    if(mysql_query("DELETE FROM news WHERE id = '$v' "))
				{
					@mysql_query("DELETE FROM news_comments WHERE news_id = '$v'");
				    $success_msg = "News deleted.";
				}
			}
		 }
	  }
  }
  
  }
  
  
  
  
  
}elseif(isset($_GET['view']) && !empty($_GET['view']))
  {
  
     include("news/view.php");
	 return;
  
  }
  
  if($action == 'add')
  {
    include("news/add.php");
	 return;  
  }  

?>

<br />

<a href="index.php?m=news&action=add"><button type="submit" class="btn btn-danger">Create News</button></a>
<br><br>
<form action="index.php?m=news"  method="post" id="form1">




 <table class="table">
 <thead>
 <tr>

    <th>Date</th>
	<th>Headline</th>
	<th><input type="checkbox" id="checkAll" onclick="CheckAll('form1')" /></th>
</tr>
</thead>
<?php

$self = "index.php?m=news";
$page = 1;
$showPerPage = 15;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(id) as total FROM news");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No news found!";
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

$query = mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT $offset, $showPerPage");
$x = 1;
while($row = mysql_fetch_object($query))
{
     $id = $row->id;
     $headline = stripslashes($row->title);
	 $date = date("d M, Y",strtotime($row->date));
    
		if($x%2 == 0)
		{
		    $trColor = "f9f9f9";	
		}else
		{
		    $trColor = "ffffff";	
		}	

	  // echo  "<tr style=\"background:#$trColor;\"><td>$date</td><td>$headline</td><td><a href=\"index.php?m=news&view=$id\">View</a> | <a href=\"index.php?m=news_comments&nid=$id\">Comments</a> | <input type=\"checkbox\" style=\"vertical-align:middle\" value=\"$id\" name=\"ids[]\"  onclick=\"uncheckCheckAllbox(this)\" /></td></tr>"; 

	   echo  "<tr style=\"background:#$trColor;\"><td>$date</td><td>$headline</td><td><a href=\"index.php?m=news&view=$id\">View</a> | <input type=\"checkbox\" style=\"vertical-align:middle\" value=\"$id\" name=\"ids[]\"  onclick=\"uncheckCheckAllbox(this)\" /></td></tr>";
$x++;
	
}



?>
 <input type="hidden" name="action" value="delete" />
 <tr><td colspan="4" align="right"><button type="submit" class="btn btn-danger">Delete</button></td></tr>
</table>
</form>



</div>
