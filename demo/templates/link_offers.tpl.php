<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="{$SITE_URL}templates/css/default.css" rel="stylesheet" type="text/css" />
<link href="{$SITE_URL}templates/css/bootstrap_v3.css" rel="stylesheet" type="text/css" />
<link href="{$SITE_URL}templates/css/fonts.css" rel="stylesheet" type="text/css" />
<script src="{$SITE_URL}templates/js/jquery.js" type="text/javascript"></script>
<script src="{$SITE_URL}templates/js/json2.js" type="text/javascript"></script>





<script type="text/javascript">

var SITE_URL = "{$SITE_URL}";

</script>

<script src="{$SITE_URL}templates/js/ajax.js" type="text/javascript"></script>

<script src="{$SITE_URL}templates/js/common.js" type="text/javascript"></script>


<script type="text/javascript" src="{$SITE_URL}templates/js/jquery.tipsy.js"></script>
<link href="{$SITE_URL}templates/css/tipsy.css" rel="stylesheet" type="text/css" />

</head>

<body style="background:none">



<br />

<div class="offerp_box3" >

<div class="mid" style="height:220px">



{if $surveys ne ""}

<div id="_offers">
<table class="table table-hover table-bordered table-condensed" style="width:530px; background:#ffffff; border:1px solid #cccccc;">
{foreach item=survey from=$surveys name=s}

<tr >
<td class="offerDiv" title="{$survey.desc}" style="height:30px; vertical-align:middle">
<div><img src="{$SITE_URL}templates/images/chk.png" alt="" />&nbsp;&nbsp;<a href="{$SITE_URL}click.php?camp={$survey.id}&lnkid={$fileCode}&h={$randomHash}&pubid={$aff_id}" onclick="window.parent.initCheck('{$survey.id}', '{$fileCode}', '{$randomHash}')" target="_blank">{$survey.offer_name}</a></div>

</td>
</tr>

{/foreach}
</table>

</div>

<div style="text-align:right; width:530px;">{if $noSn ne "1"}<a href="{$SITE_URL}offers.php?f={$fileCode}&r={$randomHash}&sn={$nextSN}" style="color:#252525; font-size:12px">More Offers</a>{/if}</div>

{else}
<p style="width:400px; text-align:center; padding:20px auto; margin:0 auto;  color:#252525; font-size:14px; font-weight:bold; font-family:MyriadPro">No offer available in your country. </p>
{/if}


</div>


</div>
<script type="text/javascript">
{literal}

$(document).ready(function(){
	
	
	//tooltips

	$('.offerDiv').tipsy({gravity: 'n'});	
	

	
});

{/literal}
</script>
</body>
</html>


