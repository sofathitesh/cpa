{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Payments History
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >


<!--Left-->
<div id="dashboard_leftPanel">


<div class="gap20px">&nbsp;</div>



<!--Listing Container-->

<div class="clear">


<table cellspacing="0"  class="table table-bordered table-hover table-condensed">

  <tr>
      <th>&nbsp;Date</th><th>Amount</th><th>Method</th><th>Status</th><th>Payment Cycle</th>
  </tr>

  

	  
  {if $payments ne ""}
	  {foreach item=payment from=$payments}
	  
	  <tr><td>&nbsp;{$payment.date}</td><td>${$payment.amount}</td><td>{$payment.method}</td><td>{$payment.status}</td><td>{$payment.cycle}</td></tr>
	  {/foreach}
      
      
      
  {/if}
 </table>
 

 




<br />
  

</div>
  {if $pages gt 1}
 <div style="width:660px; margin:0px; clear:both; " >
 <div style="float:left" class="listing_paging">Page {$page} of {$pages}</div> <div style="float:right" class="listing_paging"> {$previous} {$next}</div>
 </div>
{/if}
  


<br  />






</div>
<!-- End Left Panel-->


<!--Right Panel-->
{include file="right_panel.tpl.php"}
<!--Right Panel-->



</div>



{include file="footer.tpl.php"}
