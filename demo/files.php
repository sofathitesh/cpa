<?php
require_once("header.php");

if(!$Auth->checkAuth()) 
{
    header("location: index.php");
	exit;
}

$template->assign('script', 'files');

if(isset($_GET['file']))
{
	
	$fid = safeGet($_GET['file']);
	$sql_m = mysql_query("SELECT * FROM files WHERE id = '".makesafe($fid)."' AND uid = '".makesafe($Auth->getLoggedId())."' AND upload_type = 'local'");
	if(!mysql_num_rows($sql_m))
	{
		$template->assign('error_msg', 'invalid file.');	
	    $template->display('file_details.tpl.php');
    	return;		
	}
	
	if(isset($_POST['desc']))
	{
	    $desc = strip_tags(makesafe($_POST['desc']));	
		if(mysql_query("UPDATE files SET `description` = '$desc' WHERE id = '".makesafe($fid)."' AND uid = '".makesafe($Auth->getLoggedId())."' AND upload_type = 'local'"))
		{
			mysql_free_result($sql_m);
			$sql_m = mysql_query("SELECT * FROM files WHERE id = '".makesafe($fid)."' AND uid = '".makesafe($Auth->getLoggedId())."' AND upload_type = 'local'");
		}
		
	}
	
	
	
    $fr = mysql_fetch_object($sql_m);	
	$filename = stripslashes($fr->filename);
	$desc = stripslashes($fr->description);
	$filesize = convertFileSize(stripslashes($fr->filesize));
	if(!empty($fr->last_download_date))
	$last_download_date = date('d/m-y', strtotime(stripslashes($fr->last_download_date)));
	
	$date = date('Y-m-d', strtotime(stripslashes($fr->dateadded)));	
	$fcode = stripslashes($fr->code);
	$downloads = stripslashes($fr->downloads);
	$design = stripslashes($fr->design);
	$template->assign('design', $design);	
	$template->assign('fid', $fid);
	$template->assign('desc', $desc);
	$template->assign('downloads', $downloads);
	$template->assign('filename', $filename);
	$template->assign('filesize', $filesize);		
	$template->assign('last_download_date', $last_download_date);			
	$template->assign('date', $date);				
	$template->assign('fcode', $fcode);			
	mysql_free_result($sql_m);
	

	
	if(isset($_GET['section']) && $_GET['section'] == 'comment')
	{
		
		$sql_c = mysql_query("SELECT * FROM file_comments WHERE file_id = '".makesafe($fid)."'");
		if(mysql_num_rows($sql_c))
		{
			while($cr = mysql_fetch_object($sql_c))
			{
				$cm = stripslashes($cr->message);	
				$cid = $cr->id;
				$cname = stripslashes($cr->name);
				$cd = date('d-m-Y', strtotime($cr->date));
				$comments[] = array('comment' => $cm, 'name' => $cname, 'date' => $cd, 'id' => $cid);
			}
			$template->assign('comments', $comments);
		}		
		
		if(isset($_POST['comment']))
		{
			
			if(strlen($_POST['comment']) > 400)
			{
				$template->assign('error', 'Testimonial length shouldn\'t more than 400 characters.');
				$template->display('file_comments.tpl.php');
				return;				
			}
			
			$comment = strip_tags(makesafe($_POST['comment']));	
			$comment_name = strip_tags(makesafe($_POST['name']));	


			if(empty($comment_name))
			{
				$template->assign('error', 'Please enter name of testimonial provider.');
				$template->display('file_comments.tpl.php');
				return;				
			}			
			if(empty($comment))
			{
				$template->assign('error', 'Please enter testimonial text.');
				$template->display('file_comments.tpl.php');
				return;				
			}
			
			if(mysql_num_rows(mysql_query("SELECT id FROM file_comments WHERE file_id = '".makesafe($fid)."'")) < 3)
			{
			
			
			if(mysql_query("INSERT INTO file_comments VALUES(NULL, '".makesafe($fid)."', '$comment_name',  '$comment', NOW())"))
			{
				
			}
			
			
			}
			
		}
		
		if($_GET['act'] == 'del' && !empty($_GET['cid']))
		{
		    $_cid = makesafe(safeGet($_GET['cid']));	
			@mysql_query("DELETE FROM file_comments WHERE id = '$_cid' AND file_id = '".makesafe($fid)."'");
		}
		        $comments = NULL;
           		$sql_c = mysql_query("SELECT * FROM file_comments WHERE file_id = '".makesafe($fid)."'");
				if(mysql_num_rows($sql_c))
				{
					while($cr = mysql_fetch_object($sql_c))
					{
					    $cm = stripslashes($cr->message);	
						  $cm_name = stripslashes($cr->name);	
						$cid = $cr->id;
						$cd = date('d-m-Y', strtotime($cr->date));
						$comments[] = array('comment' => $cm, 'date' => $cd, 'id' => $cid, 'name' => $cm_name);
					}
				}
		
		  $template->assign('comments', $comments);
		  $template->display('file_comments.tpl.php');
		  return;
		
		
	}elseif(isset($_GET['section']) && $_GET['section'] == 'edit')
	{
		
       
	   if(isset($_POST['edit'])){
		
	   $design = makesafe($_POST['design']);
 	   $downloads = makesafe($_POST['downloads']);
	   $date_added = makesafe($_POST['dateadded']);	   
	   $fz = makesafe($_POST['fz']);
	   
	   if(empty($fz))
	   $fz = "0";
	   
	   $template->assign('filesize', convertFileSize($fz));
	   
	   if(empty($date_added))
	   $date_added = date('Y-m-d');
	   
	   $template->assign('downloads', $downloads);
	   $template->assign('date', $date_added);	   
	   
	   
	   if(empty($design))
	   $design = 'default';
	   
	   
	   
	   $template->assign('design', $design);		   
	   
		if(mysql_query("UPDATE files SET `design` = '$design', `filesize` = '$fz', dateadded = '$date_added', downloads = '$downloads' WHERE id = '".makesafe($fid)."' AND uid = '".makesafe($Auth->getLoggedId())."' AND upload_type = 'local'"))
		{
			
			$template->assign("success_msg", "File details has been updated successfully.");
			
		}else
		{
			echo mysql_error();
		    $template->assign('error_msg', 'Error: Some thing went wrong while updating file details');	
		}
		
		
		
	   
	   }
		
		
	}
			
	$template->display('file_details.tpl.php');
	return;
	
}elseif(isset($_GET['get'])){
    //get the file	
	$fid = safeGet($_GET['get']);
	$sql_m = mysql_query("SELECT * FROM files WHERE id = '".makesafe($fid)."' AND uid = '".makesafe($Auth->getLoggedId())."'");
	if(!mysql_num_rows($sql_m))
	{
		$template->assign('error_msg', 'invalid file.');	
	    $template->display('files.tpl.php');
    	return;		
	}
	
	$mfr = mysql_fetch_object($sql_m);
	$filename = stripslashes($mfr->filename);
	$encodedname = stripslashes($mfr->encodedname);
	$file = 'HST_USR_UPLOADED_FILES__DIR/hst_uploaded_files/'.$encodedname;
	
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	ob_clean();
	flush();
	readfile($file);	
	return;
		

	
}else if(isset($_GET['del']))
{
    //delete individual file
	$fid = safeGet($_GET['del']);	
	$sm = mysql_query("SELECT encodedname FROM  files WHERE id = '$fid' AND uid = ".makesafe($Auth->getLoggedId()));
	if(mysql_num_rows($sm))
	{
				$rm = mysql_fetch_object($sm);
				$file = "".stripslashes($rm->encodedname);
	}
	
	if(mysql_query("DELETE FROM files WHERE id = '$fid' AND uid = ".makesafe($Auth->getLoggedId())))
	{
			  
	    @unlink("HST_USR_UPLOADED_FILES__DIR/hst_uploaded_files/".$file);
	}		
	
	
		
}else if(isset($_POST['delete']))
{
	  $ids = $_POST['ids'];
	  foreach($ids as $k => $v)
	  {
				 
	      $v = makesafe($v);
							if(!empty($v))
							{
										$sm = mysql_query("SELECT encodedname FROM  files WHERE id = '$v' AND uid = ".makesafe($Auth->getLoggedId()));
										if(mysql_num_rows($sm))
										{
													$rm = mysql_fetch_object($sm);
													$file = "".stripslashes($rm->encodedname);
										}
										
										if(mysql_query("DELETE FROM files WHERE id = '$v' AND uid = ".makesafe($Auth->getLoggedId())))
										{
												  
														@unlink("HST_USR_UPLOADED_FILES__DIR/hst_uploaded_files/".$file);
										}										
										
							}
	  }
}
//end deleting files




