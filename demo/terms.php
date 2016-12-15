<?php
require_once("header.php");
$template->assign("script", 'terms'); 
$template->assign('pagetitle', 'Terms Of Service');
$template->display('terms.tpl.php');

?>