<?php
require_once('header.php'); 

$template->assign('page', 'gateways');
$template->assign('script', 'edit');

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$uid = $Auth->getLoggedId();
if(empty($_GET['gid']))
{
    header("location: gateways.php");
	exit;
	
}

$gid = makesafe(safeGet($_GET['gid']));
$template->assign('gid', $gid);



if(isset($_POST['edit']))
{
	$wid = $_POST['wid'];
	$background_img = $_POST['bg_img'];
	$bg_color = $_POST['bg_color'];
	$gw_name = $_POST['gw_name'];
	$gw_title = $_POST['gw_title'];
	$overlay_opacity = $_POST['overlay_opacity'];
	$overlay_color = $_POST['overlay_color'];
	$gw_width = $_POST['gw_width'];
	$gw_height = $_POST['gw_height'];	
    $instructions =  $_POST['instructions'];	

	$title_color = $_POST['title_color'];
	$title_size = $_POST['title_size'];
	$title_font = $_POST['title_font'];	
	
	$offer_color = $_POST['offer_color'];
	$offer_bold = $_POST['offer_bold'];
	$offer_size = $_POST['offer_size'];
    $offer_font = $_POST['offer_font'];	
	
	$instructions_color = $_POST['instructions_color'];
	$instructions_size = $_POST['instructions_size'];
	$instructions_font = $_POST['instructions_font'];

	$border_color = $_POST['border_color'];
	$border_size = $_POST['border_size'];
	$period_type = $_POST['period_type'];
    $unlock_period = $_POST['unlock_period'];
	$lock_ip = $_POST['lock_ip'];
	$redirect_url = $_POST['redirect_url'];
	$load_time = $_POST['load_time'];
    $include_close = $_POST['include_close'];
	$offers_show = $_POST['offers_show'];
	
	
	if(empty($offer_bold))
	$offer_bold = 0;
	
	if(empty($wid))
	$wid = 0;
	
	if(empty($load_time))
	$load_time = '0';
	
	if(empty($unlock_period))
	$unlock_period = '0';
	
	if(empty($lock_ip))
	$lock_ip = '0';

	if(empty($include_close))
	$include_close = '0';

	
	if(empty($overlay_opacity))
	$overlay_opacity = 100;
	
    //Assign variables to smarty
	$template->assign('gw_name', $gw_name);
	$template->assign('bg_img', $background_img);
	$template->assign('bg_color', $bg_color);
	$template->assign('overlay_opacity', $overlay_opacity);
	$template->assign('overlay_color', $overlay_color);	
	$template->assign('gw_width', $gw_width);
	$template->assign('gw_height', $gw_height);
    $template->assign('wid', $wid);
    $template->assign('offers_show', $offers_show);	

	$template->assign('offer_color', $offer_color);
	$template->assign('offer_size', $offer_size);
	$template->assign('offer_font', $offer_font);
	$template->assign('offer_bold', $offer_bold);	
	$template->assign('period_type', $period_type);
    $template->assign('title_size', $title_size);
    $template->assign('title_color', $title_color);	
    $template->assign('title_font', $title_font);		
	
	$template->assign('border_color', $border_color);
	$template->assign('border_size', $border_size);
	
	$template->assign('load_time', $load_time);
	$template->assign('gw_title', html_entity_decode($gw_title));
    $template->assign('instructions', html_entity_decode($instructions));
    $template->assign('instructions_color', $instructions_color);	
    $template->assign('instructions_font', $instructions_font);	
    $template->assign('instructions_size', $instructions_size);			
	
	$template->assign('redirect_url', $redirect_url);	
	$template->assign('unlock_period', $unlock_period);
	$template->assign('lock_ip', $lock_ip);
	$template->assign('include_close', $include_close);	
	




	//gateway country targeting
	//Gateway will be shown in specified countries only, All for all countries.
	
	$target_countries = $_POST['target_countries'];
	$template->assign('target_countries', $target_countries);
	if($target_countries == "other")
	{
	    $countries = $_POST['targeted_countries'];
	    
		if(empty($countries))
		{
			$template->assign('targeted_countries', 0);
		}else{
		
		//prepare countries codes and names to assign to template to prefill countries provided.
		$tcountries = explode(",",$countries);
		foreach($tcountries as $tc)
		{
		    $tcountries_arr[] = array("id" => $tc, "name" => getCountryName($tc));	
		}
		
		$template->assign('targeted_countries', json_encode($tcountries_arr));	
		
		
		}
			
	}else
	{
	    $countries = $target_countries;	
	}
	
	$countries_bypass = makesafe($countries);	

		//Validate Fields 
	
	if(empty($gw_name) || (empty($bg_color) && empty($background_img)) || empty($gw_width) || empty($gw_height) || strlen($gw_title) > 200 || strlen($instructions) > 400 ||  empty($_POST['targeted_countries']) && $target_countries == "other" || empty($countries)) {
	
	
    if((empty($bg_color) && empty($background_img))){
		
		$error_msg = "Either select background template or background color..";	
		$st = 'gw_step1';
		
	}elseif(empty($gw_width)){
		
		$error_msg = "Enter gateway width.";	
		$st = 'gw_step1';
		
	}elseif(empty($gw_height)){
		
		$error_msg = "Enter gateway height.";	
		$st = 'gw_step1'; 
		
	}elseif(strlen($gw_title) > 200)
	{
		$error_msg = "Maximum 200 characters allowed for header text.";	
		$st = 'gw_step1'; 		
	}elseif(strlen($instructions) > 400)
	{
		$error_msg = "Maximum 200 characters allowed for instructions text.";	
		$st = 'gw_step1'; 		
	}elseif(empty($_POST['targeted_countries']) && $target_countries == "other" || empty($countries))
	{
		$error_msg = "Please choose countries you want to show gateway for.";	
		$st = 'gw_step3';
	}elseif(empty($gw_name))
	{
		$error_msg = "Please enter gateway name.";
        $st = 'gw_step1';

	}
	    $template->assign('current_step', $st); //st => step to show 
		$template->assign("error_msg", $error_msg);
		$template->display("edit.tpl.php");
		return;		
	
	}
	
	//End Fields Validating	
	
//	$gw_title = nl2br($gw_title);
//	$instructions = nl2br($instructions);
		
	if(empty($border_size))
	$border_size = 0;	

		
	

    $uid = makesafe($uid);
    $wid = makesafe($wid);
	$background_img = makesafe($background_img);
	$bg_color = makesafe($bg_color);
	$gw_name = makesafe($gw_name);
	$gw_title = makesafe($gw_title);
	$overlay_opacity = makesafe($overlay_opacity);
	$overlay_color = makesafe($overlay_color);
	$gw_width = makesafe($gw_width);
	$gw_height = makesafe($gw_height);	
    $instructions =  makesafe($instructions);	

	$title_color = makesafe($title_color);
	$title_size = makesafe($title_size);
	$title_font = makesafe($title_font);	
	$offers_show = makesafe($offers_show);		
	
	$offer_color = makesafe($offer_color);
	$offer_bold = makesafe($offer_bold);
	$offer_size = makesafe($offer_size);
    $offer_font = makesafe($offer_font);	
	
	$instructions_color = makesafe($instructions_color);
	$instructions_size = makesafe($instructions_size);
	$instructions_font = makesafe($instructions_font);

	$border_color = makesafe($border_color);
	$border_size = makesafe($border_size);
	$period_type = makesafe($period_type);
    $unlock_period = makesafe($unlock_period);
	$lock_ip = makesafe($lock_ip);
	$redirect_url = makesafe($redirect_url);
	$load_time = makesafe($load_time);
    $include_close = makesafe($include_close);
	
	
	//default sizes and fonts
	if(empty($title_size))
	$title_size = 16;	
	
	if(empty($title_font))
	$title_font = 'Arial';
	
	if(empty($offer_size))
	$offer_size = '13';
	
	if(empty($offer_font))
	$offer_font = 'Arial';
	
    if(empty($instructions_size))
	$instructions_size = '12';
	
	if(empty($instructions_font))
	$instructions_font = 'Arial';

	
	
	$update_query = "UPDATE gateways SET `name` = '".$gw_name."', `title` = '".$gw_title."', `instructions` = '$instructions',  `countries` = '".$countries_bypass."', background_img_url = '$background_img', `background_color` = '$bg_color',  	`overlay_opacity` = '".$overlay_opacity."', `overlay_color` = '".$overlay_color."', `width` = '".$gw_width."', `height` = '".$gw_height."', `title_color` = '$title_color', `title_font` = '$title_font', `title_size` = '$title_size', `offer_color` = '$offer_color', `offer_size` = '$offer_size', `offer_bold` = '$offer_bold', `offer_font` = '$offer_font', `instructions_color` = '$instructions_color', `instructions_size` = '$instructions_size', `instructions_font` = '$instructions_font', `border_color` = '$border_color', `border_size` = '$border_size', `unlock_period` = '$unlock_period', `ip_lock` = '$lock_ip', `redirect_url` = '$redirect_url', `start_delay` = '$load_time', `include_close` = '$include_close', `wid` = '$wid', offers_show = '$offers_show', period_type = '$period_type' WHERE gid = '$gid' AND uid = '$uid' LIMIT 1 ";
	
	if(mysql_query($update_query))
	{
	    $template->assign('success_msg', 'Gateway settings has been edited.');	
	}else
	{
	    $template->assign('error_msg', 'Gateway settings couldn\'t be edited.');	
	}
					
	
	
}else
{
   
   
   $sql_s = mysql_query("SELECT * FROM gateways WHERE gid = '$gid' AND uid = '".makesafe($uid)."' LIMIT 1");
   if(!mysql_num_rows($sql_s))
   {
	   $template->assign('error_msg', 'Invalid Gateway.');
	   $template->display('msg.tpl.php');
	   return;
   }
   
   $gr = mysql_fetch_array($sql_s);
   
    $wid = $gr['wid'];
	$background_img = $gr['background_img_url'];
	$bg_color = $gr['background_color'];
	$gw_name = $gr['name'];
	$gw_title = $gr['title'];
	$overlay_opacity = $gr['overlay_opacity'];
	$overlay_color = $gr['overlay_color'];
	$gw_width = $gr['width'];
	$gw_height = $gr['height'];	
    $instructions =  $gr['instructions'];	

	$title_color = $gr['title_color'];
	$title_size = $gr['title_size'];
	$title_font = $gr['title_font'];	
	
	$offer_color = $gr['offer_color'];
	$offer_bold = $gr['offer_bold'];
	$offer_size = $gr['offer_size'];
    $offer_font = $gr['offer_font'];	
	
	$instructions_color = $gr['instructions_color'];
	$instructions_size = $gr['instructions_size'];
	$instructions_font = $gr['instructions_font'];

	$border_color = $gr['border_color'];
	$border_size = $gr['border_size'];
	
    $unlock_period = $gr['unlock_period'];
	$lock_ip = $gr['ip_lock'];
	$redirect_url = $gr['redirect_url'];
	$load_time = $gr['start_delay'];
    $include_close = $gr['include_close'];
	
    $offers_show = $gr['offers_show'];
    $period_type = $gr['period_type'];

	
	$target_countries = $gr['countries'];
	$template_name = $gr['template'];
	
    //Assign variables to smarty
	$template->assign('gw_name', $gw_name);
	$template->assign('bg_img', $background_img);
	$template->assign('bg_color', $bg_color);
	$template->assign('overlay_opacity', $overlay_opacity);
	$template->assign('overlay_color', $overlay_color);	
	$template->assign('gw_width', $gw_width);
	$template->assign('gw_height', $gw_height);
    $template->assign('wid', $wid);

	$template->assign('offer_color', $offer_color);
	$template->assign('offer_size', $offer_size);
	$template->assign('offer_font', $offer_font);
	$template->assign('offer_bold', $offer_bold);	
	
    $template->assign('title_size', $title_size);
    $template->assign('title_color', $title_color);	
    $template->assign('title_font', $title_font);
	$template->assign('offers_show', $offers_show);		
	
	$template->assign('border_color', $border_color);
	$template->assign('border_size', $border_size);
		$template->assign('load_time', $load_time);
	$template->assign('gw_title', html_entity_decode($gw_title));

    $template->assign('instructions', html_entity_decode($instructions));
    $template->assign('instructions_color', $instructions_color);	
    $template->assign('instructions_font', $instructions_font);	
    $template->assign('instructions_size', $instructions_size);			
	
	$template->assign('redirect_url', $redirect_url);	
	$template->assign('unlock_period', $unlock_period);
	$template->assign('lock_ip', $lock_ip);
	$template->assign('include_close', $include_close);	
	$template->assign('period_type', $period_type);
	
	
	$template->assign('target_countries', $target_countries);
	if($target_countries != "All" && $target_countries != "US,GB,CA,AU")
	{
	    $countries = $target_countries;
	    $template->assign('target_countries', 'other');   //overwrite
		if(empty($countries))
		{
			$template->assign('targeted_countries', 0);
		}else{
		
		//prepare countries codes and names to assign to template to prefill countries provided.
		$tcountries = explode(",",$countries);
		foreach($tcountries as $tc)
		{
		    $tcountries_arr[] = array("id" => $tc, "name" => getCountryName($tc));	
		}
		
		$template->assign('targeted_countries', json_encode($tcountries_arr));	
		
		
		}
			
	}else
	{
  	    $template->assign('targeted_countries', 0);	
	}
	
	
	
	   
   
   
   
}


$template->display('edit.tpl.php');

	





?>