$pagetitle = "My Files";
$page = 1;
$showPerPage = 50;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;


if(isset($_GET['q']) && !empty($_GET['q']))
{
	$q = safeGet(strip_tags($_GET['q']));
	$queryString = "q=".$q;
	$q = makesafe($q);
	$search_q = " AND filename LIKE '%$q%'";
	$template->assign('q', strip_tags($_GET['q']));
	
}
$self = "files.php?$queryString";


$sql1 = mysql_query("SELECT COUNT(id) as total FROM files WHERE uid = ".$Auth->getLoggedId()." AND upload_type  = 'local' $search_q");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No file uploaded";
   $template->assign('msg', $msg);
   $template->display('files.tpl.php');
   return;
}

//so how many pages we have?
$pages = ceil($records/$showPerPage);

//check if page is greater then number of pages 
if($page > $pages)
 {
   header("location: $self&page=$pages");
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

$query = mysql_query("SELECT * FROM files WHERE uid = ".$Auth->getLoggedId()." AND upload_type  = 'local' $search_q ORDER BY id DESC LIMIT $offset, $showPerPage");

while($row = mysql_fetch_object($query))
{

	 $date = date("d M, Y",strtotime($row->dateadded));
	 $filesize = $row->filesize;
	 $fid = $row->id;
	 $hits = $row->hits;
	 $downloads = $row->downloads;
	 $filename = $row->filename;		
	 $fullname = $filename; 
	 $file_code = $row->code;
		if(strlen($filename) > 32)
		{
		    $filename = substr($filename, 0, 30)."...";	
		}	
			
	 $files[] = array('filename' => $filename, 'date' => $date, 'hits' => $hits, 'downloads' => $downloads, 'filesize' => convertFileSize($filesize), 'id' => $fid, 'fullname' => $fullname, 'fcode' => $file_code);
	
}

$template->assign('files', $files);

$template->assign("first", $first); //First Page
$template->assign("previous", $previous); //Previous Page
$template->assign("next", $next); //Next Page
$template->assign("last", $last); //Last Page
$template->assign("records", $records);
$template->assign("page", $page);
$template->assign("pages", $pages);
$template->display('files.tpl.php');
  

?>