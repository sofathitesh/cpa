<?php
require_once('header.php'); 

$template->assign('page', 'gateways');
$template->assign('script', 'create');
if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

if(isset($_GET['wid']) && !empty($_GET['wid']))
{
   $wid = safeGet($_GET['wid']); 	
   $template->assign('wid', $wid);
}


$template->display('template_chooser.tpl.php');

?>