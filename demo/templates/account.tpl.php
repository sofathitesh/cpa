{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Account Information
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
{if $error ne ""}
<div class="alert alert-danger"> <img src="templates/images/cross.gif" alt="" />  {$error}</div>
{elseif $success ne ""}
<div class="alert alert-success"> <img src="templates/images/tick.gif"  alt="" />  {$success}</div>
{/if}

<style type="text/css">
{literal}
.labelField{width:200px;}
{/literal}
</style>

<form action="account.php" method="post">
<input type="hidden" name="update" value="1" />
<h4>Account Information</h4>

<div class="clear">
<table class="table">

<tr>
    <td class="labelField">First Name</td> <td>{$firstname}</td>

    <td class="labelField">Last Name</td> <td>{$lastname}</td>
</tr>


<tr>
    <td class="labelField">Email Address</td> <td colspan="3">{$email_address}</td>
</tr>

<tr>
    <td class="labelField">Home Address</td> <td>{$address}</td>
    <td class="labelField">City/Town</td> <td>{$city}</td>
</tr>

<tr>
    <td class="labelField">State/Province</td> <td>{$state}</td>
    <td class="labelField">Zip/Postal Code</td> <td>{$zip}</td>
</tr>

<tr>
    <td class="labelField">Country</td> <td colspan="3">{$country}</td>
</tr>


<tr>
    <td class="labelField">Website</td> <td colspan="3">{$websites}</td>

</tr>


</table>
</div>

<div class="gap20px">&nbsp;</div>

<h4>Payment Information</h4>

<div class="clear">
<table class="table">

<tr>
    <td class="labelField">Payment Method</td> <td>{$payment_method}</td>

    <td class="labelField">Payment Cycle</td> <td>{$pay_cycle}</td>
</tr>

<tr>
    <td class="labelField">Payment Method Details</td> <td colspan="3">{$payment_method_details}</td>


</tr>


</table>
</div>


<div class="gap20px">&nbsp;</div>

<h4>Password Change</h4>

<div class="clear">
<table class="table">

<tr>
    <td class="labelField">Old Password </td> <td colspan="3"><input type="password" name="oldpassword" autocomplete="off"  class="form-control" style="width:200px; height:20px;" /></td>
</tr>

<tr>
    <td class="labelField">New Password </td> <td><input type="password" name="newpassword"  class="form-control" style="width:200px; height:20px;" /></td>
    <td class="labelField">Confirm Password</td> <td><input type="password" name="confirm_password"  class="form-control" style="width:200px; height:20px;"  /></td>
</tr>

</tr>


</table>
</div>

<div class="right" style="margin-right:150px">
<input type="submit" class="btn btn-default" name="update_btn" onclick="if(!confirm('Are you sure you want to update account?')) return false;" value="Update Account" />
</div>


</form>


    
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>



</div>









</div>
<!--End Contents-->


{include file="footer.tpl.php"}