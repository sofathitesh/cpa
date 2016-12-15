{include file="header.tpl.php"}




<!--Page Contents Wrapper-->
<div class="page_contents_wrapper">



<div class="form_layout" style="width:740px; padding-top:75px;">

    <div class="reg_success">
    <br />
    
    <p>
    {if $success_msg ne ""}


     <div class="alert alert-success" ><img src="templates/images/tick.gif" alt="" /> &nbsp;{$success_msg}</div>

    
    {elseif $error_msg}
    
    <div class="alert alert-danger" ><img src="templates/images/cross.gif" alt="" /> &nbsp;{$error_msg}</div>    
    
    {/if}    
    <br />
   </p>

     </div>
     
     
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
     




</div>





</div>
<!--End Contents-->



{include file="footer.tpl.php"}