{include file="header.tpl.php"}



<!--Page Contents Wrapper-->
<div class="clear page_contents_wrapper">

<h3>Create Account <small>Let's get started</small></h3>


{if $error_msg ne ""}
<div class="clear">
<div class="form-group">
  <div class="alert alert-danger"><img src="templates/images/cross.gif" alt="" /> &nbsp;{$error_msg}</div>
 </div>
</div>
{/if}



<form action="register.php" method="post"  class="form-horizontal" >
<input type="hidden" name="register" value="register" />

<!--Left-->
<div class="left" style="width:650px;">

<div class="panel panel-default" style="width:650px;">
  <div class="panel-heading">
    <h3 class="panel-title">Account Details</h3>
  </div>
<div class="panel-body" style="padding:0">




<!--Group-->
<div class="fieldGroup">
<div class="left">
<div class="fieldPlace" >
<p>First Name</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
  <input type="text" name="first_name"  placeholder="John" class="form-control input" value="{$first_name}" />
</div>
</div>

</div>

<div class="right">

<div class="fieldPlace">
<p>Last Name</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
<input type="text" name="last_name"  class="form-control input" value="{$last_name}"  placeholder="Smith"  />
</div>
</div>

</div>


</div>
<!--End Group-->

<div class="gap10px">&nbsp;</div>
<div class="wideBreak">&nbsp;</div>

<!--Group-->
<div class="fieldGroup">
<div class="clear">
<div class="left">

<div class="fieldPlace">
<p>Home Address</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
  <input type="text" name="address"  class="form-control input" placeholder="290 st New York" value="{$address}" />
</div>
</div>

</div>

<div class="right">

<div class="fieldPlace">
<p>City</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
  <input type="text" name="city"  class="form-control input" value="{$city}" placeholder="New York" />
</div>
</div>
</div>
</div>


<div class="clear">

<div class="left">


<div class="fieldPlace">
<p>State/Province/Region</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-tower"></span></span>
  <input type="text" name="state"  class="form-control input" value="{$state}" placeholder="FL" />
</div>
</div>

</div>

<div class="right">

<div class="fieldPlace">
<p>Zip/Postal Code</p>
<div class="input-group">
<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
<input type="text" name="zip"  class="form-control input" placeholder="12345" value="{$zip}" />
</div>
</div>



</div>


</div>




<div class="clear">

<div class="left">

<div class="fieldPlace">
<p>Country</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
  <input type="text" name="country"  class="form-control input" placeholder="Country" value="{$country}" />
</div>
</div>


</div>

<div class="right">

&nbsp;


</div>

</div>

</div>
<!--End Group-->

<div class="gap10px">&nbsp;</div>
<div class="wideBreak">&nbsp;</div>


<!--Group-->
<div class="fieldGroup">
<div class="left">


<div class="fieldPlace">
<p>Email Address</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
 <input type="text" name="email_address"  class="form-control input" placeholder="john@hotmail.com" value="{$email_address}" />
</div>
</div>
<div class="clear" style="width:250px; padding-top:5px">
<div id="username_status"></div>
</div>

</div>

<div class="right">

<div class="fieldPlace">
<p>Confirm Email Address</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
 <input type="text" name="email_confirm"  class="form-control input" placeholder="john@hotmail.com" value="{$email_address}" />
</div>
</div>

</div>


</div>
<!--End Group-->



<!--Group-->
<div class="fieldGroup">
<div class="left">
<div class="fieldPlace">
<p>Password</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
  <input type="password" name="password" oncopy="return false;" placeholder="Enter Password"  class="form-control input" autocomplete="off" />
</div>
</div>


</div>

<div class="right">
<div class="fieldPlace">
<p>Contfirm Password</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
  <input type="password"  oncopy="return false;" name="password_confirm"  placeholder="Confirm Password"   class="form-control input" autocomplete="off" />
</div>
</div>

</div>


</div>
<!--End Group-->



<div class="gap20px">&nbsp;</div>

<!--Group-->
<div class="fieldGroup">
<div class="left">
<div class="fieldPlace">
<p>Payment Method</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-cog"></span></span>
  <select name="payment_method" class="form-control input">
  
   <option value="paypal" {if $payment_method eq "paypal"} selected="selected" {/if}>Paypal</option>
   <option value="check" {if $payment_method eq "check"} selected="selected" {/if}>Check</option>
   <option value="wire" {if $payment_method eq "wire"} selected="selected" {/if}>Wire</option>      
  
  </select>
</div>
</div>


</div>

<div class="right">
<div class="fieldPlace">
<p>Payment Details</p>
<div class="input">
     <textarea name="payment_details" style="height:80px" class="form-control input">{$payment_details|@trim}</textarea>
     <small style="color:#666666; font-size:11px">e.g. paypal email address / check payto name / wire details</small>

</div>
</div>

</div>


</div>
<!--End Group-->



<div class="gap20px">&nbsp;</div>




</div>

</div>

</div>
<!--End Left-->






<!--Right-->
<div class="left" style="margin-left:20px">

<div class="panel panel-default" style="width:320px;">
  <div class="panel-heading">
    <h3 class="panel-title">Website & Promotion Details</h3>
  </div>
<div class="panel-body" style="padding:0">
<div style="clear:both; width:280px; margin:0 auto">

<div class="fieldPlace">
<p>Website</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
  <input type="text" name="website"  placeholder="" class="form-control input" value="{$website}" />
</div>
</div>

<!--<div class="fieldPlace">
<p>What networks you currently work with?</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-tasks"></span></span>
  <input type="text" name="networks"  placeholder="" class="form-control input" value="{$networks}" />
</div>
</div>-->

<div class="fieldPlace">
<p>How did you hear about us?</p>
<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon-bullhorn"></span></span>
  <input type="text" name="hearBy"  placeholder="" class="form-control input" value="{$hearBy}" />
</div>
</div>


<div class="fieldPlace">
<p>What methods will you use to promote {$SITE_NAME}</p>
<div class="form-group">
    <textarea type="text" name="promotional_methods"  placeholder="" class="form-control" style="width:250px; resize:none; height:98px; margin:0 auto"  >{$promotional_methods}</textarea>
</div>
</div>


<div class="gap10px">&nbsp;</div>
<div class="wideBreak">&nbsp;</div>

<div class="fieldPlace">
<div class="left">
<p>Security Code</p>
<img src="captcha.php" alt="" />
</div>

<div class="left" style="margin-left:3px;"><p>&nbsp;</p><input type="text" name="code"  class="form-control" style="width:120px;" autocomplete="off" /></div>

</div>

<div class="gap10px">&nbsp;</div>
<div class="wideBreak">&nbsp;</div>


<input type="checkbox" name="agreed" value="1" /> I agree to <a href="{$SITE_URL}terms.php" class="agree" target="_blank">terms of service</a>


<div class="gap20px"></div>




</div>
</div>

</div>


<div style="clear:both; text-align:center">
<button class="btn btn-primary" name="create_btn" style="width:200px; font-weight:bold; height:40px" id="regbtn" value="reg" >Create Account</button>
</div>


</div>
<!--End Right-->


</form>
<div class="gap20px">&nbsp;</div>

</div>
<!--End Contents-->


{include file="footer.tpl.php"}


