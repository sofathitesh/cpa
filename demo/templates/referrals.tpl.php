{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Affiliate Program
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


<h4>{$SITE_NAME} Affiliate Program</h4>

<p>Refer new publishers to {$SITE_NAME} and earn {$REFERRAL_RATE}% of their earnings. We utilize cookie tracking so users do not need to directly signup after visiting the referral link. This allows potential publishers to browse our site/features and sign up at a later time, while still giving your account credit.</p>


<p>Total Referral Earnings (This Month): <b>${$month_referrals_earnings}</b></p>



<form action="#" class="form form-inline">
<div class="ref_link">Your Referral Link: <input type="text" class="form-control" style="width:450px; padding:4px; height:20px" value="{$SITE_URL|urldecode}?ref={$uloggedId}" /></div>
</form>

<div class="gap20px">&nbsp;</div>

<!--Listing Container-->



<div class="clear">
<h4>Current Referrals</h4>
<form action="referrals.php" method="get">
<table cellspacing="0"  class="table">

  <tr>
      <th>&nbsp;Date</th><th>Affiliate</th><th>Today</th><th>Month</th><th>Total</th>
  </tr>

  

	  
  {if $referrals ne ""}
	  {foreach item=referral from=$referrals}
	  
	  <tr class="listing_row"><td>&nbsp;{$referral.date}</td><td>{$referral.username}</td><td>${if $referral.today_ref_income gt 0}{$referral.today_ref_income}{else}0.00{/if}</td><td>${if $referral.month_ref_income gt 0}{$referral.month_ref_income}{else}0.00{/if}</td><td>${if $referral.income gt 0}{$referral.income}{else}0.00{/if}</td></tr>
	  
	  <tr><td colspan="5"><div class="line_separator1">&nbsp;</div></td></tr>
      
	  {/foreach}
      
      
      
  {/if}
 </table>
 
 </form>
 




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
