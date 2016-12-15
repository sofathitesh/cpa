<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=SITE_NAME?> - <?=ucfirst($m)?> | Control Panel</title>

<script type="text/javascript" src="js/jquery.js"></script>
<link href="css/bootstrap_v3.css" rel="stylesheet" type="text/css"  />
<!--<script type="text/javascript" src="js/bootstrap.js"></script>-->



<style type="text/css">
img {
behavior:url('../templates/js/iepngfix.htc') !important;
}

.clear{clear:both;}
.left{float:left}
.right{float:right}

*{margin:0; padding:0}
body{font-size:13px; font-family:Arial; background:#fff}
#main{width:100%; display:table;}
#wrapper{width:1200px; clear:both; margin:0px auto;}

#top{clear:both; height:103px;  overflow:hidden; margin-top:0; background:#101010}
#logo{float:left; margin:0;}
#login_div{width:520px; float:right}
#login_div #login_form{clear:both; color:#515151; margin-top:24px; font-size:12px}
.loginBtn{height:39px; margin-left:10px; float:left}
#login_div a{color:#515151; text-decoration:none}
#login_div a:hover{color:#515151; text-decoration:underline}

#welcome{color:#fffffe; font-size:16px; padding-top:35px; width:400px; float:right; text-align:right; font-family:Arial}
#welcome a{text-decoration:none; color:#9b9b9b; font-size:14px}
#welcome a:hover{text-decoration:underline;}

#header{background:url(images/top_bg.jpg) repeat-x ; height:109px;}




.searchContainer
{margin:15px 0; background:#f1f0f0; padding:5px; clear:both;  border:1px solid #ebe3f3}

#content{width:1200px; margin:20px auto; display:table;  clear:both; }
.module_title{font-size:15px; font-weight:bold;  text-decoration:underline}


#nav
{
   width:1200px;
   clear:both;
			margin:0 auto;
			height:50px;

}

#nav img{float:left; margin-top:1px;}

#nav a.navLink
{
margin-top:1px;
float:left;
text-decoration:none;
color:#fff;
padding-left:10px;
font-weight:bold;
padding:14px 20px;
height:22px;
}


#nav a:hover
{
color:#FFFFFF; text-decoration:none; background:url(images/hover.jpg) repeat-x;
}

#current
{
color:#FFFFFF !important; text-decoration:none; background:url(images/hover.jpg) repeat-x;
}

.settings_table input[type=text]
{
width:300px;
height:20px;
padding:2px;
}


.listings
{
width:100%;
text-align:center;
border:1px solid #e5e5e5;

}

.listings th{height:27px;}

.listings td{height:25px}

.paginginfo{color:#252525; font-size:10px;}
.paginginfo a{color:#252525; font-size:10px; font-weight:bold; margin-left:5px; text-decoration:none}


#leftPanel {float:left; width:190px; padding:10px; border:1px solid #ffffff}
#rightPanel {float:right; width:980px;}


.currentNav{font-weight:bold}

</style>
<script type="text/javascript" src="js/jlib.js"></script>
<script type="text/javascript" src="js/Ajax.js"></script>


  <!-- Required CSS Files -->
  <link type="text/css" href="assets/css/required/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <link type="text/css" href="assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.min.css" rel="stylesheet" />
  <link type="text/css" href="assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.structure.min.css" rel="stylesheet" />
  <link type="text/css" href="assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.theme.min.css" rel="stylesheet" />
  <link type="text/css" href="assets/css/required/mCustomScrollbar/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
  <link type="text/css" href="assets/css/required/icheck/all.css" rel="stylesheet" />
  <link type="text/css" href="assets/fonts/metrize-icons/styles-metrize-icons.css" rel="stylesheet">

  <!-- Optional CSS Files -->
  <link type="text/css" href="assets/css/optional/jqvmap/jqvmap.css" rel="stylesheet" />
  <link type="text/css" href="assets/css/optional/jqvmap/circloid-jqvmap.css" rel="stylesheet" />
  <link type="text/css" href="assets/css/optional/fullcalendar/fullcalendar.min.css" rel="stylesheet" />
  <link type="text/css" href="assets/css/optional/fullcalendar/circloid-fullcalendar.css" rel="stylesheet" />
  <link type="text/css" href="assets/css/optional/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print" />
  <link type="text/css" href="assets/css/optional/bootstrap-datetimepicker.min.css" rel="stylesheet" />
  <!-- add CSS files here -->

  <!-- More Required CSS Files -->
  <link type="text/css" href="assets/css/styles-core.css" rel="stylesheet" />
  <link type="text/css" href="assets/css/styles-core-responsive.css" rel="stylesheet" />

  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="assets/js/required/misc/ie10-viewport-bug-workaround.js"></script>

<!--tour-->
<link href="css/bootstrap-tour.min.css" rel="stylesheet">
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-tour.min.js"></script>
<!--tour-->

</head>
<body>


<!--implement -->

<div id="header-container" class="">
      <div class="header-bar navbar navbar-inverse" role="navigation"> <!-- NOTE TO READER: Accepts the following class(es) "navbar-fixed-top" class -->
        <div class="container">
          <div class="navbar-header">
            <!-- START logo -->
            <div class="logo">
              <a href="index.php">
                <img class="default-logo" src="assets/images/required/logo-default.png" width="156" height="44" alt="Logo">
                <img class="small-logo" src="assets/images/required/logo-small.png" width="48" height="44" alt="Logo">
              </a>
            </div>
            <!-- END logo -->

            <!-- START Mobile Menu Toggle -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!-- END Mobile Menu Toggle -->

            <!-- START Language Selector -->
            <!-- END Language Selector -->
            <!-- START Header Info Container -->
            <div class="header-info">
              <!-- START Header User Profile -->
              <div class="header-profile"> <!-- NOTE TO READER: Accepts the following class(es) "animate" class -->
                <ul class="header-profile-menu">
                  <li>
                    <a href="#" class="top">
                      <span class="main-menu-text">
                        Welcome, <?=$_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST_NAME']?>
                        <i class="icon icon-arrow-down-bold-round icon-size-small"></i>
                      </span>
                    </a>
                    <ul>
                      <li>
                        <a href="signout.php">
                          <span aria-hidden="true" class="icon icon-arrow-curve-right"></span>
                          <span class="main-text">Logout</span>
                        </a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
              <!-- END Header User Profile -->
            </div>
            <!-- END Header Info Container -->

          </div>
        </div>
      </div>
    </div>


<div id="left-column" class=""> <!-- NOTE TO READER: Accepts the following class(es) "menu-icon-only", "fixed" class -->
        <div id="mainnav">
          <ul class="mainnav" style="position: relative;"> <!-- NOTE TO READER: Accepts the following class(es) "animate" class -->
            <li class="menu-item-top <?php if($m == "stats"){ ?> selected <? } ?>">
              <a href="index.php?m=stats" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon-triple-points"></span>
                </span>
                <span class="main-menu-text">Statistics</span>
              </a>
            </li>

            <li class="menu-item-top">
              <a href="#" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon-text-align-left"></span>
                </span>
                <span class="main-menu-text">Campaigns</span>
              </a>
              <ul style="position: absolute;">
                <li><a href="index.php?m=offers">Campaigns</a></li>
                <li><a href="index.php?m=u_offers">Affiliate Campaigns</a></li>
                <li><a href="index.php?m=banned_offers">Banned Offers</a></li>
              </ul>
            </li>

            <li class="menu-item-top <?php if($m == "users"){ ?> selected <? } ?>">
              <a href="index.php?m=users" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon-user-remove"></span>
                </span>
                <span class="main-menu-text">Affiliates</span>
              </a>
            </li>
            
            <li class="menu-item-top <?php if($m == "settings"){ ?> selected <? } ?>">
              <a href="index.php?m=settings" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon-check"></span>
                </span>
                <span class="main-menu-text">Settings</span>
              </a>
            </li>

            <li class="menu-item-top <?php if($m == "cashouts"){ ?> selected <? } ?>">
              <a href="index.php?m=cashouts" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon icon-dollar"></span>
                </span>
                <span class="main-menu-text">Cashouts</span>
              </a>
            </li>

            <li class="menu-item-top <?php if($m == "news"){ ?> selected <? } ?>">
              <a href="index.php?m=news" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon icon-italic"></span>
                </span>
                <span class="main-menu-text">News</span>
              </a>
            </li>

            <li class="menu-item-top <?php if($m == "networks"){ ?> selected <? } ?>">
              <a href="index.php?m=networks" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon icon-dot-square"></span>
                </span>
                <span class="main-menu-text">Networks</span>
              </a>
            </li>

                 <li class="menu-item-top <?php if($m == "messages"){ ?> selected <? } ?>">
              <a href="index.php?m=messages" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon icon-comment"></span>
                </span>
                <span class="main-menu-text">Messages</span>
              </a>
            </li>



            <li class="menu-item-top <?php if($m == "leads"){ ?> selected <? } ?>">
              <a href="index.php?m=leads" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon icon-dollar"></span>
                </span>
                <span class="main-menu-text">Leads</span>
              </a>
            </li>

            <li class="menu-item-top <?php if($m == "links"){ ?> selected <? } ?>">
              <a href="index.php?m=links" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon icon-arrow-curve-left"></span>
                </span>
                <span class="main-menu-text">Links</span>
              </a>
            </li>

            <li class="menu-item-top <?php if($m == "gateways"){ ?> selected <? } ?>">
              <a href="index.php?m=gateways" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon icon-multi-borders"></span>
                </span>
                <span class="main-menu-text">Gateways</span>
              </a>
            </li>

            <li class="menu-item-top <?php if($m == "ipbans"){ ?> selected <? } ?>">
              <a href="index.php?m=ipbans" class="top">
                <span class="main-menu-icon">
                  <span aria-hidden="true" class="icon icon-ban-circle"></span>
                </span>
                <span class="main-menu-text">Ban IPs</span>
              </a>
            </li>

          </ul>
        </div>
      </div>




<!-- implement -->

<!--

<ul>
<li <?php if($m == "settings"){ ?> class="currentNav" <? } ?>><a href="index.php?m=settings">Settings</a></li>
<li <?php if($m == "users"){ ?> class="currentNav" <? } ?>><a href="index.php?m=users">Affiliates</a></li>
<li <?php if($m == "cashouts"){ ?> class="currentNav" <? } ?>><a href="index.php?m=cashouts">Cashouts</a></li>
<li <?php if($m == "stats"){ ?> class="currentNav" <? } ?>><a href="index.php?m=stats">Stats</a></li>
<li <?php if($m == "news"){ ?> class="currentNav" <? } ?>><a href="index.php?m=news">News</a></li>
<li <?php if($m == "offers"){ ?> class="currentNav" <? } ?>><a href="index.php?m=offers">Campaigns</a></li>
<li <?php if($m == "u_offers"){ ?> class="currentNav" <? } ?>><a href="index.php?m=u_offers">Affiliate Campaigns</a></li>
<li <?php if($m == "banned_offers"){ ?> class="currentNav" <? } ?>><a href="index.php?m=banned_offers">Banned Offers</a></li>
<li <?php if($m == "networks"){ ?> class="currentNav" <? } ?>><a href="index.php?m=networks">Networks</a></li>
<li <?php if($m == "messages"){ ?> class="currentNav" <? } ?>><a href="index.php?m=messages">Messages</a></li>

<li <?php if($m == "leads"){ ?> class="currentNav" <? } ?>><a href="index.php?m=leads">Leads</a></li>
<li <?php if($m == "links"){ ?> class="currentNav" <? } ?>><a href="index.php?m=links">Links</a></li>
<li <?php if($m == "gateways"){ ?> class="currentNav" <? } ?>><a href="index.php?m=gateways">Gateways</a></li>
<li <?php if($m == "ipbans"){ ?> class="currentNav" <? } ?>><a href="index.php?m=ipbans">Ban IPs</a></li>
<li <?php if($m == "signout"){ ?> class="currentNav" <? } ?>><a href="signout.php">Logout</a></li>
-->

<div id="right-column">
        <div class="right-column-content">

