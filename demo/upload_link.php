<?php
require_once("header.php");
$template->assign('script', 'upload_links');

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
   	exit;
}


$uid = $Auth->getLoggedId();

if(isset($_SESSION['linkUploaded']) && $_SESSION['linkUploaded'] == 'yes')
{
    $template->assign('success_msg', 'Link has been added successfully.');		
	$_SESSION['linkUploaded'] = NULL;
	unset($_SESSION['linkUploaded']);
}


if(isset($_POST['upload_link']))
{
    $name = $_POST['link_name'];
	$link = $_POST['link_url'];
	$desc = $_POST['desc'];
	$template->assign('link_name', $name);
	$template->assign('link_url', $link);
	$template->assign('desc', $desc);								
				
	if(empty($link) || !validURL($link))
	{
            if(empty($link))
			{
				  $err = "Link url is required.";
			}elseif(!validURL($link))
			{
				  $err = "Enter valid link address (include http://).";
			}
			$template->assign('error_msg', $err);
			$template->display('upload_link.tpl.php');
			return;
						
	}
				
				

$code = substr(md5("f_".strtotime('now').uniqid()), 0, rand(5,12));
while(mysql_num_rows(mysql_query("SELECT id FROM files WHERE `code` = '$code'")))
{
	$code = substr(md5("f_".strtotime('now').uniqid()), 0, rand(5,12));
}

                    
$sql = "INSERT INTO links VALUES (NULL, '$uid', '$code', 0, 0, NOW(), NULL, '".makesafe($desc)."', '".makesafe($link)."')";

			
				if(mysql_query($sql))
				{
								$template->assign('link_name', '');
								$template->assign('link_url', '');
								$template->assign('desc', '');					   
				    $_SESSION['linkUploaded'] = 'yes';
					header("location: upload_link.php?success=1");
					exit;
				}else
				{
				    $template->assign('error_msg', 'An error occured while uploading link.'.mysql_error());	
				}		
				
				 
				 $template->display("upload_link.tpl.php");
				
				
}else
{
    $template->display("upload_link.tpl.php");	
}



?>