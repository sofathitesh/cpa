<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="{$SITE_URL}templates/css/bootstrap_v3.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/ajax.js"></script>

{literal}


<style type="text/css">
<!--
  #divGW {
    width:630px;
    height:420px;
    background:url('gateway_templates/black.gif') no-repeat;
    overflow:hidden;
    color:#000000;
    padding-bottom:0px;
    padding-top:70px;
    padding-left:0px;
    padding-right:0px;
  }
  #divGW a, #offer_container a {
    text-decoration:none;
    color:#1E7111;
  }
  #gw_header {
    padding-bottom:22px;
    padding-top:22px;
    color:#000000;
    font-size:18px;
    font-family:Verdana;
    font-weight:bold;
  }
  .instructions {
    padding-top:20px;
    padding-top:7px;
    margin-left:30px;
    margin-right:30px;
    font-family:Tahoma;
    font-size:14px;
    text-align:left;
  }
  #gw_content {
    padding:15px;
    padding-bottom:20px;
  }
  #offer_container, #divCell, #divPayPal, #divTry {
    padding-top:10px;
  }
  .gw_offer {
    font-family:Verdana;
    font-size:16px;
    margin-bottom:16px;
  }
  .offerlink {
    font-family:Verdana;
    font-size:16px;
    font-weight:normal;
  }
-->
</style>


