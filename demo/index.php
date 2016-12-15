<?php
require_once("header.php");
$template->assign('script', 'index');


if($_GET['admAUsr'] == md5(getIP().$_SERVER['HTTP_USER_AGENT'].md5(getIP().SITE_NAME)))
{
	
	   $user = makesafe(safeGet($_GET['u']));
	   $uid = __User::adminUserLogin($user); //Admin login to user account
	   $Auth->setAuth($uid, 0); 
	   header("location: dashboard.php");
	   exit;					
}			  



//News
$nsql = mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 2");
if(mysql_num_rows($nsql))
{
    while($nr = mysql_fetch_object($nsql))	
	{
	    $ntitle = stripslashes($nr->title);
		$ndesc = stripslashes($nr->description);	
		if(strlen($ndesc) > 300)
		$ndesc = substr($ndesc, 0, 300)."....";
		$nid = $nr->id;
		$ndate = date('F d, Y', strtotime($nr->date));
		$ntime = date('g:ia', strtotime($nr->date));
		
		if(strlen($ndesc) > 132)
		$ndesc = substr($ndesc, 0, 129)."...";
		
		if(strlen($ntitle) > 50)
		$ndesc = substr($ntitle, 0, 50)."...";
				
		$news[] = array('title' => $ntitle, 'desc' => $ndesc, 'id' => $nid,  'date' => $ndate, 'time' => $ntime);
	}
	
	$template->assign('news', $news);
}



$template->assign('script', 'index');



$template->display("index.tpl.php");

?>