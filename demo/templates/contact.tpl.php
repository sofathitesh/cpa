{include file="header.tpl.php"}



<!--Contents-->
<div style="width:1000px; margin:0 auto; display:table; clear:both">
<div id="contents">

<h3>Contact Us</h3>




<div class="widget-body">
<form action="contact.php" method="post">
<input type="hidden" name="register" value="register" />
<table cellspacing="10" class="table table-noborder" style="width:450px;">

{if $error_msg ne ""}
<tr>
    <td colspan="2"><div class="alert alert-danger"><img src="{$SITE_URL}templates/images/cross.gif" /> {$error_msg}</div></td>
</tr>
{/if}




<tr><td><h6>Your Name</h6></td></tr>
<tr><td><input type="text" name="name" class="form-control"  value="{$name}" /></td></tr>
<tr><td><h6>Your Email </h6></td></tr>
<tr><td><input type="text" name="email"  class="form-control" value="{$email}" /></td></tr>
<tr><td><h6>Subject </h6></td></tr>
<tr><td><input type="text" name="subject"  class="form-control" value="{$subject}" /></td></tr>
<tr><td><h6>Message </h6></td></tr>
<tr><td><textarea name="message" class="form-control" style=" height:150px;">{$msg}</textarea></td></tr>

<tr><td><img  src="includes/captcha.php" alt="" style="vertical-align:middle" /></td></tr>                      
<tr><td><h6>Security Code: </h6></td></tr>
<tr><td><input type="text"  maxlength="6" style="vertical-align:middle" name="code" class="form-control" id="code" /></td></tr>                    
<input type="hidden" name="contactSend" value="1" />
<tr><td style="text-align:left"><input type="submit" name="contactSend_btn" class="btn btn-primary" value="Send Message"  /></td></tr>





</table>
</form>

</div>

<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>

</div>

</div>
<!--End Contents-->


{include file="footer.tpl.php"}
