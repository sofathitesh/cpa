{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Message
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >

<br />
{if $error_msg ne ''}

    
      <div class="error">
        $error_msg}
        </div>
     

{else}
<div class="sub_heading">{$subject}</div>
<div><b>From: {$sender}</b></div>

<br />
                
{if $message ne ""}


   <table cellpadding="10" cellspacing="0" style="width:95%">
    <tr><td colspan="2">
    


      {$message}
      
 
    
    </td></tr>
    <tr><td colspan="2"> <br /></td></tr>
     <tr><td colspan="2" style="text-align:left"><a href="sendmessage.php?receiver={$sender}&subj={$subject}">Reply</a> | <a href="messages.php">Back to Messages</a></td></tr>
    </table>                      

{/if}
                      
{/if}                      
                
                




<br />







</div>
<!--End Contents-->


{include file="footer.tpl.php"}