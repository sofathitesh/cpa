{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Widget Preview
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >


<div class="gap20px"></div>
<div class="gap20px"></div>


<script type="text/javascript" src="{$SITE_URL|@urldecode}assets/gwui.php?gid={$gid}&aff_id={$uid}&demo=1"></script>
<noscript>
<meta http-equiv="refresh" content="0; URL={$SITE_URL|@urldecode}assets/nojs.html">
</noscript>
<script type="text/javascript">
{literal}


  function changePageBG(colorVal){
    document.body.style.backgroundColor = colorVal;
    if ((colorVal == '#000000') || (colorVal == 'rgb(0, 0, 0)')){
      document.body.style.color = '#FFFFFF';
    }else{
      document.body.style.color = '#000000';
    }
    //initGateway();
  }
{/literal}
</script>






<div style="clear:both">

  You can change the background color of this page by clicking one of the colors below.<br />
  This is useful in seeing how your gateway looks under different conditions.<br /><br />
  
  <div style="clear:both;">


    <div class="_gwcolorthumb" style="background-color:#fcfcfc;" onclick="changePageBG(this.style.backgroundColor);"></div>
    <div class="_gwcolorthumb" style="background-color:#FFFFFF;" onclick="changePageBG(this.style.backgroundColor);"></div>
    <div class="_gwcolorthumb" style="background-color:#E1E1E1;" onclick="changePageBG(this.style.backgroundColor);"></div>
    <div class="_gwcolorthumb" style="background-color:#C3C3C3;" onclick="changePageBG(this.style.backgroundColor);"></div>
    <div class="_gwcolorthumb" style="background-color:#555555;" onclick="changePageBG(this.style.backgroundColor);"></div>
    <div class="_gwcolorthumb" style="background-color:#000000;" onclick="changePageBG(this.style.backgroundColor);"></div>
    
    <div class="_gwcolorthumb" style="background-color:#DCE4E8;" onclick="changePageBG(this.style.backgroundColor);"></div>
    <div class="_gwcolorthumb" style="background-color:#7092BE;" onclick="changePageBG(this.style.backgroundColor);"></div>
    <div class="_gwcolorthumb" style="background-color:#3D5191;" onclick="changePageBG(this.style.backgroundColor);"></div>
    <div class="_gwcolorthumb" style="background-color:#00A2E8; border-right-width:1px;" onclick="changePageBG(this.style.backgroundColor);"></div>


</div>


<div style="clear:both; margin:15px 0">
<br />
<center><form action="" method=""><input type="button" onclick="initWidget();" class="btn btn-default" value="Show Widget" /></form></center>

<br />
<b>important Notes:</b>
<ul>
<li style="list-style:none">This preview is not fully functional and is only meant to be used to preview the appearance.</li>
<li style="list-style:none; margin-top:10px;">Since this is just a preview, completing a survey will not unlock the gateway.</li>
</ul>
</div>
</div>



</div>



</div></div>
<!--End Right Panel-->
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
{include file="footer.tpl.php"}
