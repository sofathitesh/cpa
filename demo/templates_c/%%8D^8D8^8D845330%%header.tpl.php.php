<?php /* Smarty version 2.6.26, created on 2016-12-16 12:27:15
         compiled from header.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urldecode', 'header.tpl.php', 53, false),)), $this); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['SITE_NAME']; ?>
</title>

<?php if ($this->_tpl_vars['pagekeywords'] != ""): ?><meta name="keywords" content="<?php echo $this->_tpl_vars['pagekeywords']; ?>
" /><?php elseif ($this->_tpl_vars['SITE_KEYWORDS'] != ""): ?> <meta name="keywords" content="<?php echo $this->_tpl_vars['SITE_KEYWORDS']; ?>
" /> <?php endif; ?>
<?php if ($this->_tpl_vars['pagedescription'] != ""): ?><meta name="description" content="<?php echo $this->_tpl_vars['pagedescription']; ?>
" /><?php elseif ($this->_tpl_vars['SITE_DESCRIPTION'] != ""): ?> <meta name="description" content="<?php echo $this->_tpl_vars['SITE_DESCRIPTION']; ?>
" /> <?php endif; ?>

<link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
<link href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/css/main.css" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/css/main_custom.css" rel="stylesheet" type="text/css" /><!-- For Index and Publishers pages -->

<link href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/css/bootstrap_v3.css" rel="stylesheet" type="text/css" />
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"></link>
<link href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/css/Menustyle.css" rel="stylesheet" type="text/css" />

<?php if ($this->_tpl_vars['script'] != 'index' && $this->_tpl_vars['uloggedId'] < '1'): ?>
<?php echo '
<style type="text/css">

body{background:url('; ?>
<?php echo $this->_tpl_vars['SITE_URL']; ?>
<?php echo 'templates/images/guest_bg_sub.png) repeat-x;}


</style>
'; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['script'] != 'index' && $this->_tpl_vars['uloggedId'] > '0'): ?>
<?php echo '
<style type="text/css">

body{background:url('; ?>
<?php echo $this->_tpl_vars['SITE_URL']; ?>
<?php echo 'templates/images/bg_sub.png) repeat-x;}


</style>
'; ?>

<?php endif; ?>





<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/json2.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/ajax.js"></script>

<script type="text/javascript">
var SITE_URL = '<?php echo urldecode($this->_tpl_vars['SITE_URL']); ?>
';
var uid = '<?php echo $this->_tpl_vars['uloggedId']; ?>
';
</script>


<?php if ($this->_tpl_vars['uloggedId'] > '0'): ?> 
<link href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/css/member.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/css/buttons.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/jquery.dataTables.js"></script>
<link href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/offers.js"></script>

<script type="text/javascript" src="Charts/js/FusionCharts.js"></script>

<script type='text/javascript' src='templates/js/ion.sound.js'></script>  

<script type="text/javascript">

<?php echo '
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

'; ?>


</script>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "gateway_scripts.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript" src="<?php echo urldecode($this->_tpl_vars['SITE_URL']); ?>
templates/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo urldecode($this->_tpl_vars['SITE_URL']); ?>
templates/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>   

<script type="text/javascript">
<?php echo '
$(document).ready(function(){

 //Dates

 if($(\'#date1\').length > 0){

 $(\'#date1\').datepicker({ dateFormat: "yy-mm-dd"});



 $(\'#date2\').datepicker({ dateFormat: "yy-mm-dd"}); 



 }
  
  
});
'; ?>

</script>








<?php endif; ?>



<?php if ($this->_tpl_vars['script'] == 'country_breakdown'): ?>
<script type='text/javascript' src='http://www.google.com/jsapi'></script>  


<script type="text/javascript">
            
<?php echo '
google.load(\'visualization\', \'1\', {packages: [\'geochart\']});



function drawVisualization() {

var data = google.visualization.arrayToDataTable([

'; ?>
<?php echo $this->_tpl_vars['country_analytics']; ?>
<?php echo '

]);



var geochart = new google.visualization.GeoChart(

  document.getElementById(\'wmp\'));

geochart.draw(data, {width: \'100%\', height: 400, backgroundColor: "#ffffff"});

}

google.setOnLoadCallback(drawVisualization);

</script>
'; ?>

<?php endif; ?>



</head>

<body>
<!--Main Wrapper-->
<div class="wrapper">

<!--Top Section and Header-->
<div <?php if ($this->_tpl_vars['script'] == 'index'): ?> id="topSection" <?php else: ?> <?php endif; ?>>

<!--Top-->
<div id="top">
    <div id="top_nav">

    
    <?php if ($this->_tpl_vars['uloggedId'] < '1'): ?> 
    
    <ul id="gnav">
    <li <?php if ($this->_tpl_vars['script'] == 'index'): ?> id="currentSel" <?php endif; ?>><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
">Home</a></li>
    <li <?php if ($this->_tpl_vars['script'] == 'login'): ?> id="currentSel" <?php endif; ?>><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
login.php">Login</a></li>
    
    <li <?php if ($this->_tpl_vars['script'] == 'about'): ?> id="currentSel" <?php endif; ?>><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
about.php">About</a></li>
    <li <?php if ($this->_tpl_vars['script'] == 'publishers'): ?> id="currentSel" <?php endif; ?>><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
publishers.php">Publishers</a></li>            
    <li <?php if ($this->_tpl_vars['script'] == 'advertisers'): ?> id="currentSel" <?php endif; ?>><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
advertisers.php">Advertisers</a></li>                
    <li <?php if ($this->_tpl_vars['script'] == 'contact'): ?> id="currentSel" <?php endif; ?>><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
contact.php">Contact</a></li>                    
    </ul>
    
    
</div>
<!--end Nav-->


</div>
<!--Top-->
<?php else: ?>
    
<div class="page-container">
  <div class="sidebar-menu">
            <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> 
      <header class="logo"> 
      <div id="userPic"><img src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/images/SAM_0476.JPG" align="center"></div>
      <p><i class="glyphicon glyphicon-star"></i><?php echo $this->_tpl_vars['uloggedUser']; ?>
</p>
      <p><a href="mailto:<?php echo $this->_tpl_vars['uloggedUserEmail']; ?>
"><i class="glyphicon glyphicon-envelope"></i><?php echo $this->_tpl_vars['uloggedUserEmail']; ?>
</a></p>

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
        <li><a href="<?php echo $this->_tpl_vars['SITE_URL']; ?>
account.php"><i class="glyphicon  glyphicon-user icon"></i><span>Profile</span></a></li>  
        <li><a href="sendmessage.php"><i class="glyphicon glyphicon-comment"></i><span>Contact Us</span></a></li>
        <li><a href="messages.php"><i class="glyphicon glyphicon-comment"></i><span>Messages</span></a></li>
      </ul>
    </div>
  </div>
</div>

    <?php endif; ?>
<?php if ($this->_tpl_vars['script'] != 'index'): ?> </div> <?php endif; ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_URL']; ?>
templates/js/main.js"></script> 