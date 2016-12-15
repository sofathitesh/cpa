{include file="header.tpl.php"}


<!--Page Title and User earnings overview-->
<div id="page_header">

<div class="pageTitle">
Create Campaign
</div>


<div class="liveCounters">

{include file="live_counters.tpl.php"}

</div>


</div>
<!--End Page Title and User eanrings overview-->

<!--Contents-->
<div id="content" >

<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>


<p>
 
  To advertise your own offers on other publishers sites, you can create campaign here

</p>


{if $error_msg ne ""}
<div class="alert alert-danger" style="width:65%"><img src="templates/images/cross.gif" alt="" /> {$error_msg}</div>
{elseif $success_msg ne ""}
<div class="alert alert-success" style="width:65%"><img src="templates/images/tick.gif" alt="" /> {$success_msg}</div>
{/if}


<form action="create_campaign.php" method="post" id="createCamp">
<input type="hidden" name="create" value="1" />
<table  class="table table-noborder" style="width:55%">

<tr><td>Offer Name</td><td><input type="text" name="name" value="{$name}"  class="form-control"  /></td></tr>
<tr><td>Description</td><td><textarea name="desc" class="form-control" >{$desc}</textarea></td></tr>
<tr><td>Offer Link</td><td><input type="text" name="url" value="{$url}"  class="form-control"  /></td></tr>
<tr><td>Leads</td><td><input type="text" name="limit" value="{$limit}" class="form-control"  /></td></tr>
<tr><td>Payout</td><td><input type="text" name="payout" value="{$payout}" class="form-control"  /></td></tr>
<tr><td>Countries</td><td><select name="countries[]" multiple="multiple"  class="form-control" style="height:200px"><option value="All">All Countries</option>{$countries}</select></td></tr>

<tr><td>UA Target</td><td><input type="checkbox" name="ua[Windows]" {if $ua.Windows ne ""} checked="checked" {/if} value="Windows" /> Windows &nbsp; <input type="checkbox" name="ua[Android]" {if $ua.Android ne ""} checked="checked" {/if} value="Android" /> Android &nbsp; <input type="checkbox" name="ua[iPhone]" {if $ua.iPhone ne ""} checked="checked" {/if} value="iPhone" /> iPhone &nbsp; <input type="checkbox" name="ua[iPad]" {if $ua.iPad ne ""} checked="checked" {/if} value="iPad" /> iPad &nbsp; <input type="checkbox" name="ua[All]" {if $ua.All ne "" || $ua eq ""} checked="checked" {/if} value="All" /> All Platforms</td></tr>

<tr><td>Category / Categories</td><td> <input type="text" name="cats" value="{$categories}" class="form-control"  /></td></tr>

<tr><td colspan="2" style="text-align:right; padding-top:8px"><input type="button" id="createNow" name="creatBtn" class="btn btn-info"  value="Create Campaign Offer" /></td></tr>




</table>
</form>


{literal}
<script type="text/javascript">

$(document).ready(function(){


    $('#createNow').click(function(e){
		
    e.preventDefault();
	$(this).attr('disabled', 'disabled');
	$(this).val('Creating Campaign, please wait...');
	$('#createCamp').submit();
  		
	});

	
});


</script>
{/literal}



</div>



<div class="gap20px">&nbsp;</div>
<div class="gap20px">&nbsp;</div>

{include file="footer.tpl.php"}


