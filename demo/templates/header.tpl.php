
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$SITE_NAME}</title>

{if $pagekeywords ne ""}<meta name="keywords" content="{$pagekeywords}" />{elseif $SITE_KEYWORDS ne ""} <meta name="keywords" content="{$SITE_KEYWORDS}" /> {/if}
{if $pagedescription ne ""}<meta name="description" content="{$pagedescription}" />{elseif $SITE_DESCRIPTION ne ""} <meta name="description" content="{$SITE_DESCRIPTION}" /> {/if}

<link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
<link href="{$SITE_URL}templates/css/main.css" rel="stylesheet" type="text/css" />

<link href="{$SITE_URL}templates/css/main_custom.css" rel="stylesheet" type="text/css" /><!-- For Index and Publishers pages -->

<link href="{$SITE_URL}templates/css/bootstrap_v3.css" rel="stylesheet" type="text/css" />
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"></link>
<link href="{$SITE_URL}templates/css/Menustyle.css" rel="stylesheet" type="text/css" />

{if $script ne "index" && $uloggedId lt "1"}
{literal}
<style type="text/css">

body{background:url({/literal}{$SITE_URL}{literal}templates/images/guest_bg_sub.png) repeat-x;}


</style>
{/literal}
{/if}

{if $script ne "index" && $uloggedId gt "0"}
{literal}
<style type="text/css">

body{background:url({/literal}{$SITE_URL}{literal}templates/images/bg_sub.png) repeat-x;}


</style>
{/literal}
{/if}





<script type="text/javascript" src="{$SITE_URL}templates/js/jquery.js"></script>
<script type="text/javascript" src="{$SITE_URL}templates/js/bootstrap.js"></script>
<script type="text/javascript" src="{$SITE_URL}templates/js/json2.js"></script>
<script type="text/javascript" src="{$SITE_URL}templates/js/common.js"></script>
<script type="text/javascript" src="{$SITE_URL}templates/js/ajax.js"></script>

<script type="text/javascript">
var SITE_URL = '{$SITE_URL|@urldecode}';
var uid = '{$uloggedId}';
</script>


{if $uloggedId gt "0"} 
<link href="{$SITE_URL}templates/css/member.css" rel="stylesheet" type="text/css" />
<link href="{$SITE_URL}templates/css/buttons.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$SITE_URL}templates/js/jquery.dataTables.js"></script>
<link href="{$SITE_URL}templates/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$SITE_URL}templates/js/offers.js"></script>

<script type="text/javascript" src="Charts/js/FusionCharts.js"></script>

<script type='text/javascript' src='templates/js/ion.sound.js'></script>  

<script type="text/javascript">

{literal}
$(document).ready(function(){
  
$.ionSound({
  sounds: [
    "leads"
  ],
  
  path: "sounds/",
  multiPlay: true,
  volume: "1.0"
});

       

     
});

{/literal}

</script>



{include file="gateway_scripts.tpl"}

<script type="text/javascript" src="{$SITE_URL|@urldecode}templates/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{$SITE_URL|@urldecode}templates/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>   

<script type="text/javascript">
{literal}
$(document).ready(function(){

 //Dates

 if($('#date1').length > 0){

 $('#date1').datepicker({ dateFormat: "yy-mm-dd"});



 $('#date2').datepicker({ dateFormat: "yy-mm-dd"}); 



 }
  
  
});
{/literal}
</script>








{/if}



{if $script eq "country_breakdown"}
<script type='text/javascript' src='http://www.google.com/jsapi'></script>  


<script type="text/javascript">
            
{literal}
google.load('visualization', '1', {packages: ['geochart']});



function drawVisualization() {

var data = google.visualization.arrayToDataTable([

{/literal}{$country_analytics}{literal}

]);



var geochart = new google.visualization.GeoChart(

  document.getElementById('wmp'));

geochart.draw(data, {width: '100%', height: 400, backgroundColor: "#ffffff"});

}

google.setOnLoadCallback(drawVisualization);

</script>
{/literal}
{/if}



</head>

<body>
<!--Main Wrapper-->
<div class="wrapper">

<!--Top Section and Header-->
<div {if $script eq"index"} id="topSection" {else} {/if}>

<!--Top-->
<div id="top">
    <div id="top_nav">

    
    {if $uloggedId lt "1"} 
    
    <ul id="gnav">
    <li {if $script eq "index"} id="currentSel" {/if}><a href="{$SITE_URL}">Home</a></li>
    <li {if $script eq "login"} id="currentSel" {/if}><a href="{$SITE_URL}login.php">Login</a></li>
    
    <li {if $script eq "about"} id="currentSel" {/if}><a href="{$SITE_URL}about.php">About</a></li>
    <li {if $script eq "publishers"} id="currentSel" {/if}><a href="{$SITE_URL}publishers.php">Publishers</a></li>            
    <li {if $script eq "advertisers"} id="currentSel" {/if}><a href="{$SITE_URL}advertisers.php">Advertisers</a></li>                
    <li {if $script eq "contact"} id="currentSel" {/if}><a href="{$SITE_URL}contact.php">Contact</a></li>                    
    </ul>
    
    
</div>
<!--end Nav-->


</div>
<!--Top-->
{else}
    
<div class="page-container">
  <div class="sidebar-menu">
            <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> 
      <header class="logo"> 
      <div id="userPic"><img src="{$SITE_URL}templates/images/SAM_0476.JPG" align="center"></div>
      <p><i class="glyphicon glyphicon-star"></i>{$uloggedUser}</p>
      <p><a href="mailto:{$uloggedUserEmail}"><i class="glyphicon glyphicon-envelope"></i>{$uloggedUserEmail}</a></p>

    </header>
    <div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
    <div class="menu">
      <ul id="menu" >
        <li id="menu-comunicacao" ><a href="dashboard.php"><i class="glyphicon glyphicon-home icon"></i><span>Dashboard</span></a></li>

        <li id="menu-academico" ><a href="#"><i class="glyphicon glyphicon-stats icon"></i><span>Reports</span><span class="fa fa-angle-right" style="float: right"></span></a>
          <ul id="menu-academico-sub" >
            <li><a href="reports.php">Daily Report</a></li>
            <li><a href="subid_reports.php">Subid Report</a></li>
            <li><a href="country_breakdown.php">Country Report</a></li>
            <li><a href="camp_stats.php">Campaign Report</a></li>
          </ul>
        </li>
        <li><a href="#"><i class="glyphicon glyphicon-flag icon"></i><span>Search Campaigns</span><span class="fa fa-angle-right" style="float: right"></span></a>
          <ul>
            <li><a href="campaigns.php">Campaigns</a></li>
            <li><a href="create_campaign.php">Create Campaign</a></li>
            <li><a href="my_campaigns.php">My Campaigns</a></li>
          </ul>
        </li>
        <li><a href="{$SITE_URL}account.php"><i class="glyphicon  glyphicon-user icon"></i><span>Profile</span></a></li>  
        <li><a href="sendmessage.php"><i class="glyphicon glyphicon-comment"></i><span>Contact Us</span></a></li>
        <li><a href="messages.php"><i class="glyphicon glyphicon-comment"></i><span>Messages</span></a></li>
      </ul>
    </div>
  </div>
</div>

    {/if}
{if $script ne "index"} </div> {/if}
<script type="text/javascript" src="{$SITE_URL}templates/js/main.js"></script>                                                                                                                         