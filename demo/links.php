<?php
require_once("header.php");


if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$template->assign('script', 'links');
if(isset($_GET['link'])) // file details
{
	
	$fid = safeGet($_GET['link']);
	
	$template->assign('fid', $fid);
	$sql_m2 = mysql_query("SELECT * FROM links WHERE id = '".makesafe($fid)."' AND uid = '".makesafe($Auth->getLoggedId())."'");
	if(!mysql_num_rows($sql_m2))
	{
		$template->assign('error_msg', 'invalid link.');	
	}	
	
	
	
	

	
	
	if(isset($_POST['update']))
	{

		$link_url = makesafe($_POST['url']);
		$link_desc = makesafe($_POST['description']);		
		$downloads = makesafe($_POST['downloads']);
		$date_added = makesafe($_POST['dateadded']);


		$template->assign('downloads', $downloads);
		$template->assign('date', $date_added);	  		

	   if(empty($date_added))
	   $date_added = date('Y-m-d');
		
		
		
        if(empty($link_url))
		{
		    $template->assign('error_msg', 'Link url was empty');	
		}else{		
		if(mysql_query("UPDATE links SET  url = '$link_url', description = '$link_desc', dateadded = '$date_added' WHERE id = '$fid' LIMIT 1"))
		{
				$template->assign('success_msg', 'The link has been successfully updated.');
		}else
		{
                $template->assign('error_msg', 'invalid link.');			
		}
		}
	}
		
	$sql_m = mysql_query("SELECT * FROM links WHERE id = '".makesafe($fid)."' AND uid = '".makesafe($Auth->getLoggedId())."'");
	if(!mysql_num_rows($sql_m))
	{
		$template->assign('error_msg', 'invalid link.');	
	}		
	

	
    $fr = mysql_fetch_object($sql_m);	

	$last_download_date = date('d M, Y', strtotime(stripslashes($fr->last_download_date)));
	$date = date('Y-m-d', strtotime(stripslashes($fr->dateadded)));		
	$downloads = stripslashes($fr->downloads);
	$link_url = stripslashes($fr->url);
	$link_desc = stripslashes($fr->description);
	$fcode = stripslashes($fr->code);

	$template->assign('downloads', $downloads);
	$template->assign('date', $date);				
    $template->assign('link_url', $link_url);				
    $template->assign('link_desc', $link_desc);					
	$template->assign('fcode', $fcode);	

	
	
	if(empty($downloads))
	$last_download_date = 'N/A';
	
	$template->assign('last_download_date', $last_download_date);	
	
	
	$template->display('link_details.tpl.php');
	return;
	
}else if(isset($_POST['delete']))
{
	  $ids = $_POST['ids'];
	  foreach($ids as $k => $v)
	  {
				 
	      $v = makesafe($v);
							if(!empty($v))
							{
									
										if(mysql_query("DELETE FROM links WHERE id = '$v' AND uid = ".makesafe($Auth->getLoggedId())))
										{
												
														
										}										
										
							}
	  }
}
//end deleting files



$self = "links.php?$queryString";
$pagetitle = "My Links";
$page = 1;
$showPerPage = 40;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(id) as total FROM links WHERE  uid = ".$Auth->getLoggedId());
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No Link uploaded";
   $template->assign('msg', $msg);
   $template->display('links.tpl.php');
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
  $last  = " <a href=$self&page=$pages>Last</a> &raquo;";
  $next  = "<a href=$self&page=$nex>Next</a> &raquo; ";
}else if($page == $pages and $pages > 1)
{
 
 $first = "&laquo; <a href=$self&page=1>First</a> ";
  $previous = "&laquo; <a href=$self&page=$pre>Previous</a>&nbsp;";
  $last  = "";
  $next  = "";
 
} else 
{
   $first = "&laquo;<a href=$self&page=1>First</a> ";
  $previous = "&laquo;<a href=$self&page=$pre>Previous</a>&nbsp;";
  $last  = "<a href=$self&page=$pages>Last</a> &raquo; ";
  $next  = "<a href=$self&page=$nex>Next</a> &raquo; ";
}

$query = mysql_query("SELECT * FROM links WHERE uid = ".$Auth->getLoggedId()." ORDER BY id DESC LIMIT $offset, $showPerPage");
while($row = mysql_fetch_object($query))
{

	 $date = date("d M, Y",strtotime($row->dateadded));
	$fid = $row->id;
	$hits = $row->hits;
	$downloads = $row->downloads;
	$link = stripslashes($row->url);
	$file_code = $row->code;
	$links[] = array('filename' => $filename, 'date' => $date, 'hits' => $hits, 'downloads' => $downloads, 'filesize' => 'N/A', 'id' => $fid, 'link' => $link_label, 'full_link' => $link, 'fcode' => $file_code);
}

$template->assign('files', $links);
$template->assign("firstpage", $first); //First Page
$template->assign("previouspage", $previous); //Previous Page
$template->assign("nextpage", $next); //Next Page
$template->assign("lastpage", $last); //Last Page
$template->assign("records", $records);
$template->assign("page", $page);
$template->assign("pages", $pages);
$template->display('links.tpl.php');
  
  


 


?>