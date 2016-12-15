<?php
require_once('header.php');
if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}
$template->assign('script', 'news');


//View News Page
if(isset($_GET['nid']) && !empty($_GET['nid']))
{
	
	
    $nid = makesafe(safeGet($_GET['nid']));		
	
	$nsql = mysql_query("SELECT * FROM news WHERE id = '$nid' LIMIT 1");
	if(mysql_num_rows($nsql))
	{
	    $nro = mysql_fetch_object($nsql);
		$new_title = stripslashes($nro->title);
		$news_description = stripslashes($nro->description);
		$author = stripslashes($nro->written_by);
		$date = date("F d, Y", strtotime($nro->date));
		$img = stripslashes($nro->img);
		$date_day = stripslashes(date('jS' ,strtotime($nro->date)));
  	    $date_month = stripslashes(date('M' ,strtotime($nro->date)));	
		$date_year = stripslashes(date('Y' ,strtotime($nro->date)));		
		
		
		$template->assign('date_day', $date_day);
		$template->assign('date_month', $date_month);
		$template->assign('date_year', $date_year);
		$template->assign('nid', $nid);		
		$template->assign('title', $new_title);
		$template->assign('description', $news_description);
		$template->assign('author', $author);
		$template->assign('date', $date);						
		$template->assign('img', $img);								
	
	
	

	}
	
    
}

$template->display('view_news.tpl.php');

?>