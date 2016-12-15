<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$SITE_NAME}</title>
<link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
<link href="{$SITE_URL}templates/css/main.css" rel="stylesheet" type="text/css" />
<link href="{$SITE_URL}templates/css/bootstrap_v3.css" rel="stylesheet" type="text/css" />


{if $script ne "index" && $uloggedId gt "0"}
{literal}
<style type="text/css">

body{background:url({/literal}{$SITE_URL}{literal}templates/images/bg_sub.png) repeat-x;}


</style>
{/literal}
{/if}


<script type="text/javascript">
var SITE_URL = '{$SITE_URL|@urldecode}';

</script>


<script type="text/javascript" src="{$SITE_URL}templates/js/jquery.js"></script>
<script type="text/javascript" src="{$SITE_URL}templates/js/bootstrap.js"></script>
<script type="text/javascript" src="{$SITE_URL}templates/js/json2.js"></script>
<script type="text/javascript" src="{$SITE_URL}templates/js/common.js"></script>
<script type="text/javascript" src="{$SITE_URL}templates/js/ajax.js"></script>


</head>
<body style="background:#cfe4ee;">

<div style="height:100px; background:#000;">

<div style="width:971px; margin:0 auto; color:#ffffff; font-size:13px;">

<div style="text-align:center; padding-top:10px; font-size:16px; font-weight:bold; font-family:Arial"> <img src="{$SITE_URL|@urldecode}templates/images/small_lock.png" alt="" style="vertical-align:middle" />&nbsp;Unlock this page to continue! 
<br />
<p class="link_ins">You can unlock this page and access the link by completing an offer below</p>
<div id="_ostatus" style="color:#ffffff;  font-size:14px; font-weight:normal">&nbsp;</div>

</div>


</div>

</div>


<div id="linklocker_wrapper">


<div id="contents" style="margin-top:100px;">




<div class="jumbotron">

  
<div id="offersSection2" style="height:250px; width:570px; margin:25px auto" >
<iframe src="{$SITE_URL}offers.php?f={$fileCode}&r={$randomHash}" style="border:0; width:570px; height:400px;   " scrolling="no"></iframe>

<div id="dform" style="display:none; width:90%; text-align:center">
<form action="{$SITE_URL}lnk/{$fileCode}" method="post">
<input type="hidden" id="durl" name="durl" value="{$SITE_URL}lnk/{$fileCode}" />
<input type="hidden" name="token" id="tokenId" value="" />
</form>
</div>

</div>

   
    

</div>



 










</div>
<!--End Contents-->










</div>
</body>
</html>
