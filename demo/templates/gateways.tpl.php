{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Content Lockers
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >
<br />



<div class="widget-body">

{if $error_msg ne ""}
     
      <div class="alert alert-danger">
        <img src="templates/images/cross.gif" style="vertical-align:top" alt="" /> {$error_msg}
        </div>
        <br />
     
{/if}



<form action="gateways.php" method="post" id="gw_settings">
<input type="hidden" name="action" id="action" value="" />
<div style=" margin:5px 0; clear:both; background:#ffffff; border:1px solid #cccccc; height:40px; padding:5px;">

<div class="create_new" style="float:left; width:150px; text-align:left; padding-top:12px;">
&nbsp;&nbsp;<a href="create.php">Create New Gateway</a>
</div>

<div style="float:right; margin-top:8px;">

<button id="getcode" class="btn btn-default actionBtn" >Get Code</button>
<button id="preview" class="btn btn-default actionBtn" >Preview</button>
<button id="edit" class="btn btn-default actionBtn" >Edit</button>
<button id="clone" class="btn btn-default actionBtn" >Clone</button>
<button id="delete" class="btn btn-default actionBtn" >Delete</button>



<!--<input type="image" id="getCode" class="actionBtn" value="getcode" src="templates/images/getcode.jpg"  /> 
<input type="image" id="previewGW" class="actionBtn" value="preview" src="templates/images/preview.jpg"  /> 
<input type="image" id="editGW" class="actionBtn" value="edit" src="templates/images/edit.jpg"  />
<input type="image" id="cloneGW"  class="actionBtn" value="clone" src="templates/images/clone.jpg" />
<input type="image" id="delGW" class="actionBtn"  value="delete" src="templates/images/delete.jpg"  />-->
</div>

</div>


{if $success_msg ne ""}

      
      <div  class="alert alert-success"  >
        <img src="templates/images/tick.gif" style="vertical-align:top" alt="" /> {$success_msg}
      </div>
    
{/if}






<!--Listing-->
<div class="clear" id="listing" style="background:#ffffff; border:1px solid #cccccc;">


<!--Gateway Table-->
<div class="gw_table">
<div class="top"><div class="caption"></div></div>
<div class="mid">
<div class="data">
{foreach item=gw from=$gateways name=g}

<div class="gw_row" {if $smarty.foreach.g.index  ==  ($gateways|@count)-1}  style="border-bottom:0;" {/if} id="gw_{$gw.id}">
<p style="float:left; width:500px;">&nbsp;&nbsp;&nbsp; <input type="radio" name="gateway" value="{$gw.id}" />&nbsp;&nbsp;{$gw.name} <span style="font-size:10px; color:#c95d5d;">(Created on {$gw.date})</span></p>
<p style="float:right; width:200px; font-size:12px;">Earned ${if $gw.earnings eq ""}0{else}{$gw.earnings}{/if}</p>
</div>
{/foreach}




</div>
</div>
<div class="bottom">&nbsp;</div>
</div>
<!--End GW Table-->

{if $next ne "" || $previous ne ""}
<div class="clear">

<table style="width:700px;">
<tr>
    <td class="paging" style="text-align:left; width:33.33%">{if $previous ne ""}<a href="gateways.php?page={$previous}">Previous Page</a>{else}&nbsp;{/if}</td>
    <td class="paging" style="text-align:center; width:33.33%">Page {$pageNum} of {$pages}</td>
    <td class="paging" style="text-align:right; width:33.33%">{if $next ne ""}<a href="gateways.php?page={$next}">Next Page</a>{else}&nbsp;{/if}</td>        
</tr>
</table>

</div>
{/if}



</div>
<!--end Listing-->

</form>









</div>

<!--End Box Area-->

<br />




<br /><br />


</div>
<br /><br /><br /><br /><br /><br />
<!--End Right Panel-->
{include file="footer.tpl.php"}