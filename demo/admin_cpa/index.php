<?php
require_once("header.php");

if(!isset($_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST']))
{
	session_unset();
	session_destroy();
    header("location: login.php");
   	exit;
}


$m = makesafe($_GET['m']);
if(empty($m))
{
    $m = "stats";
}

require_once("header_layout.php"); //Global Header Layout File.




switch($m)
{
	
	case "main":
	default:
	include("main.php");
	break;
	
	case "news_comments":
	include("news_comments/comments.php");
	break;	
	
		case "u_offers":
	include("user_offers/offers.php");
	break;		
	
	
	
		case "leads":
	include("leads/leads.php");
	break;	
	
		case "gw_leads":
	include("gw_leads/leads.php");
	break;		
	
		case "gateways":
	include("gateways/gateways.php");
	break;		
	
		case "links":
	include("links/links.php");
	break;		
	
	

		
	
		
		
    case "settings":
	include("settings/settings.php");
	break;
	
    case "news":
	include("news/news.php");
	break;	
	
    case "banned_offers":
	include("banned_offers/offers.php");
	break;	
	
    case "change_password":
    case "admins":	
	include("admins/admins.php");
	break;	


	case "users":
	include("users/users.php");
	break;
	

	
	case "cashouts":
	include("cashouts/cashouts.php");
	break;
	
	case "ipbans":
	include("ipbans/ipbans.php");
	break;	
	
	

	
	case "offers":
	include("offers/offers.php");
	break;	
	

	
	case "networks":
	include("networks/networks.php");
	break;	
	

	
	case "messages":
	include("messages/messages.php");
	break;	
	
	case "private_messages":
	include("private_messages/messages.php");
	break;				
	
	case "stats":
	include("stats/stats.php");
	break;	
	
	
}

require_once("footer_layout.php"); //Global Footer Layout File.
?>