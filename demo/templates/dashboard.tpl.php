{include file="header.tpl.php"}

<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
    Dashboard
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->



<!--Page Contents Wrapper-->
<div id="content">



<!--Left Panel-->
<div id="dashboard_leftPanel">
<div class="clear">

Welcome <b>{$uloggedUser}</b> | Today Earnings: <b>${$today_earnings}</b> | Last Payment: <b>${$last_payment}</b>
<hr />

<!--Stats + Feed-->
<div class="clear">

<!--Stats-->
<div class="">

<h4>Performance Stats</h4>

<table class="table table-hover table-condensed" style="font-size:13px; color:#666666">
<tr>
    <td>&nbsp;</td><td>Clicks</td><td>Leads</td><td>Earnings</td><td>EPC</td><td>CR</td>
</tr>


<tr>
    <td>Today</td><td>{$today_clicks}</td><td>{$today_downloads}</td><td>${$today_earnings}</td><td>${$today_epc}</td><td>{$today_cr}%</td>
</tr>
<tr>
    <td>Yesterday</td><td>{$yesterday_clicks}</td><td>{$yesterday_downloads}</td><td>${$yesterday_earnings}</td><td>${$yesterday_epc}</td><td>{$yesterday_cr}%</td>
</tr>

<tr>
    <td>This Month</td><td>{$month_clicks}</td><td>{$month_downloads}</td><td>${$month_earnings}</td><td>${$month_epc}</td><td>{$month_cr}%</td>
</tr>

<tr>
    <td>Last Month</td><td>{$last_month_clicks}</td><td>{$last_month_downloads}</td><td>${$last_month_earnings}</td><td>${$last_month_epc}</td><td>{$last_month_cr}%</td>
</tr>






</table>




</div>
<!--End Stats-->

<!--News Feed-->

<!--End News Feed-->



</div>
<!--End Stats+Feed-->




<!--Earnings Summmary -->
<div class="clear">
<div class="gap10px">&nbsp;</div>
<h4>Monthly Snapshot</h4>

<div class="clear">
    <iframe src="overview_graph.php" scrolling="no" style="width:700px; height:300px; border:0"></iframe>
</div>


</div>
<!--End Earnings Summary -->







<!--Offers Latest-->
<div class="clear">

<h4>Latest Campaigns</h4>
<div class="contents">



<table class="table table-hover table-condensed table-bordered" style="border-bottom:0 !important; margin-bottom:0; font-size:13px">
<tr>
    <th style="width:50%">Offer Name</th>
    <th>Payout</th>
    <th>EPC</th>     
    <th>Date Added</th>       
    
</tr>
{if $latestOffers ne ""}

{foreach item=offer from=$latestOffers name=lf}


    <tr>
    <td><img src="{$offer.flag}" alt=""  />&nbsp; {$offer.name}</td>
    <td>${$offer.payout}</td>
    <td >{$offer.epc}</td>
    <td>{$offer.date}</td>
    </tr>           




{/foreach}

{else}

<tr><td><center>No offer added recently</center></td></tr>

{/if}


</table>

</div>



</div>
</div>
<!--End Latest Offers-->





</div>
<!--End Left Panel-->


<!--End Right Panel-->
{include file="right_panel.tpl.php"}
<!--End Right Panel-->


<div class="gap20px">&nbsp;</div>




</div>
<!--end Page content wrapper-->


