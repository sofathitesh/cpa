{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Add Link
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >

<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>


<p>
 
  This is our link locker tool for users, who just want to lock any link.

</p>

<form action="upload_link.php" method="post">
<input type="hidden" name="upload_link" value="1" />
<table  class="table table-noborder" style="width:55%">


{if $error_msg ne ""}
<tr><td colspan="2"><div class="alert alert-danger"><img src="templates/images/cross.gif" alt="" /> {$error_msg}</div></td></tr>
{elseif $success_msg ne ""}
<tr><td colspan="2"><div class="alert alert-success"><img src="templates/images/tick.gif" alt="" /> {$success_msg}</div></td></tr>
{/if}



<tr>
    <td>Link URL </td> <td><input type="text" name="link_url" value="{$link_url}"  class="form-control" /></td>
</tr>

<tr>
    <td>Link Description </td> <td><input type="text" name="desc" value="{$desc}"  class="form-control" /></td>
</tr>


<tr>
    <td class="label">&nbsp;</td> <td style="text-align:right"><input type="submit" name="update_btn" class="btn btn-primary" style="margin-right:0"  value="Upload Link" /></td>
</tr>






</table>
</form>


    



</div>





<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>

{include file="footer.tpl.php"}


