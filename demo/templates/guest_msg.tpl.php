{include file="header.tpl.php"}



<!--Contents-->
<div id="content" >
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<h4 class="heading"></h4>

{if $error ne ""}
<div class="alert alert-danger">{$error}</div>

{elseif $success_msg ne ""}

<div class="alert alert-success">{$success_msg}</div>


{/if}



<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>

<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>


</div>
<!--End Contents-->


{include file="footer.tpl.php"}

