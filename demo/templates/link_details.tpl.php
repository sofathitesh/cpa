{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Link Details
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >
<br />

<!--Right Panel-->
{include file="sidebar.tpl.php"}
<!--End Right Panel-->

<!--Left Contents-->
<div id="memberRightPanel">


<br />


<form action="links.php?link={$fid}" method="post">
<table cellspacing="10" class="table table-noborder" style="width:50%">


{if $error_msg ne ""}
<tr><td colspan="2"><div class="alert alert-danger"><img src="templates/images/cross.gif" alt="" /> {$error_msg}</div></td></tr>
{elseif $success_msg ne ""}
<tr><td colspan="2"><div class="alert alert-success"><img src="templates/images/tick.gif" alt="" /> {$success_msg}</div></td></tr>
{/if}


<tr><td>Link URL:</td><td><input type="text" name="url" value="{$link_url}" class="form-control" /></td></tr>
<tr><td>Link Description:</td><td><input type="text" name="description" value="{$link_desc}" class="form-control" /></td></tr>
<tr><td>Leads</td><td>{$downloads}</td></tr>
<tr><td>Last Downloaded Date</td><td>{if $last_download_date eq ""}Not downloaded yet.{else}{$last_download_date}{/if}</td></tr>
<tr><td>Date Added</td><td>{$date}</td></tr>
<tr><td>Download Link</td><td><b>{$SITE_URL|@urldecode}lnk/{$fcode}</b></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="update" class="btn btn-primary" value="Update Link" /> &nbsp; <b><a href="links.php" class="btn btn-default">Back to Links</a></b></td></tr>
</table>
</form>


<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>


</div>
<!--End Right Contents-->




</div>
<!--End Contents-->


{include file="footer.tpl.php"}