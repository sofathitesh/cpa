<?php
require_once('header.php'); 
if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$template->assign('mainScript', 'gateways');

$uid = $Auth->getLoggedId();

if(isset($_GET['gwd']))
{
	$gid = safeGet($_GET['gwd']);
	$template->assign('gid', $gid);

	$template->assign('uid', $uid);
    $template->display('gw_preview.tpl.php');
	
	return;
}


?>