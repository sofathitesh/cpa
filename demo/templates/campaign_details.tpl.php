{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Campaign Details
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >
<br />




<br />


{if $error_msg ne ""}

 <div class="alert alert-danger">{$error_msg}</div>

{else}


<table class="table">

<tr>
<td>Campaign ID</td><td>{$camp_id}</td>
</tr>
<tr>
<td>Offer Name</td><td>{$offer_name}</td>
</tr>

<tr>
<td>Description</td><td>{$desc}</td>
</tr>

<tr>
<td>Payout</td><td>${$payout}</td>
</tr>

<tr>
<td>Conversions</td><td>{$conv}%</td>
</tr>

<tr>
<td>Clicks</td><td>{$clicks}</td>
</tr>

<tr>
<td>Leads</td><td>{$leads}</td>
</tr>

<tr>
<td>Status</td><td>{$status}</td>
</tr>

<tr>
<td>Leads Remaining</td><td>{$limit-$leads}</td>
</tr>

<tr>
<td>Platforms Supported</td><td>{$platforms}</td>
</tr>




<tr>
<td>Lead Pixel</td><td><input type="text" value='<img src="{$SITE_URL}__advPixelArea___/adPixFire.php?camp={$oid}&aff_id={$uid}" width="1" height="1" />' class="form-control" />
<p style="font-size:12px; font-weight:bold; color:#666666; padding-top:5px;">Place this pixel link in your offer lead page.</p>

</td>
</tr>


<tr>
<td colspan="2"><a href="my_campaigns.php" class="btn btn-default">Back To My Campaigns</a></td>
</tr>


</table>



{/if}



</div>
<!--End Contents-->


{include file="footer.tpl.php"}