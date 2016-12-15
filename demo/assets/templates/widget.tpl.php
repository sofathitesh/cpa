<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">

*{padding: 0; margin: 0;}
.heading{clear:both; margin:10px auto; color:<?=$heading_color?>; font-size:<?=$heading_size?>px; font-family:<?=$heading_font?>; width:80%; text-align:center }
.instructions{clear:both; margin:10px auto; margin-bottom:0px; color:<?=$instructions_color?>; font-size:<?=$instructions_size?>px; font-family:<?=$instructions_font?>; width:70%; text-align:<?=$instruction_position?>}
.cl_offer{clear:both; margin:5px 0;}
.cl_offer_color{color:<?=$offer_color?>; font-size:<?=$offer_size?>px; <? if($offer_bold == 1){?> font-weight:bold; <? } ?> font-family:<?=$offer_font?>;}
.cl_offer a{text-decoration:none;}
.cl_offer a:hover{text-decoration:underline}
.status{clear:both; height:150px; background:#ffffff; border:1px solid #999999;  font-size:12px; color:#fff; margin:35px 0; text-align:center; display:none;  width:350px;}
.backOffers{font-weight:bold; font-size:13px; color:#333}
#status_m{clear:both; font-size:13px; color:#ff0000; margin:10px auto;}
</style>


<script type="text/javascript" src="templates/jquery-1.4.js"></script>
<script type="text/javascript" src="json2.js"></script>
<script type="text/javascript" src="ajax.js"></script>


<link href="templates/tipsy.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/tipsy.js"></script>



</head>

<body style="background:url(<?=$bg_img?>) no-repeat <?=$bg_color?>;">
<center><br /><br />
<div class="status" id="status">

<div id="status_m">&nbsp;</div>
<div style="clear:both; margin:10px auto;"><img src="templates/images/loading.gif" alt="" /></div>
<div style="color:#000; font-size:13px;">If you believe you finished the offer and this page is still not unlocking, please Return to the Offer List by clicking the link below and try a different one<br /><a href="javascript:void(0)" class="backOffers" onclick="stopChecker();">Back to Offers</a></div>


</div>

<div id="offers_layer" >
<div class="heading"><?=nl2br($title)?></div>
<div class="instructions"><?=nl2br($instructions)?></div>

<div  style="<?php if($marginTop > 0){ ?>padding-top:<?=$marginTop?>; <? } ?> clear:both; text-align:<?=$position?>; width:75%; margin:0 auto ">


<?php
if(count($offers) >= 1){
foreach($offers as $offer)
{
	?>
   
    <div class="cl_offer">
   
   <? if($demo == 1) {?>
    <a href="javascript:void(0)"   class="cl_offer_color" title="<?=$offer['desc']?>" target="_blank"><?=$offer['name']?></a>
    <? }else{ ?>
    
    <a href="click.php?id=<?=$offer['id']?>&gid=<?=$gwid?>&s=<?=$sessId?>"  title="<?=$offer['desc']?>" onclick="initCheck('<?=$gwid?>', '<?=$sessId?>')" class="cl_offer_color" target="_blank"><?=$offer['name']?></a>    
    
    <? } ?>
   
   
    </div>
   
    <?
	
}

}else
{
  ?>
      <div style="color:#FFF; margin-top:10px; width:400px"><center><b>There is no offer available for your country right now. Please come back later</b></center></div>
  <?php	
}

?>

</div>

</div>
</center>


<script type="text/javascript">

$(function() {
	
    $('.cl_offer_color').tipsy({gravity: 'sw', opacity: 1, html: true});
	
	});

</script>
<script type="text/javascript">
function Safety__PM()
{
	if(document.all){return false;}
}

function PreventRightClick(e)
{
	if(document.layers||(document.getElementById&!document.all))
		{
			if(e.which==2||e.which==3)
				{
					return false;
				}
		}
}

if(document.layers)
{
	document.captureEvents(Event.MOUSEDOWN);
	document.onmousedown=PreventRightClick;
}
else
{
	document.onmouseup=PreventRightClick;
	document.oncontextmenu=Safety__PM;
}

document.oncontextmenu=new Function("return false")
</script>

</body>
</html>


