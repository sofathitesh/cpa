{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Write to Admin
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >



<div class="clear">
<br />



<form action="sendmessage.php" method="post">
<table cellspacing="10" class="table table-noborder" style="width:450px">

{if $error_msg ne ""}
<tr><td ><div class="alert alert-danger">{$error_msg}</div></td></tr>
{elseif $success_msg ne ""}
<tr><td ><div class="alert alert-success">{$success_msg}</div></td></tr>
{/if}



<tr><td><h6>Subject</h6></td></tr>
<tr><td><input type="text" name="subject" maxlength="250" value="{$subject}" class="form-control"  style="width:250px;" /></td></tr>
<tr><td><h6>Message</h6></td></tr>
<tr><td><textarea name="message" class="form-control" style="width:370px; resize:none; height:180px;">{$message}</textarea></td></tr>
<tr><td><input type="button" onclick="window.location = 'messages.php'" name="cancel" class="btn btn-default" value="Cancel" /> &nbsp; <input type="submit" name="send"  class="btn btn-primary" value="Send" /></td></tr>







</table>
</form>




<br />





</div>
<!--End Contents-->

</div>
{include file="footer.tpl.php"}