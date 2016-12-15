{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Messages
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >

<div class="gap20px">&nbsp;</div>





<form action="messages.php"  method="post" id="form1">
<table cellspacing="0" class="table table-bordered table-hover"   style="text-align:left; width:100%;" cellpadding="0">

  <tr class="listing_th_row">
     <th>&nbsp;&nbsp;<input type="checkbox" id="checkAll" onclick="CheckAll('form1')" />&nbsp;</th><th>Sender</th> <th>Subject</th><th>Date</th>
  </tr>

	  {foreach item=message from=$messages}
	  
	  <tr class="listing_row"><td style="width:30px; text-align:center"><input type="checkbox" name="msgid[]" value="{$message.msgid}" onclick="uncheckCheckAllbox(this)" /></td><td style="width:20%">&nbsp;{$message.sender}</td><td style="width:60%">&nbsp;{if $message.read eq "0"}<b><a href="message.php?msgid={$message.msgid}">{$message.subject}</a></b>{else}<a href="message.php?msgid={$message.msgid}">&nbsp;{$message.subject}</a>{/if}</td><td>{$message.date}</td></tr>
	  
	  {/foreach}
	  
     

 </table>


 {if $messages ne ""}
<div style="clear:both; margin-left:8px; padding-top:10px; padding-bottom:10px;">
<input type="hidden" name="action" value="delete" />
<input type="submit" name="deletebtn" value="Delete" onclick="if(!confirm('Are you sure you want to delete selected messages?')) return false;" />
</div>
{/if}
 </form>


 {if $pages gt 1}
 <div class="clear" style="width:660px; margin:0px auto; " >
 <div style="float:left" class="listing_paging">Page {$page} of {$pages}</div> <div style="float:right" class="listing_paging"> {$previous} {$next}</div>
 </div>
{/if}
  


{literal}
<script type="text/javascript">
$(document).ready(function(){

$('.listing_row').hover(function(){ $(this).css('background-color', '#f6f6f6'); }, function(){ $(this).css('background-color', '#ffffff'); });


});
</script>
{/literal}



</div>




<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>



{include file="footer.tpl.php"}