<script language="javascript">

  var currentID = 1;

  var gwstyles = new Array();
  gwstyles[0] = { 'bg_image':'gateway_templates/black.gif', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'FFFFFF', 'link_color':'B5E7FF', 'text_color':'FFFFFF',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'4' }
                  
  gwstyles[1] = { 'bg_image':'gateway_templates/blackfilm.gif', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'ffffff', 'link_color':'ffffff', 'text_color':'ffffff',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }
				  
  gwstyles[2] = { 'bg_image':'gateway_templates/black_pat.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'ffffff', 'link_color':'ffffff', 'text_color':'ffffff',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }	
				  
  gwstyles[3] = { 'bg_image':'gateway_templates/tiles1.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'ffffff', 'link_color':'ffffff', 'text_color':'ffffff',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }		
				  
  gwstyles[4] = { 'bg_image':'gateway_templates/gal1.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'ffffff', 'link_color':'ffffff', 'text_color':'ffffff',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }		
				  
  gwstyles[5] = { 'bg_image':'gateway_templates/gal2.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'ffffff', 'link_color':'FFFFFF', 'text_color':'ffffff',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }	
  gwstyles[6] = { 'bg_image':'gateway_templates/blue1.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'ffffff', 'link_color':'FFFFFF', 'text_color':'ffffff',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }					  					  				  			  			  
  gwstyles[7] = { 'bg_image':'gateway_templates/green_pat_dark.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'ffffff', 'link_color':'FFFFFF', 'text_color':'ffffff',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }		
  gwstyles[8] = { 'bg_image':'gateway_templates/green_pat.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'ffffff', 'link_color':'FFFFFF', 'text_color':'ffffff',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }						  			  					  				  			  			  
  gwstyles[9] = { 'bg_image':'gateway_templates/red1.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'ffffff', 'link_color':'FFFFFF', 'text_color':'ffffff',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }			
  gwstyles[10] = { 'bg_image':'gateway_templates/yellow1.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'252525', 'link_color':'252525', 'text_color':'252525',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }			
  gwstyles[11] = { 'bg_image':'gateway_templates/yellow_pat.png', 'bg_color':'',
                  'width':'650', 'height':'420',
                  'header_color':'000000', 'link_color':'000000', 'text_color':'000000',
                  'margin_top':'10', 'margin_left':'0', 'margin_right':'0',
                  'offer_left_pad':'', 'offer_bold':'0', 'overlay_color':'F4F4F4',
                  'header_vis':'1', 'bgprev':'2' }							  				  			  			  					  				  			  			  
    
  
		  				  				  				  				  				  				  				  				  				  				  				  					  
																																																			  
																																																			  
																																																			  
   
  
  function changePreview(f){
    currentID = f;

    document.getElementById('divGW').style.backgroundImage = "url('"+gwstyles[f]['bg_image']+"')";
    document.getElementById('divGW').style.width = gwstyles[f]['width'];
    document.getElementById('divGW').style.height = gwstyles[f]['height'];
  //  document.getElementById('gw_header').style.color = "'#"+gwstyles[f]['header_color']+"'";
    for (i = 1; i <= 4; i++){
      document.getElementById('gwlink'+i).style.color = "#"+gwstyles[f]['link_color'];
      if (gwstyles[f]['offer_bold']=='1'){ document.getElementById('gwlink'+i).style.fontWeight = 'bold';} else{document.getElementById('gwlink'+i).style.fontWeight = 'normal';}
    }
    document.getElementById('divGW').style.color = gwstyles[f]['text_color'];
    document.getElementById('divGW').style.paddingTop = gwstyles[f]['margin_top'];
    document.getElementById('divGW').style.paddingLeft = gwstyles[f]['margin_left'];
    document.getElementById('divGW').style.paddingRight = gwstyles[f]['margin_right'];
    document.getElementById('gw_instructions').style.color = '#'+gwstyles[f]['text_color'];
   {/literal}	

	{literal}

    //ChangeBG(gwstyles[f]['bgprev']);
  }
  
  
  function selectStyle(){
	var f = currentID;
	{/literal}
	var tUrl = "{$SITE_URL|@urldecode}"+gwstyles[f]['bg_image'];
	{literal}
	parent.document.getElementById('bg_img').value = tUrl;

   //set other values.
   parent.document.getElementById('title_color').value = '#'+gwstyles[f]['header_color'];
   parent.document.getElementById('offer_color').value = '#'+gwstyles[f]['link_color'];
   parent.document.getElementById('instructions_color').value = '#'+gwstyles[f]['text_color'];      
   parent.document.getElementById('overlay_color').value = '#'+gwstyles[f]['overlay_color'];         
   
   
   
   parent.document.getElementById('wid').value = f;            
   
   
   
   
   parent.setColors('title_color', '#'+gwstyles[f]['header_color']);
   parent.setColors('offer_color', '#'+gwstyles[f]['link_color']);
   parent.setColors('instructions_color', '#'+gwstyles[f]['text_color']);
   parent.setColors('overlay_color', '#'+gwstyles[f]['overlay_color']);    
        

	//setTemplateDimension(gwstyles[f]['bg_image']);	  
    parent.jQuery.colorbox.close();
  }
  
  
  function changePreview2(f){
    currentID = f;

    document.getElementById('divGW').style.backgroundImage = "url('"+gwstyles[f]['bg_image']+"')";
    document.getElementById('divGW').style.width = gwstyles[f]['width'];
    document.getElementById('divGW').style.height = gwstyles[f]['height'];
   // if (gwstyles[f]['header_vis']=='0'){ document.getElementById('gw_header').style.display = 'none'; }else{ document.getElementById('gw_header').style.display = ''; }
 //   document.getElementById('gw_header').style.color = "'#"+gwstyles[f]['header_color']+"'";
    for (i = 1; i <= 4; i++){
      document.getElementById('gwlink'+i).style.color = "#"+gwstyles[f]['link_color'];
      if (gwstyles[f]['offer_bold']=='1'){ document.getElementById('gwlink'+i).style.fontWeight = 'bold';} else{document.getElementById('gwlink'+i).style.fontWeight = 'normal';}
    }
    document.getElementById('divGW').style.color = gwstyles[f]['text_color'];
    document.getElementById('divGW').style.paddingTop = gwstyles[f]['margin_top'];
    document.getElementById('divGW').style.paddingLeft = gwstyles[f]['margin_left'];
    document.getElementById('divGW').style.paddingRight = gwstyles[f]['margin_right'];
    document.getElementById('gw_instructions').style.color = '#'+gwstyles[f]['text_color'];
   {/literal}	

	{literal}

    //ChangeBG(gwstyles[f]['bgprev']);
  }  
  
</script>


{/literal}

</head>

<body>

<div style="clear:both; width:900px; margin:10px auto;">

<!--Left-->
<div style="float:left; width:200px; height:600px; overflow-y:scroll">


<img src="gateway_templates/thumbs/black.gif" onclick="changePreview(0);" class="gw_tname" id="black" />
<br />
<img src="gateway_templates/thumbs/blackfilm.gif" onclick="changePreview(1);" class="gw_tname" id="blackfilm" />
<br />
<img src="gateway_templates/thumbs/black_pat.png" onclick="changePreview(2);" class="gw_tname" id="blackpat" />
<br />
<img src="gateway_templates/thumbs/tiles1.png" onclick="changePreview(3);" class="gw_tname" id="tiles1" />
<br />
<img src="gateway_templates/thumbs/gal1.png" onclick="changePreview(4);" class="gw_tname" id="gal1" />
<br />
<img src="gateway_templates/thumbs/gal2.png" onclick="changePreview(5);" class="gw_tname" id="gal2" />
<br />
<img src="gateway_templates/thumbs/blue1.png" onclick="changePreview(6);" class="gw_tname" id="blue1" />
<br />
<img src="gateway_templates/thumbs/green_pat_dark.png" onclick="changePreview(7);" class="gw_tname" id="green_dark_pat" />
<br />
<img src="gateway_templates/thumbs/green_pat.png" onclick="changePreview(8);" class="gw_tname" id="green_pat" />
<br />
<img src="gateway_templates/thumbs/red1.png" onclick="changePreview(9);" class="gw_tname" id="red1">
<br />
<img src="gateway_templates/thumbs/yellow1.png" onclick="changePreview(10);" class="gw_tname" id="red1">
<br />
<img src="gateway_templates/thumbs/yellow_pat.png" onclick="changePreview(11);" class="gw_tname" id="yellow_pat">




</div>
<!--End Left-->


<!--Right-->
<div style="float:right; margin-right:25px;">


<!--Widget-->
<div id="divGW" align="center" style="margin-top:60px; width:650px">
<!--      <div id="gw_header">Example Header Text</div>-->
      <div id="gw_instructions" class="instructions" style="margin-left:45px; color:#ffffff; margin-right:45px;">
        To access this area of our website, please complete the easy requirements below. It will only take a minute and our site will automatically unlock when you're finished.<br /><br />
      </div>
    	<div id="gw_content">
    		<div id="gw_offers">
    		  <div id="offer_container">

                          <div class="gw_offer"><a href="#" class="offerlink" id="gwlink1">Example offer text will be here</a></div>
                          <div class="gw_offer"><a href="#" class="offerlink" id="gwlink2">Example offer text will be here</a></div>
                          <div class="gw_offer"><a href="#" class="offerlink" id="gwlink3">Example offer text will be here</a></div>
                          <div class="gw_offer"><a href="#" class="offerlink" id="gwlink4">Example offer text will be here</a></div>
                      </div>
        </div>
      </div>

    </div><!--End Widget-->


</div>
<!--End Right-->



</div>
</div>

<div style="margin:5px auto; text-align:center">
<a href="#" onclick="selectStyle()" class="btn btn-default btn-lg">Choose This Style</a>
</div>
{if $wid ne ''}
<script type="text/javascript">
 changePreview2({$wid});
</script>
{/if}


</body>
</html>
