{include file="header.tpl.php"}





<!--Page Contents Wrapper-->
<div class="clear" style="width:450px; margin:75px auto">

      <div class="login_box" style="width:100%;">
      <div class="login_title">
        <h4 class="modal-title" id="mt">Member Login</h4>
      </div>
<div id="loginForm">      
<form role="form" method="post"  action="login.php" >
<input type="hidden" name="login" value="1" />
      
      
      <div class="login_fields">
      {if $login_error_msg ne ""}
      <div class="alert alert-danger" style="padding:4px;"><img src="templates/images/cross.gif" alt="" /> &nbsp;{$login_error_msg}</div>
      {/if}
      
      
      <div class="input-group">
        <span class="input-group-addon"><img src="templates/images/mail.png" alt="" /></span>
        <input type="text" name="email" class="form-control"  value="" autocomplete="off" placeholder="Enter Email Address" >
      </div>
      <br />
      
      <div class="input-group">
       <span class="input-group-addon"><img src="templates/images/key.png" alt="" /></span>
        <input type="password" name="password" class="form-control"    value="" autocomplete="off" placeholder="Password" >
      </div>
      <br />
      
      </div>
      
       <div class="clear">
       <div class="left">
       
       Are you new visitor ? <a href="register.php">Create Account</a>
       
       </div>      
       <div class="right">
       <input type="submit" name="forgot" value="Login" class="btn btn-primary">
       <input type="button" class="btn btn-default" data-dismiss="modal" id="forgotBtn" value="Forgot Password">
       </div>
       </div>      

</form>
</div>

<div id="forgotForm" style="display:none">
<form role="form" method="post" action="forgot.php" >
<input type="hidden" name="forgot" value="1" />    



      <div class="login_fields">
      
      {if $ferror ne ""}
      <div class="alert alert-danger" style="padding:4px;"><img src="templates/images/cross.gif" alt="" /> &nbsp;{$ferror}</div>
      
      {elseif $fsuccess ne ""}
      
      <div class="alert alert-success" style="padding:4px"><img src="templates/images/tick.gif" alt="" /> &nbsp;{$fsuccess}</div>
      
      {/if}
      
      
      
      <div class="input-group">
       <span class="input-group-addon"><img src="templates/images/mail.png" alt="" /></span>
        <input type="text" name="email" class="form-control" value="" autocomplete="off" placeholder="Enter email">
      </div>
      <br />
      
      
      </div>


      
       <div class="clear">
       <div class="left">
       
       Are you new visitor ? <a href="register.php">Create Account</a>
       
       </div>
       <div class="right">
       <input type="submit" name="forgot" value="Send Password" class="btn btn-primary">
       <input type="button" class="btn btn-default" data-dismiss="modal" id="bckBtn" value="Back">
       </div>
       </div>
        


</form>
</div>


</div>


</div>




{literal}
<script type="text/javascript">

$(document).ready(function(){

$('#forgotBtn').click(function(e){


   $('#loginForm').slideUp();
   $('#forgotForm').slideDown();
   $('#mt').text("Reset Password");
	
});

$('#bckBtn').click(function(e){

    e.preventDefault();
   $('#forgotForm').slideUp();	
   $('#loginForm').slideDown();
   $('#mt').text("Member Login");   

	
	
});

{/literal}


{if $ferror ne "" || $fsuccess ne ""}
$('#forgotBtn').click();
{/if}


{literal}

	
});

</script>
{/literal}


