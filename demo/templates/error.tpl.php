{include file="header.tpl.php"}



<!--Contents-->
<div class="content">
<div class="widget widget-4">
<div class="gap20px">&nbsp;</div>
<h4 class="heading">Alert!!!</h4>

{if $error_msg ne ""}
<div class="alert alert-danger">{$error_msg}</div>

{elseif $msg ne ""}

<div class="alert alert-success"></div>


{/if}



<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>

</div>

</div>
<!--End Contents-->


{include file="footer.tpl.php"}
